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

        return redirect()->intended('transactions');
    }

    public function create()
    {
        return inertia('Auth/SignUp');
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:3'
        ]);

        $user = User::create($fields);

        Auth::login($user);

        return redirect()->intended('transactions');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sign_in');
    }
}
