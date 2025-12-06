<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Admin;
use App\Models\Courses;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
 public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
       return redirect('/');
    }
     public function viewAdminDashboard(Request $request)
{
    // Total registered students (role = 2)
    $totalStudents = User::where('role', 2)->count();

    // Total available courses
    $totalCourses = Courses::count();

    // Total earnings (sum of enrolled courses' price)
    $totalEarn = Enrollment::join('courses', 'enrollments.course_id', '=', 'courses.id')
    ->sum(DB::raw('courses.price * 0.3'));


    // Unique students who enrolled

    // Monthly data
    $year = now()->year;
    $enrollments = Enrollment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(DISTINCT user_id) as total')
        )
        ->whereYear('created_at', $year)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->pluck('total', 'month');

    $monthlyData = array_fill(1, 12, 0);
    foreach ($enrollments as $month => $count) {
        $monthlyData[$month] = $count;
    }

    return view('Admin.admin_panel', [
        'totalStudents' => $totalStudents,
        'totalCourses' => $totalCourses,
        'totalEarn' => $totalEarn,
        'monthlyData' => array_values($monthlyData)
    ]);
}
 public function viewQuiz($courseId, $moduleNumber)
{
    $userId = auth()->id();

  
    $quiz = Quiz::where('course_id', $courseId)
                ->where('module_number', $moduleNumber)
                ->firstOrFail();

    
    $attemptExists = DB::table('quiz_submissions')  
        ->where('quiz_id', $quiz->id)
        ->where('user_id', $userId)
        ->exists();

    if ($attemptExists) {
        return redirect()->back()->with('error', 'You have already attempted this quiz.');
    }

    $course = Courses::findOrFail($courseId);
    $questions = $quiz->questions()->with('options')->get();

    return view('quiz.take_quiz', compact('course', 'quiz', 'questions', 'moduleNumber'));
}

}
