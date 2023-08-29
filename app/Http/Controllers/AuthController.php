<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Masuk';
        return view('login', compact('title'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            return redirect()->route('staff.dashboard');
        }
        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function lupaPassword()
    {
        $title = 'Lupa Password';
        return view('lupa-password', compact('title'));
    }
}
