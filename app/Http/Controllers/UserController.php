<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profile()
{
    $user = auth()->user();
    return view('user.profile', compact('user'));
}

}
