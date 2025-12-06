<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Courses;


class CartController extends Controller
{
    public function addToCart($courseId)
{
    // Avoid duplicate entries
    $exists = Cart::where('user_id', auth()->id())
                  ->where('course_id', $courseId)
                  ->first();

    if (!$exists) {
        Cart::create([
            'user_id' => auth()->id(),
            'course_id' => $courseId,
        ]);
    }

    return redirect()->back()->with('cart_added', 'Course added to cart.');

}


public function addToGuestCart(Request $request)
{
    $courseId = $request->input('course_id');

    // Store in session cart array
    $cart = session()->get('guest_cart', []);
    if (!in_array($courseId, $cart)) {
        $cart[] = $courseId;
        session()->put('guest_cart', $cart);
    }

    return redirect('/cart');
}



public function removeFromGuestCart(Request $request) 
{
    $courseId = $request->input('course_id');
    
    // Get current guest cart (array of course IDs)
    $cart = session()->get('guest_cart', []);
    
    // Remove the course ID from the array
    $cart = array_filter($cart, function($id) use ($courseId) {
        return $id != $courseId;
    });
    
    // Re-index array to avoid gaps and update session
    session()->put('guest_cart', array_values($cart));
    
    return redirect()->back()->with('success', 'Course removed from cart');
}


public function showCart()
{
    if (auth()->check()) {
        // Logged-in user: get cart items from DB
        $cartItems = Cart::with('course')->where('user_id', auth()->id())->get();
        $isGuest = false;
    } else {
        // Guest: get course IDs from session and fetch course models
        $cartCourseIds = session()->get('guest_cart', []);
        $cartItems = \App\Models\Courses::whereIn('id', $cartCourseIds)->get();
        $isGuest = true;
    }

    return view('user.cart', compact('cartItems', 'isGuest'));
}

public function removeFromCart($id)
{
    $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->first();

    if ($cartItem) {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Course removed from cart.');
    }

    return redirect()->back()->with('error', 'Item not found or unauthorized.');
}


}
