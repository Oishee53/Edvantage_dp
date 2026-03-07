<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DiscussionForumController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LiveSessionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResetPasswordControl;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StudentFinalExamController;
use App\Http\Controllers\DiscussionForumController;
use App\Http\Controllers\NotebookController;
use App\Http\Controllers\PlatformChatbotController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\VideoProgressController;
use App\Http\Controllers\WishlistController;
use App\Models\Courses;
use App\Models\Instructor;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentSubmissionController;

Route::get('/', [LandingController::class, 'showLanding']);
Route::get('/my-courses/{courseId}/assignments', 
    [AssignmentController::class, 'studentAssignments']
)->name('course.assignments');

    

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// ----------------------------- Forget Password --------------------------//
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('forget-password', 'sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset', 'showLinkRequestForm');
});

// ---------------------------- Reset Password ----------------------------//
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('reset-password', 'updatePassword')->name('password.update');
    
});

Route::middleware('block-login')->group(function () {
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register',[AuthController::class,'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/guest/cart/add', [CartController::class, 'addToGuestCart'])->name('cart.guest.add');
Route::post('/guest/cart/remove', [CartController::class, 'removeFromGuestCart'])->name('guest.cart.remove');
Route::post('/cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.all');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.details');

Route::middleware(['auth','student'])->group(function () {

Route::get('/homepage', [UserController::class, 'homepage'])
    ->middleware(['auth','student'])
    ->name('homepage');


Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::get('/courses/enrolled', function () {
    return 'Enrolled courses page coming soon!';
});

Route::get('/browse',[CourseController::class, 'viewCourses'])->name('courses.all');

Route::get('/search', [CourseController::class, 'logged_in_search'])->name('courses.search');

Route::get('/wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.all');
Route::post('/wishlist/{id}', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');

Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/wishlist/{id}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');

Route::post('/make-payment', [PaymentController::class, 'makePayment'])->name('make.payment');

Route::get('/my-courses', [EnrollmentController::class, 'userEnrolledCourses'])->name('courses.enrolled');

Route::get('/my-courses/{courseId}/module/{moduleId}', [EnrollmentController::class, 'viewModuleResource'])->name('user.module.resource');

Route::get('/my-courses/{courseId}', [EnrollmentController::class, 'viewCourseModules'])->name('user.course.modules');
Route::get('/my-courses/{courseId}/module/{moduleId}', [EnrollmentController::class, 'viewModuleResource'])->name('user.module.resource');
Route::get('/inside-module/{courseId}/{moduleNumber}', [EnrollmentController::class, 'showInsideModule'])->name('inside.module');

// Show quiz start page for a module
Route::get('/user/courses/{course}/modules/{module}/quiz', [UserQuizController::class, 'startQuiz'])->name('user.quiz.start');

Route::post('/quiz/submit/{course}/{moduleNumber}', [UserQuizController::class, 'submitQuiz'])->name('user.quiz.submit');
Route::get('/quiz/result/{course}/{moduleNumber}', [UserQuizController::class, 'result'])->name('user.quiz.result');

Route::get('/courses/{courseId}/final-exam', [StudentFinalExamController::class, 'show'])
        ->name('student.final-exam.show');
    
    // Start or continue taking the exam
    Route::post('/final-exams/{examId}/start', [StudentFinalExamController::class, 'start'])
        ->name('student.final-exam.start');
    
    // Alternative GET route for start (for direct links)
    Route::get('/final-exams/{examId}/start', [StudentFinalExamController::class, 'start'])
        ->name('student.final-exam.start-get');
    
    // Upload answer image (AJAX endpoint)
    Route::post('/final-exam-submissions/{submissionId}/questions/{questionId}/upload-answer', 
        [StudentFinalExamController::class, 'uploadAnswer'])
        ->name('student.final-exam.upload-answer');
    
    // Delete answer image (AJAX endpoint)
    Route::delete('/final-exam-submissions/{submissionId}/questions/{questionId}/delete-image', 
        [StudentFinalExamController::class, 'deleteAnswerImage'])
        ->name('student.final-exam.delete-image');
    
    // Submit the exam
    Route::post('/final-exam-submissions/{submissionId}/submit', 
        [StudentFinalExamController::class, 'submit'])
        ->name('student.final-exam.submit');
    
    // View exam results after grading
    Route::get('/final-exam-submissions/{submissionId}/result', 
        [StudentFinalExamController::class, 'result'])
        ->name('student.final-exam.result');
    
    // Get remaining time (AJAX endpoint for timer)
    Route::get('/final-exam-submissions/{submissionId}/remaining-time', 
        [StudentFinalExamController::class, 'getRemainingTime'])
        ->name('student.final-exam.remaining-time');

Route::post('/video-progress/save', [VideoProgressController::class, 'save'])->name('video.progress.save');

Route::get('/my-progress', [UserProgressController::class, 'index'])->name('user.progress');

Route::get('/purchase-history', [EnrollmentController::class, 'purchaseHistory'])->name('purchase.history');
Route::get('/instructor/signup', function(){
    return view('Instructor.instructor_signup');
})->name('ins.signup');
Route::post('/instructor/signup', [InstructorController::class, 'register'])->name('instructor.register');
Route::post('instructor/payment_setup', [InstructorController::class, 'savePaymentSetup'])->name('instructor.payout.save');

Route::post('/post_question', [QuestionController::class, 'store'])->name('questions.store');
Route::get('/student/questions/{id}', [NotificationController::class, 'show'])
    ->name('student.questions.show');

Route::get('/notifications/{notification}/mark-read-redirect', 
    [NotificationController::class, 'markAsReadAndRedirect'])
    ->name('notifications.markAsReadAndRedirect');
});

Route::get('/certificate/{userId}/{courseId}', [CertificateController::class, 'generate'])
        ->name('certificate.generate');
Route::get('/verify-certificate/{certificate_id}', [CertificateController::class, 'verify'])->name('certificate.verify');
Route::get('/pdf/view/{id}', [EnrollmentController::class, 'viewPDF'])
    ->name('secure.pdf.view');

Route::get('/guest/search', [CourseController::class, 'guest_user_search'])->name('guest.courses.search');

Route::post('/discussion/thread', [DiscussionForumController::class, 'storeThread'])
        ->name('discussion.thread.store');

Route::get('/discussion/forum/{forum}/thread/{thread}', [DiscussionForumController::class, 'showThread'])
        ->name('discussion.thread.show');

Route::get('/discussion/forum/{forum}', [DiscussionForumController::class, 'showForum'])
        ->name('discussion.forum.show');

Route::post('/discussion/thread/{thread}/reply', [DiscussionForumController::class, 'storeReply'])
        ->name('discussion.reply.store');

Route::post('/discussion/post/{post}/react/{type}', [DiscussionForumController::class, 'toggleReaction'])
        ->name('discussion.react');

Route::post('/course/rate', [CourseController::class, 'submitRating'])
    ->name('course.rate')
    ->middleware('auth');


Route::get('/courses/{id}', [CourseController::class, 'show'])
    ->name('courses.details');
    Route::get('/instructor/live-class/{course_id}', [InstructorController::class, 'liveClassForm'])->name('live.class.form');

Route::post('/instructor/live-class/store', [InstructorController::class, 'storeLiveClass'])->name('live.class.store');
Route::middleware(['auth'])->group(function () {
     Route::get('/instructor/course/{courseId}/assignments',
    [AssignmentController::class, 'index'])
    ->name('instructor.assignments.index');
    // Instructor - Create Assignment
    Route::get('/course/{id}/assignment/create', [AssignmentController::class, 'create']);
    Route::post('/assignment/store', [AssignmentController::class, 'store']);
     
    Route::get('/assignment/{id}/edit',
    [AssignmentController::class, 'edit'])
    ->name('assignment.edit');



Route::post('/chatbot/ask', [PlatformChatbotController::class, 'chat'])->name('chatbot.ask');







Route::middleware(['auth'])->prefix('courses/{courseId}/notebook')->group(function () {

    // Main notebook page (per course)
    Route::get('/', [NotebookController::class, 'index'])->name('notebook.index');

    // Upload a document
    Route::post('/upload', [NotebookController::class, 'upload'])->name('notebook.upload');

    // Ask a question (RAG)
    Route::post('/ask', [NotebookController::class, 'ask'])->name('notebook.ask');

    // Delete a document
    Route::delete('/documents/{documentId}', [NotebookController::class, 'deleteDocument'])->name('notebook.deleteDocument');

    // Clear chat history
    Route::delete('/history', [NotebookController::class, 'clearHistory'])->name('notebook.clearHistory');
});



Route::get('/courses/{course}/session/{session}/watch', [LiveSessionController::class, 'watch'])
    ->name('student.live_session.watch');
    Route::post('/assignment/{id}/update',
    [AssignmentController::class, 'update'])
    ->name('assignment.update');

    // Instructor - View Submissions
    Route::get('/instructor/assignment/{id}/submissions',
        [AssignmentController::class, 'submissions'])
        ->name('assignment.submissions');

    // Instructor - Grade Form
    Route::get('/instructor/submission/{id}/grade',
        [AssignmentController::class, 'gradeForm'])
        ->name('assignment.grade.form');

    // Instructor - Save Grade
    Route::post('/instructor/submission/{id}/grade',
        [AssignmentController::class, 'grade'])
        ->name('assignment.grade');

    // Student - Submit Assignment
    Route::post('/assignment/submit', [AssignmentSubmissionController::class, 'store'])
        ->name('assignment.submit');
        // Student - Delete Uploaded File (BEFORE deadline)
    Route::delete('/submission/file/{id}',
    [AssignmentSubmissionController::class, 'deleteFile'])
    ->name('submission.file.delete');

    // Student - View Assignment Page
    Route::get('/assignment/{id}', [AssignmentSubmissionController::class, 'show'])
        ->name('assignment.show');

        Route::get('/assignment/result/{id}', function($id) {
    $submission = \App\Models\AssignmentSubmission::with('assignment')
        ->findOrFail($id);

    return view('Student.assignments.result', compact('submission'));
})->name('assignment.result');

});
