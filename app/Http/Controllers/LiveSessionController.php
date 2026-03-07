<?php

namespace App\Http\Controllers;

use App\Models\CourseLiveSession;
use App\Models\Enrollment;
use App\Models\LiveSession;
use App\Models\PendingCourses;
use App\Models\User;
use App\Notifications\LiveClassScheduledNotification;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class LiveSessionController extends Controller
{
    /**
     * Show the schedule + PDF upload form for a single session.
     */
    public function edit($course_id, $session_number)
    {
        $course = PendingCourses::findOrFail($course_id);

        if ($session_number < 1 || $session_number > $course->video_count) {
            abort(404);
        }

        $session = LiveSession::where('course_id', $course_id)
                              ->where('session_number', $session_number)
                              ->first();

        return view('Instructor.edit_live_session', compact('course', 'session', 'session_number'));
    }

    /**
     * Save or update schedule + PDF for a pending session.
     */
    public function update(Request $request, $course_id, $session_number)
    {
        $course = PendingCourses::findOrFail($course_id);

        if ($session_number < 1 || $session_number > $course->video_count) {
            abort(404);
        }

        $request->validate([
            'title'            => 'nullable|string|max:255',
            'date'             => 'required|date|after_or_equal:today',
            'start_time'       => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15',
            'pdf'              => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $liveSession = LiveSession::firstOrNew([
            'course_id'      => $course_id,
            'session_number' => $session_number,
        ]);

        $liveSession->title            = $request->title;
        $liveSession->date             = $request->date;
        $liveSession->start_time       = $request->start_time;
        $liveSession->duration_minutes = $request->duration_minutes;

        if ($request->hasFile('pdf')) {
            try {
                $originalName = pathinfo($request->file('pdf')->getClientOriginalName(), PATHINFO_FILENAME);

                $result = Cloudinary::uploadApi()->upload($request->file('pdf')->getRealPath(), [
                    'resource_type'   => 'raw',
                    'folder'          => "course_{$course_id}/session_{$session_number}",
                    'public_id'       => $originalName,
                    'format'          => 'pdf',
                    'overwrite'       => true,
                    'use_filename'    => true,
                    'unique_filename' => false,
                ]);

                $liveSession->pdf = $result['secure_url'];

            } catch (\Exception $e) {
                Log::error('Session PDF upload failed:', ['error' => $e->getMessage()]);
                return back()->withErrors(['pdf' => 'PDF upload failed: ' . $e->getMessage()]);
            }
        }

        $liveSession->save();

        return redirect("/instructor/manage_resources/{$course_id}/modules")
               ->with('success', 'Session saved successfully!');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // LIVE STREAM — WebRTC via PeerJS (no third party service needed)
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Instructor goes live.
     * Generates a unique peer ID for this session and marks it live.
     */
    public function goLive($course_id, $session_number)
    {
        $session = CourseLiveSession::where('course_id', $course_id)
                                    ->where('session_number', $session_number)
                                    ->firstOrFail();

        if ($session->status === 'ended') {
            return back()->with('error', 'This session has already ended.');
        }

        // Enforce go-live window: only from scheduled start_time up to 30 mins after
        if ($session->date && $session->start_time) {
            $scheduledStart = \Carbon\Carbon::parse($session->date . ' ' . $session->start_time);
            $goLiveUntil    = $scheduledStart->copy()->addMinutes(30);

            if (now()->lt($scheduledStart)) {
                return back()->with('error',
                    'This session is scheduled for '
                    . $scheduledStart->format('d M Y \a\t h:i A')
                    . '. You can go live starting from that time.');
            }

            if (now()->gt($goLiveUntil)) {
                return back()->with('error',
                    'The go-live window for this session has passed ('
                    . $scheduledStart->format('h:i A') . ' – '
                    . $goLiveUntil->format('h:i A') . '). Please reschedule.');
            }
        } elseif ($session->date && !$session->start_time) {
            return back()->with('error',
                'Please set a start time for this session before going live.');
        } else {
            return back()->with('error',
                'Please schedule this session (date + start time) before going live.');
        }

        // Generate a stable peer ID for this session
        // Format: live-{course_id}-{session_number}
        $peerId = 'live-' . $course_id . '-' . $session_number;

        $session->update([
            'status'          => 'live',
            'daily_room_name' => $peerId, // reusing column to store peer ID
        ]);

        return view('Instructor.go_live', compact('session', 'peerId', 'course_id', 'session_number'));
    }

    /**
     * Instructor ends the live stream.
     */
    public function endStream($course_id, $session_number)
    {
        $session = CourseLiveSession::where('course_id', $course_id)
                                    ->where('session_number', $session_number)
                                    ->firstOrFail();

        if ($session->status !== 'live') {
            return back()->with('error', 'No active stream found for this session.');
        }

        $session->update(['status' => 'ended']);

        return redirect("/instructor/manage_courses")
               ->with('success', 'Live stream ended. Recording will be available shortly.');
    }

    /**
     * Upload recording blob from instructor browser to Cloudinary.
     * Called automatically by JS when instructor ends stream.
     */
    public function uploadRecording(Request $request, $course_id, $session_number)
    {
        $request->validate([
            'recording' => 'required|file|max:512000', // 500MB max
        ]);

        $session = CourseLiveSession::where('course_id', $course_id)
                                    ->where('session_number', $session_number)
                                    ->firstOrFail();

        try {
            $result = Cloudinary::uploadApi()->upload(
                $request->file('recording')->getRealPath(),
                [
                    'resource_type' => 'video',
                    'folder'        => "recordings/course_{$course_id}",
                    'public_id'     => "session_{$session_number}",
                    'overwrite'     => true,
                ]
            );

            $session->update(['recording_url' => $result['secure_url']]);

            Log::info('Recording uploaded for session', [
                'course_id'      => $course_id,
                'session_number' => $session_number,
                'url'            => $result['secure_url'],
            ]);

            return response()->json(['success' => true, 'url' => $result['secure_url']]);

        } catch (\Exception $e) {
            Log::error('Recording upload failed:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Student watches the live session or recording.
     */
    public function watch($course_id, $session_number)
    {
        $session = CourseLiveSession::where('course_id', $course_id)
                                    ->where('session_number', $session_number)
                                    ->firstOrFail();

        // Peer ID is stored in daily_room_name column
        $peerId = $session->daily_room_name;

        return view('Student.watch_live', compact('session', 'peerId', 'course_id', 'session_number'));
    }

        public function storeLiveHybridClass(Request $request)
    {
        $request->validate([
            'course_id'        => 'required|exists:courses,id',
            'title'            => 'required|string|max:255',
            'date'             => 'required|date|after_or_equal:today',
            'start_time'       => 'required|date_format:H:i',
            'duration_minutes' => 'required|integer|min:15|max:480',
        ]);

        // Auto-assign next session_number for this course
        $nextNumber = CourseLiveSession::where('course_id', $request->course_id)
            ->max('session_number') + 1;

        $session = CourseLiveSession::create([
            'course_id'        => $request->course_id,
            'session_number'   => $nextNumber,
            'title'            => $request->title,
            'date'             => $request->date,
            'start_time'       => $request->start_time,
            'duration_minutes' => $request->duration_minutes,
            'status'           => 'scheduled',
        ]);

        // Notify enrolled students
        $studentIds = Enrollment::where('course_id', $request->course_id)->pluck('user_id');
        $students   = User::whereIn('id', $studentIds)->get();

        if ($students->isNotEmpty()) {
            Notification::send($students, new LiveClassScheduledNotification($session));
        }

        return back()->with('success', 'Live class scheduled successfully.');
    }
}