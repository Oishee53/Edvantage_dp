<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseNotificatioController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\InstructorFinalExamController; // ADD THIS
use App\Http\Controllers\LiveSessionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PendingCourseController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UploadController;
use App\Models\Courses;
use App\Models\Enrollment;
use App\Models\PendingCourses;
use App\Models\Resource;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use MuxPhp\Models\Upload;

// ===================
// Public / Login Routes
// ===================
Route::post('/admin/login', [AdminController::class, 'adminLogin']);
Route::post('/logout', [AdminController::class, 'logout']);

// ===================
// Admin-Only Routes
// ===================
Route::middleware(['auth', 'admin'])->group(function () {

    // Admin Dashboard
    Route::get('/admin_panel', [AdminController::class, 'viewAdminDashboard']);
    // Manage Courses
    Route::get('/admin_panel/manage_courses', function () {
        $courses = Courses::all();
        return view('courses.manage_courses', compact('courses'));
    });
    
    Route::post('/admin/manage_courses/create', [CourseController::class, 'store']);
    Route::get('/admin_panel/manage_courses/view-list', [CourseController::class, 'viewAll']);
    Route::get('/admin_panel/manage_courses/delete-course', [CourseController::class, 'deleteCourse']);

    Route::get('/admin_panel/manage_courses/edit-list', [CourseController::class,'editList']);

    Route::get('/admin_panel/manage_resources', [ResourceController::class,'viewCourses']);
    
    // Manage Users
    Route::get('/admin_panel/manage_user', [StudentController::class, 'manageUsers']);
    Route::get('/admin_panel/manage_user/view_enrolled_student', [StudentController::class, 'enrolledStudents']);
    Route::get('/admin_panel/manage_user/unenroll_instructor/{instructor_id}', [InstructorController::class, 'destroy']);
    Route::get('/admin_panel/manage_user/view_all_student', [StudentController::class, 'allStudents']);
    Route::delete('/admin_panel/manage_user/unenroll_student/{course_id}/{student_id}', [StudentController::class, 'destroy']);

    // Quizzes & Modules
    Route::get('/admin_panel/courses/{course}/modules/{module}/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('/courses/{course}/modules/{module}/quizzes', [QuizController::class, 'store'])->name('quiz.store');

    // Upload & Cloud
    Route::post('/admin/upload', [UploadController::class, 'upload'])->name('admin.upload');
    Route::post('/admin/cloud', [UploadController::class, 'uploadToCloudinary'])->name('upload.cloudinary');
    Route::post('/admin/mux-upload-url', [UploadController::class, 'getUploadUrl'])->name('mux.direct.upload.url');
    
    // Pending Courses
    Route::get('/pending-courses', [CourseNotificatioController::class, 'index'])
        ->name('admin.pending_courses');
    Route::get('/submitted-courses/{course}/review', [CourseNotificatioController::class, 'show_modules'])
        ->name('admin.courses.review');
    Route::post('/submitted-courses/{course}/approve', [CourseNotificatioController::class, 'approve'])
        ->name('admin.courses.approve');
    Route::post('/submitted-courses/{course}/reject', [CourseNotificatioController::class, 'reject'])
        ->name('admin.courses.reject');
    Route::post('/admin/courses/{course}/ask-edit', [CourseNotificatioController::class, 'askForEdit'])->name('admin.courses.ask-edit');
    Route::get('/admin_panel/manage_user/view_all_instructors', [StudentController::class, 'allInstructors']);

});

Route::get('/manage_courses/add', [CourseController::class, 'create']);
Route::get('/admin_panel/manage_resources/{course_id}/modules', [ResourceController::class, 'showModules'])->name('modules.show');
Route::get('/admin_panel/courses/{course}/modules/{module}/module/create', [ResourceController::class, 'addModule'])->name('module.create');
Route::get('/admin_panel/manage_resources/{course_id}/modules/{module_id}/edit', [ResourceController::class, 'editModule']);
Route::post('/resources/{course_id}/modules/{module_id}/upload', [UploadController::class, 'handleUpload'])->name('upload.resources');
Route::get('/admin/upload', function() {
    return view('Resources.upload');
})->name('admin.upload.form');
Route::get('/admin/cloud', function() {
    return view('Resources.uploadToCloud');
});
Route::get('/admin/view', function() {
    return view('Resources.viewVideo');
});

Route::get('/admin/courses/{course}/live-session/{session}/review',
    [CourseNotificatioController::class, 'reviewLiveSession'])
    ->name('admin.live_session.review');

Route::get('admin/manage_courses/courses/{id}/edit', [CourseController::class, 'editCourse']);
Route::put('admin/manage_courses/courses/{id}/edit', [CourseController::class, 'update']);
Route::delete('/admin_panel/manage_courses/delete-course/{id}', [CourseController::class, 'destroy']);
Route::get('/admin_panel/courses/{course}/modules/{module}/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
Route::post('/courses/{course}/modules/{module}/quizzes', [QuizController::class, 'store'])->name('quiz.store');

// ===================
// Instructor Routes
// ===================
Route::middleware(['auth'])->prefix('instructor')->group(function () {
    
    // 🆕 FINAL EXAM ROUTES - MOVED HERE FROM ADMIN SECTION
    Route::get('/final-exams', [InstructorFinalExamController::class, 'index'])
        ->name('instructor.final-exams.index');
    
    Route::get('/final-exams/create', [InstructorFinalExamController::class, 'create'])
        ->name('instructor.final-exams.create');
    
    Route::post('/final-exams', [InstructorFinalExamController::class, 'store'])
        ->name('instructor.final-exams.store');
    
    Route::get('/final-exams/{id}', [InstructorFinalExamController::class, 'show'])
        ->name('instructor.final-exams.show');
    
    Route::get('/final-exams/{id}/edit', [InstructorFinalExamController::class, 'edit'])
        ->name('instructor.final-exams.edit');
    
    Route::put('/final-exams/{id}', [InstructorFinalExamController::class, 'update'])
        ->name('instructor.final-exams.update');
    
    Route::delete('/final-exams/{id}', [InstructorFinalExamController::class, 'destroy'])
        ->name('instructor.final-exams.destroy');
    
    Route::post('/final-exams/{id}/publish', [InstructorFinalExamController::class, 'publish'])
        ->name('instructor.final-exams.publish');
    
    Route::post('/final-exams/{id}/unpublish', [InstructorFinalExamController::class, 'unpublish'])
        ->name('instructor.final-exams.unpublish');
    
    // Grading Routes
    Route::get('/final-exams/{examId}/submissions', [InstructorFinalExamController::class, 'viewSubmissions'])
        ->name('instructor.final-exams.submissions');
    
    Route::get('/final-exam-submissions/{submissionId}/grade', [InstructorFinalExamController::class, 'gradeSubmission'])
        ->name('instructor.final-exams.grade-submission');
    
    Route::post('/final-exam-submissions/{submissionId}/save-grades', [InstructorFinalExamController::class, 'saveGrades'])
        ->name('instructor.final-exams.save-grades');
    
    // Instructor — go live & end stream (on approved courses)
    Route::get('/instructor/courses/{course}/sessions/{session}/go-live',
        [LiveSessionController::class, 'goLive'])
        ->name('instructor.live_session.go_live');

    Route::put('/instructor/courses/{course}/sessions/{session}/end',
        [LiveSessionController::class, 'endStream'])
        ->name('instructor.live_session.end');

});

Route::post('/courses/{course}/session/{session}/end', [LiveSessionController::class, 'endStream'])
    ->name('instructor.live_session.end_stream');

// Other Instructor Routes (without prefix)
Route::get('/instructor_homepage', [InstructorController::class, 'viewInstructorHomepage'])
        ->name('instructor.dashboard');
Route::prefix('instructor')->group(function () {
    Route::get('/manage_courses', function () {
        $instructorId = auth()->user()->id;
        $courses = Courses::where('instructor_id', $instructorId)->get();
        $pendingCourses = PendingCourses::where('instructor_id', $instructorId)->get();
        return view('Instructor.instructor_manage_courses', compact('courses','pendingCourses','instructorId'));
    })->name('instructor.courses');

    Route::post('/manage_courses/create', [PendingCourseController::class, 'store']);

    Route::get('/manage_resources/{course_id}/modules', [PendingCourseController::class, 'showModules']);
    Route::get('/manage_resources/{course_id}/modules/{module_id}/edit', [PendingCourseController::class, 'editModule']);
    Route::post('/resources/{course_id}/modules/{module_id}/upload', [PendingCourseController::class, 'handleUpload'])
        ->name('upload.instructor.resources');

    Route::get('/courses/{course}/modules/{module}/module/create', [PendingCourseController::class, 'addModule'])
        ->name('module.instructor.create');

});


Route::get('/instructor/notifications/{id}', [NotificationController::class, 'viewNotification'])
    ->name('instructor.notifications.view')
    ->middleware('auth');

Route::get('/instructor/questions/{id}', [QuestionController::class, 'show'])
    ->name('instructor.questions.show');

Route::post('/instructor/questions/{id}/reject', [QuestionController::class, 'reject'])
    ->name('instructor.reject');

Route::post('/instructor/questions/{id}/answer', [QuestionController::class, 'answer'])
    ->name('instructor.answer');
Route::get('/instructor/{course}/manage_resources', [CourseNotificatioController::class, 'sendNotification'])
    ->name('instructor.manage_resources');

Route::get('/view_pending_resources/{courseId}/{moduleNumber}', [PendingCourseController::class, 'showInsideModule'])
     ->name('view.pending.resources');
     
Route::get('/view/inside-module/{courseId}/{moduleNumber}', [ResourceController::class, 'showInsideModule'])->name('inside.module2');
Route::get('/instructor/rejected_courses', [InstructorController::class, 'showRejectedCourses'])->name('rejected.course.show');

Route::get('/instructor/manage_resources/{course}/sessions/{session}/edit', 
    [LiveSessionController::class, 'edit'])
    ->name('instructor.live_session.edit');

Route::put('/instructor/manage_resources/{course}/sessions/{session}/edit',
    [LiveSessionController::class, 'update'])
    ->name('instructor.live_session.update');


// Notification routes
Route::middleware('auth')->group(function () {
    // Mark all notifications as read
    Route::post('/notifications/mark-all-read', [InstructorController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
    
    // Mark individual notification as read
    Route::post('/notifications/{id}/mark-read', [InstructorController::class, 'markNotificationAsRead'])->name('notifications.mark-read');
    
    // View specific notification (optional)
    Route::get('/notifications/{id}/view', [InstructorController::class, 'viewNotification'])->name('notifications.view');
    Route::get('/notifications/{id}/read', [CourseController::class, 'markAsReadNotification'])
    ->name('notifications.read');

});

Route::post('/courses/{course}/session/{session}/upload-recording',
    [LiveSessionController::class, 'uploadRecording'])
    ->name('live_session.upload_recording');

Route::patch('/instructor/manage_resources/{course_id}/session/{session_number}/schedule',
    [LiveSessionController::class, 'updateSchedule'])
    ->name('live_session.update_schedule');

// For admin (if admins use a different URL prefix):
Route::patch('/admin_panel/manage_resources/{course_id}/session/{session_number}/schedule',
    [LiveSessionController::class, 'updateSchedule'])
    ->name('admin.live_session.update_schedule');

Route::post('/instructor/live-class/store', [LiveSessionController::class, 'storeLiveHybridClass'])->name('live.class.store');

Route::get('/courses/{id}', [CourseController::class, 'show'])
    ->name('courses.details');
    Route::get('/instructor/live-class/{course_id}', [InstructorController::class, 'liveClassForm'])->name('live.class.form');