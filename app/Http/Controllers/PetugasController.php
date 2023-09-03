<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cari = $request->cari;
        $level = $request->level;
        $title  = 'Kelola Petugas';
        $petugas = Petugas::query();
        
        if (!empty($level)) {
            $petugas->where('level', $level);
        }
    
        // Sisipkan filter pencarian nama atau email jika ada
        if (!empty($cari)) {
            $petugas->where(function ($query) use ($cari) {
                $query->where('nama', 'like', "%$cari%")
                      ->orWhere('email', 'like', "%$cari%")
                      ->orWhere('level','like',"%".$cari."%")
                      ->orWhere('id_petugas','like',"%".$cari."%");
            });
        
        }
        $petugas = $petugas->paginate(10);
        $petugas->appends(['cari' => $cari, 'level' => $level]);
        return view('admin.petugas.index', compact('title', 'petugas'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'      => 'required|string|max:60',
            'email'     => 'required|email|unique:petugas',
            'password'  => 'required|string|min:6',
            'level'     => 'required|in:admin,petugas',
        ], 
        [
            'nama.required'     => 'Nama tidak boleh kosong',
            'nama.string'       => 'Nama harus berupa string',
            'nama.max'          => 'Nama maksimal 60 karakter',
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.string'   => 'Password harus berupa string',
            'password.min'      => 'Password minimal 6 karakter',
            'level.required'    => 'Level tidak boleh kosong',
            'level.in'          => 'Level harus admin atau petugas',
            
          ]);

        try {
            Petugas::create([
                'nama'      => $request->nama,
                'email'     => $request->email,
                'password'  => bcrypt($request->password),
                'level'     => $request->level,
            ]);

            return redirect()->back()->with(['success' => 'Petugas: ' . $request->nama . ' Ditambahkan']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
        
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama'      => 'required|string|max:60',
            'email'     => 'required|email|unique:petugas,email,' . $id . ',id_petugas',
            'password'  => 'nullable|string|min:6',
            'level'     => 'required|in:admin,petugas',
        ],[
            'nama.required'     => 'Nama tidak boleh kosong',
            'nama.string'       => 'Nama harus berupa string',
            'nama.max'          => 'Nama maksimal 60 karakter',
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.string'   => 'Password harus berupa string',
            'password.min'      => 'Password minimal 6 karakter',
            'level.required'    => 'Level tidak boleh kosong',
            'level.in'          => 'Level harus admin atau petugas',
            
          ]);

        try {
            $petugas = Petugas::findOrFail($id);
            $petugas->update([
                'nama'      => $request->nama,
                'email'     => $request->email,
                'password'  => $request->password ? bcrypt($request->password) : $petugas->password,
                'level'     => $request->level,
            ]);

            return redirect()->back()->with(['success' => 'Petugas: ' . $petugas->nama . ' Diperbaharui']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $petugas = Petugas::findOrFail($id);
            $petugas->delete();
            return redirect()->back()->with(['success' => 'Petugas: ' . $petugas->nama . ' Dihapus']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }
}
