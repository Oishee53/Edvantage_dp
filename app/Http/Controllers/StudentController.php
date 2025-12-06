<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Courses;
use App\Models\Enrollment;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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



}
