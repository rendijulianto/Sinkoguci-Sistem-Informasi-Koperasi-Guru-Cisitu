<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Petugas, Anggota, Sekolah};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordEmail;

class AuthController extends Controller
{
    public function index()
    {
        $title = 'Masuk';

        return view('login', compact('title'));
    }

    public function isLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if(auth()->guard('petugas')->attempt($credentials)){
            $user = auth()->guard('petugas')->user();
            return response()->json(['status' => 'success', 'message' => 'Login berhasil, anda akan dialihkan ke halaman dashboard.', 'redirect' => route($user->level.'.dashboard')]);

        }else {
            return response()->json(['status' => 'error', 'message' => 'Login gagal, silahkan cek email dan password anda.']);
        }
    }

    public function logout()
    {
       if(auth()->guard('petugas')->check()){
           auth()->guard('petugas')->logout();
       }
       return redirect(route('login'))->with('success', 'Anda berhasil keluar.');
    }

    public function lupaPassword()
    {
        $title = 'Lupa Password';
        return view('lupa-password', compact('title'));
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:petugas,email',
        ]);


        $petugas = Petugas::where('email', $request->email)->first();
        $password = Str::random(8);
        $petugas->update([
            'password' => Hash::make($password),
        ]);

        Mail::to($petugas->email)->send(new ResetPasswordEmail($petugas, $password));

        return redirect()->back()->with('success', 'Password berhasil direset, silahkan cek email anda.');
    }


}
