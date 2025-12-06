<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Courses;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cart;



class AuthController extends Controller
{
   
    // Show login form
    public function showLogin()
    {
    return response()
        ->view('auth.login') 
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    // Handle login submission
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Sync guest cart if available
        if (session()->has('guest_cart')) {
            $guestCart = session('guest_cart', []);
            
            foreach ($guestCart as $courseId) {
                // Validate courseId is not null and is numeric
                if ($courseId && is_numeric($courseId)) {
                    // Check if course exists in database
                    $course = Courses::find($courseId);
                    
                    if ($course) {
                        // Check if user is already enrolled in this course
                        $alreadyEnrolled = Enrollment::where('user_id', $user->id)
                            ->where('course_id', $courseId)
                            ->exists();
                        
                        // Check if course is already in user's cart
                        $alreadyInCart = Cart::where('user_id', $user->id)
                            ->where('course_id', $courseId)
                            ->exists();
                        
                        // Only add to cart if not enrolled and not already in cart
                        if (!$alreadyEnrolled && !$alreadyInCart) {
                            Cart::create([
                                'user_id' => $user->id,
                                'course_id' => $courseId,
                            ]);
                        }
                    }
                }
            }
            
            // Clear guest cart after processing
            session()->forget('guest_cart');
        }

        // Redirect based on user role
        if ($user->role === 2) {
            return redirect('/admin_panel');
        } else {
            return redirect('/homepage');
        }
    }

    // Login failed
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('email'));
}

    
    public function showRegister()
    {
         return response()
        ->view('auth.register') // or your register view
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');             

    }

    public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'phone'=>'required',
        'password' => 'required|min:5|confirmed',
        'field' => 'nullable|string|max:255',
        
    ]);

   $user =  User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone'=>$request->phone,
        'password' => Hash::make($request->password),
        'field' => $request->field,
        'role' => User::ROLE_USER,
       
    ]);

    Auth::login($user);

    return redirect('/homepage')->with('success', 'Account created!');
}


}


