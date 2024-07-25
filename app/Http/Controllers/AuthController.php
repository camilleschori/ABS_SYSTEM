<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email' => 'البريد الالكتروني غير صحيح',
            'email.exists' => 'البريد الالكتروني غير صحيح',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        $credentials = $request->only('email', 'password');



        if (Auth::attempt($credentials, $request->has('remember_me'))) {

            return redirect()->route('admin.dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login'); // Redirect to login page after logout
    }
}
