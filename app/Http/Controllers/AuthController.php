<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        return inertia('Auth/SignIn');
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:3',
        ]), true)) {
            throw ValidationException::withMessages([
                'email' => 'Email or password is incorrect. Please try again.'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function create()
    {
        return inertia('Auth/SignUp');
    }

    public function store(Request $request)
    {
        $user = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:3'
        ]);

        User::create($user);

        if (!Auth::attempt($user, true)) {
            throw ValidationException::withMessages([
                'email' => 'Email or password is incorrect. Please try again.'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function destroy() {}
}
