<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\CourseRating;
use App\Models\UserSearch;
use App\Models\PendingCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\CourseDeleteNotification;

class CourseController extends Controller
{
    public function viewCourses()
    {
        $courses = Courses::all();
        $user = auth()->user();

        // ✅ FIX: use category_id
        $uniqueCategories = $courses->pluck('category')->unique();

        return view('courses.all_courses', compact('user', 'courses', 'uniqueCategories'));
    }

    public function show($id)
    {
        $course = Courses::with([
            'instructor',
            'ratings.user'
        ])->findOrFail($id);

        $user = auth()->user();
        $liveSessions = \App\Models\CourseLiveSession::where('course_id', $id)
                    ->orderBy('date')
                    ->get();

        return view('courses.course_details', compact('course', 'user', 'liveSessions'));
    }

    public function create()
    {
        return view('courses.create_course');
    }

    public function viewAll()
    {
        $courses = Courses::all();
        return view('courses.view_all_courses', compact('courses'));
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $course = Courses::find($id);

        if ($course) {
            $courseName = $course->title ?? 'Untitled Course';
            $course->delete();

            if ($user->role == 2) {
                $instructor = $course->instructor ?? null;

                if ($instructor) {
                    $instructor->notify(
                        new CourseDeleteNotification(
                            $course,
                            "Admin deleted course '{$courseName}'."
                        )
                    );
                }
            }
        } else {
            $pendingCourse = PendingCourses::findOrFail($id);
            $pendingCourse->delete();
        }

        return redirect()->back()->with('success', 'Course deleted successfully!');
    }

    public function logged_in_search(Request $request)
    {
        $searchTerm = $request->get('search');
        $user = auth()->user();

        if (empty($searchTerm)) {
            return redirect()->route('home');
        }

        //  Save search keyword (used by RecommendationService)
        UserSearch::create([
            'user_id' => $user->id,
            'keyword' => $searchTerm,
        ]);

        //  FIX: removed invalid category search
       $courses = Courses::where(function ($q) use ($searchTerm) {

    //  FIRST: match category (for navbar clicks)
    $q->where('category', 'LIKE', "%{$searchTerm}%")

      //  FALLBACK: normal text search
      ->orWhere('title', 'LIKE', "%{$searchTerm}%")
      ->orWhere('description', 'LIKE', "%{$searchTerm}%");

})->paginate(12);

        //  FIX: use category_id
        $uniqueCategories = Courses::distinct()->pluck('category');

        return view(
            'user.logged_in_search_results',
            compact('courses', 'user', 'searchTerm', 'uniqueCategories')
        );
    }

    public function guest_user_search(Request $request)
    {
        $searchTerm = $request->get('search');

        if (empty($searchTerm)) {
            return redirect()->route('home');
        }

        //  FIX: removed invalid category search
       $courses = Courses::where(function ($q) use ($searchTerm) {

    //  CATEGORY-FIRST search
    $q->where('category', 'LIKE', "%{$searchTerm}%")
      ->orWhere('title', 'LIKE', "%{$searchTerm}%")
      ->orWhere('description', 'LIKE', "%{$searchTerm}%");

})->paginate(12);


        //  FIX: use category_id
        $uniqueCategories = Courses::distinct()->pluck('category');

        return view(
            'user.guest_user_search_results',
            compact('courses', 'searchTerm', 'uniqueCategories')
        );
    }

    public function editList()
    {
        $courses = Courses::all();
        return view('courses.course_list', compact('courses'));
    }

    public function editCourse($id)
    {
        $course = Courses::find($id) ?? PendingCourses::findOrFail($id);
        return view('courses.edit_course', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Courses::find($id) ?? PendingCourses::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'video_count' => 'required|integer|min:1',
            'approx_video_length' => 'required|integer|min:1',
            'total_duration' => 'required|numeric|min:0.1',
            'price' => 'required|numeric|min:0',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'video_count' => $request->video_count,
            'approx_video_length' => $request->approx_video_length,
            'total_duration' => $request->total_duration,
            'price' => $request->price,
        ];

        if ($request->hasFile('image')) {
            if ($course->image && Storage::disk('public')->exists($course->image)) {
                Storage::disk('public')->delete($course->image);
            }

            $updateData['image'] = $request->file('image')->store('course_images', 'public');
        }

        $course->update($updateData);

        $user = auth()->user();

        if ($user->role === 2) {
            return redirect('/admin_panel/manage_courses')
                ->with('success', 'Course updated successfully!');
        }

        if ($user->role === 3) {
            return redirect('/instructor/manage_courses')
                ->with('success', 'Course updated successfully!');
        }
    }

    public function markAsReadNotification($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect('/instructor_homepage');
        }
    }

    public function submitRating(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        CourseRating::updateOrCreate(
            [
                'course_id' => $request->course_id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return redirect($request->certificate_url);
    }
}