<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View; // ← important
use App\Services\MuxService;
use App\Models\CourseNotification;  // ← import your model

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MuxService::class, function ($app) {
            return new MuxService();
        });
    }

    public function boot(): void
    {
        // Register admin routes
        Route::middleware('web')
            ->group(base_path('routes/admin.php'));
  Schema::defaultStringLength(191);
        // Sidebar pending courses count for all admin views
        View::composer('Admin.*', function ($view) {
            $pendingCoursesCount = CourseNotification::where('status', 'pending')->count();
            $view->with('pendingCoursesCount', $pendingCoursesCount);
        });
        View::composer('Resources.*', function ($view) {
            $pendingCoursesCount = CourseNotification::where('status', 'pending')->count();
            $view->with('pendingCoursesCount', $pendingCoursesCount);
        });
        View::composer('courses.*', function ($view) {
            $pendingCoursesCount = CourseNotification::where('status', 'pending')->count();
            $view->with('pendingCoursesCount', $pendingCoursesCount);
        });
        View::composer('Instructor.*', function ($view) {
            $pendingCoursesCount = CourseNotification::where('status', 'pending')->count();
            $view->with('pendingCoursesCount', $pendingCoursesCount);
        });
        View::composer('Student.*', function ($view) {
            $pendingCoursesCount = CourseNotification::where('status', 'pending')->count();
            $view->with('pendingCoursesCount', $pendingCoursesCount);
        });
    }
}
