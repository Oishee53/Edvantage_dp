<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Carbon\Carbon;
use App\Models\AssignmentSubmissionFile;
use App\Notifications\AssignmentSubmittedNotification;
use App\Models\User;
class AssignmentSubmissionController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'assignment_id' => 'required|exists:assignments,id',
        'files.*' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
    ]);

    $assignment = Assignment::findOrFail($request->assignment_id);

    // Deadline check (Dhaka timezone)
    if (Carbon::now('Asia/Dhaka')->gt(
        Carbon::parse($assignment->deadline, 'Asia/Dhaka')
    )) {
        return back()->with('error', 'Deadline Passed. Submission closed.');
    }

    // Check if submission already exists
    $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
        ->where('student_id', auth()->id())
        ->first();

    if (!$submission) {
        $submission = AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id' => auth()->id(),
            'submitted_at' => now(),
            'status' => 'submitted'
        ]);
    }
    // 🔔 Notify instructor only when submission is first created
if ($submission->wasRecentlyCreated) {

    $instructor = $assignment->course->instructor;

    if ($instructor) {
        $instructor->notify(
            new AssignmentSubmittedNotification($submission)
        );
    }
}

    // Store multiple files
    foreach ($request->file('files') as $file) {
        $path = $file->store('assignments', 'public');

        $submission->files()->create([
            'file_path' => $path
        ]);
    }

    return redirect('/my-courses/' . $assignment->course_id)
       ->with('success','Assignment submitted successfully');
}
   public function show($id)
{
    $assignment = Assignment::findOrFail($id);

    $submission = AssignmentSubmission::where('assignment_id', $id)
        ->where('student_id', auth()->id())
        ->first();

    // ✅ If assignment is graded → show result page
    if ($submission && $submission->status === 'graded') {
        return view('Student.assignments.result', compact('submission'));
    }

    // ✅ Otherwise show submit page
    return view('Student.assignments.submit', compact('assignment'));
}
public function deleteFile($id)
{
    $file = AssignmentSubmissionFile::findOrFail($id);

    $assignment = $file->submission->assignment;

    if (now()->gt(\Carbon\Carbon::parse($assignment->deadline))) {
        return back()->with('error', 'Deadline Passed. Cannot delete.');
    }

    \Storage::disk('public')->delete($file->file_path);

    $file->delete();

    return back()->with('success', 'File Deleted Successfully');
}
}