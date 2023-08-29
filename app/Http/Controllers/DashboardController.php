<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Halaman Utama';
        return view('petugas.dashboard.index', compact('title'));
    }
}
