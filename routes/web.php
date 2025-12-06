<?php

use App\Models\Courses;
use App\Models\Instructor;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ResetPasswordControl;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserProgressController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VideoProgressController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\CertificateController;

Route::get('/', [LandingController::class, 'showLanding']);

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

Route::get('/homepage', function () {
    $user = auth()->user();

    // Filter courses: quizzes count must match video_count
    $courses = Courses::withCount('quizzes')
        ->get()
        ->filter(function ($course) {
            return $course->quizzes_count == $course->video_count;
        });

    $uniqueCategories = $courses->pluck('category')->unique();

    return view('homepage', compact('user', 'courses', 'uniqueCategories'));
});

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


});

Route::get('/certificate/{userId}/{courseId}', [CertificateController::class, 'generate'])
        ->name('certificate.generate');
Route::get('/verify-certificate/{certificate_id}', [CertificateController::class, 'verify'])->name('certificate.verify');
Route::get('/pdf/view/{id}', [EnrollmentController::class, 'viewPDF'])
    ->name('secure.pdf.view');

Route::get('/guest/search', [CourseController::class, 'guest_user_search'])->name('guest.courses.search');