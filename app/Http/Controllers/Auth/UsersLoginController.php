<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login', [
            'canRegister' => $this->canRegister(),
        ]);
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if the logged-in user is an admin
            if ($this->isAdmin()) {
                return redirect('/dashboard');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function canRegister()
    {
        return !$this->isAdmin();
    }

    public function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/signin');
    }
}
