<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $level = Auth::guard('petugas')->user()->level;
        $title = 'Halaman Utama';
        if (Auth::guard('petugas')->user()->level == 'petugas') {
            return view('petugas.dashboard.index', compact('title'));
        } elseif (Auth::guard('petugas')->user()->level == 'admin') {
            return view('admin.dashboard.index', compact('title'));
        } else {
            return redirect(route('login'))->with('error', 'Silahkan login terlebih dahulu.');
        }

    }

}