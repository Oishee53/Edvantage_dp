<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Courses;
use App\Models\Enrollment;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Assignment;
use App\Models\LiveSession;
use App\Models\CourseLiveSession;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
     public function manageUsers()
{
    $totalStudents = User::whereIn('role',[ User::ROLE_USER,User::ROLE_INSTRUCTOR])->count();
    $totalInstructors = User::where('role', User::ROLE_INSTRUCTOR)->count();
    $enrolledStudents = Enrollment::distinct('user_id')->count('user_id');

    return view('Student.manage_student', compact('totalStudents', 'totalInstructors', 'enrolledStudents'));
}
    public function enrolledStudents()
{
    $courses = Courses::with(['students'])->get();

    return view('Student.view_enrolled_student', compact('courses'));
}
public function allStudents()
{
    $students = User::whereIn('role', [User::ROLE_USER, User::ROLE_INSTRUCTOR])->get();                  
    return view('Student.view_all_student', compact('students'));
}
public function allInstructors()
{
    $users = User::where('role', User::ROLE_INSTRUCTOR)
    ->with('instructor')   // if using relationships
    ->get();
           
    return view('Student.view_all_instructors', compact('users'));
}

public function destroy($course_id, $student_id)
{
    $user = User::findOrFail($student_id);

    if ($user->role == User::ROLE_INSTRUCTOR) {
        $user->role = User::ROLE_USER; //  update role in the model
        $user->save(); // save the change
    }
    return redirect()->back()->with('success', 'Student unenrolled successfully.');
}
public function getMonthlyEnrollments()
{
    $year = now()->year;

    $enrollments = Enrollment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(DISTINCT user_id) as total')
        )
        ->whereYear('created_at', $year)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'month');

    // Initialize array with 12 months default to 0
    $monthlyData = array_fill(1, 12, 0);

    // Fill in months that have enrollments
    foreach ($enrollments as $month => $count) {
        $monthlyData[$month] = $count;
    }

    return response()->json(array_values($monthlyData));
}
public function calendar()
{
    return view('Student.calendar');
}
public function calendarEvents()
{
    $user = Auth::user();

    $courseIds = Enrollment::where('user_id', $user->id)
                            ->pluck('course_id')
                            ->toArray();

    $events = [];

    // If student has no enrollments, return empty events
    if (empty($courseIds)) {
        return response()->json($events);
    }

    /* LIVE CLASSES - FROM APPROVED COURSES */
   $approvedLiveClasses = CourseLiveSession::whereIn('course_id', $courseIds)
                                  ->whereNotNull('date')
                                  ->whereNotNull('start_time')
                                  ->orderBy('date')
                                  ->get();

    foreach ($approvedLiveClasses as $class) {
    $statusColor = match($class->status) {
        'live'  => '#dc2626',
        'ended' => '#10b981',
        default => '#2563eb'
    };

    $dateStr  = \Carbon\Carbon::parse($class->date)->format('Y-m-d');
    $startStr = \Carbon\Carbon::parse($class->start_time)->format('H:i:s');
    $endStr   = \Carbon\Carbon::parse($class->start_time)
                    ->addMinutes($class->duration_minutes)
                    ->format('H:i:s');

    $events[] = [
        'title' => $class->title ? 'LIVE: ' . $class->title : 'Live Session',
        'start' => $dateStr . 'T' . $startStr,
        'end'   => $dateStr . 'T' . $endStr,
        'color' => $statusColor,
        'extendedProps' => [
            'type'     => 'live_class',
            'duration' => $class->duration_minutes . ' mins',
            'status'   => $class->status
        ]
    ];
}

    /* LIVE CLASSES - FROM PENDING COURSES (instructor's pending courses) */
    $instructorCourses = \App\Models\PendingCourses::where('instructor_id', $user->id)
                                                   ->pluck('id')
                                                   ->toArray();

    if (!empty($instructorCourses)) {
        $pendingLiveClasses = LiveSession::whereIn('course_id', $instructorCourses)
                                         ->whereNotNull('date')
                                         ->whereNotNull('start_time')
                                         ->orderBy('date')
                                         ->get();

        foreach ($pendingLiveClasses as $class) {
            $statusColor = match($class->status) {
                'live' => '#dc2626',      // Red for live
                'ended' => '#10b981',     // Green for ended/recording available
                default => '#2563eb'      // Blue for scheduled
            };

            $events[] = [
                'title' => $class->title ? 'LIVE: ' . $class->title : 'Live Session',
                'start' => $class->date . 'T' . $class->start_time,
                'end' => $class->date . 'T' . \Carbon\Carbon::parse($class->start_time)->addMinutes($class->duration_minutes)->format('H:i'),
                'color' => $statusColor,
                'extendedProps' => [
                    'type' => 'live_class',
                    'duration' => $class->duration_minutes . ' mins',
                    'status' => $class->status
                ]
            ];
        }
    }

    /* ASSIGNMENT DEADLINES */
    if (!empty($courseIds)) {
        $assignments = Assignment::whereIn('course_id', $courseIds)
                                 ->orderBy('deadline')
                                 ->get();

        foreach ($assignments as $assignment) {
            $events[] = [
                'title' => 'DEADLINE: ' . $assignment->title,
                'start' => $assignment->deadline,
                'color' => '#f97316',
                'extendedProps' => [
                    'type' => 'assignment'
                ]
            ];
        }
    }

    // Sort by start time
    usort($events, function($a, $b) {
        return strtotime($a['start']) - strtotime($b['start']);
    });

    return response()->json($events);
}


}