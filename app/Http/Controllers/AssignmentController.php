<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Notifications\NewAssignmentNotification;
use App\Models\User;
use App\Models\AssignmentSubmission;
use App\Notifications\AssignmentDeadlineUpdatedNotification;

class AssignmentController extends Controller
{
    public function create($courseId)
    {
        return view('Instructor.assignments.create', compact('courseId'));
    }
public function store(Request $request)
{
    $request->validate([
        'course_id' => 'required',
        'title' => 'required',
        'description' => 'required',
        'marks' => 'required|integer|min:1',
        'deadline' => 'required|date' ,
        'attachment' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,png,jpg,jpeg,zip|max:10240'

    ]);

    $assignment = Assignment::create([
        'course_id'  => $request->course_id,
        'created_by' => auth()->id(),
        'title'      => $request->title,
        'description'=> $request->description,
        'marks'      => $request->marks,   
        'deadline'   => $request->deadline
    ]);
    // OPTIONAL ATTACHMENT
if ($request->hasFile('attachment')) {
    $path = $request->file('attachment')->store('assignments', 'public');
    $assignment->attachment = $path;
    $assignment->save();
}

    $enrollments = Enrollment::where('course_id', $request->course_id)->get();

    foreach ($enrollments as $enrollment) {
        if ($enrollment->user) {
            $enrollment->user->notify(
                new NewAssignmentNotification($assignment)
            );
        }
    }

    return back()->with('success', 'Assignment Created');
}
public function studentAssignments($courseId)
{
    $course = \App\Models\Courses::findOrFail($courseId);

    $assignments = Assignment::where('course_id', $courseId)
                        ->latest()
                        ->get();

    return view('student.assignments', compact('course', 'assignments'));
}
public function submissions($id)
{
    $assignment = Assignment::findOrFail($id);
    $submissions = $assignment->submissions()->with('student')->get();

    return view('Instructor.assignments.submissions',
        compact('assignment','submissions'));
}
public function gradeForm($id)
{
    $submission = AssignmentSubmission::with('student','assignment')
        ->findOrFail($id);

    return view('Instructor.assignments.grade',
        compact('submission'));
}
public function grade(Request $request, $id)
{
    $submission = AssignmentSubmission::with('assignment')->findOrFail($id);

    $request->validate([
        'score' => 'required|integer|min:0|max:' . $submission->assignment->marks
    ]);

    $submission->update([
        'score' => $request->score,
        'status' => 'graded',
        'graded_at' => now()
    ]);
    // 🔔 Notify the student who submitted
    $submission->student->notify(
        new \App\Notifications\AssignmentGradedNotification($submission)
    );

    return redirect()->route('assignment.submissions',
        $submission->assignment_id)
        ->with('success','Graded Successfully');
}
public function edit($id)
{
    $assignment = Assignment::findOrFail($id);
    return view('Instructor.assignments.edit', compact('assignment'));
}
public function index($courseId)
{
    $assignments = Assignment::where('course_id', $courseId)
                    ->latest()
                    ->get();

    return view('Instructor.assignments.index',
        compact('assignments','courseId'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'deadline' => 'required|date'
    ]);

    $assignment = Assignment::findOrFail($id);

    $oldDeadline = $assignment->deadline;

    $assignment->deadline = $request->deadline;
    $assignment->save();

    // 🔔 Notify all enrolled students
    $enrollments = Enrollment::where('course_id', $assignment->course_id)->get();

    foreach ($enrollments as $enrollment) {
        $student = User::find($enrollment->user_id);

        if ($student) {
            $student->notify(
                new AssignmentDeadlineUpdatedNotification(
                    $assignment,
                    $oldDeadline
                )
            );
        }
    }

    return redirect()->back()->with('success', 'Deadline updated successfully!');
}


}