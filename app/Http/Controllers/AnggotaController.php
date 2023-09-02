<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Anggota, Sekolah};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Data Anggota';
        $anggota = Anggota::with('sekolah')->orderBy('id_anggota', 'desc');

        // Logika pencarian
        if ($request->has('cari')) {
            $cari = $request->input('cari');
            $anggota->where(function ($query) use ($cari) {
                $query->where('nama', 'like', '%' . $cari . '%')
                    ->orWhere('alamat', 'like', '%' . $cari . '%');
            });
        }

        // Logika filter sekolah
        if ($request->has('filterSekolah')) {
            $filterSekolah = $request->input('filterSekolah');
            $anggota->where('id_sekolah', $filterSekolah);
        }

        $anggota = $anggota->paginate(10);
        $sekolahs = Sekolah::orderBy('nama', 'asc')->get();
        return view('petugas.anggota.index', compact('title', 'anggota', 'sekolahs'));
    }


    

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|min:3|max:60',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|min:3|max:255',
            'id_sekolah' => 'required|exists:sekolah,id_sekolah',
        ]);

        DB::beginTransaction();
        try {
            $idPetugas = Auth::guard('petugas')->user()->id_petugas;
            Anggota::create([
                'id_petugas' => $idPetugas,
                'id_sekolah' => $request->id_sekolah,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tgl_lahir' => $request->tgl_lahir,
            ]);



            DB::commit();
            return redirect()->back()->with('success', 'Anggota berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

/**
 * Display the specified resource.
 */
public function show(string $id)
    {
        $title = 'Detail Anggota';
        $anggota = Anggota::findOrFail($id);
        return view('petugas.anggota.show', compact('title', 'anggota'));
    }

/**
 * Show the form for editing the specified resource.
 */
public function edit(string $id)
{
    $title = 'Edit Anggota';
    $anggota = Anggota::findOrFail($id);
    $sekolahs = Sekolah::orderBy('nama', 'asc')->get();
    return view('petugas.anggota.edit', compact('title', 'anggota', 'sekolahs'));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $this->validate($request, [
        'nama' => 'required|min:3|max:60',
        'tgl_lahir' => 'required|date',
        'alamat' => 'required|min:3|max:255',
        'id_sekolah' => 'required|exists:sekolah,id_sekolah',
    ]);

    DB::beginTransaction();
    try {
        $anggota = Anggota::findOrFail($id);
        $anggota->update([
            'id_sekolah' => $request->id_sekolah,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tgl_lahir' => $request->tgl_lahir,
        ]);
        DB::commit();
        return redirect()->back()->with('success', 'Data anggota berhasil diperbarui');
    } catch (\Throwable $th) {
        DB::rollback();
        return redirect()->back()->withInput()->with('error', $th->getMessage());
    }
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    try {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();
        return redirect()->back()->with('success', 'Anggota: ' . $anggota->nama . ' Dihapus');
    } catch (\Throwable $th) {
        return redirect()->back()->with('error', $th->getMessage());
    }
}

public function cetak(string $id)
{
    $anggota = Anggota::findOrFail($id);

    // Menggunakan PDF generator seperti Laravel DomPDF atau TCPDF
    $pdf = new \PDF(); // Ganti dengan library PDF yang Anda gunakan
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    // Isi kartu anggota sesuai dengan format yang Anda inginkan
    $pdf->Cell(0, 10, 'Kartu Anggota', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Nama: ' . $anggota->nama, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Tanggal Lahir: ' . $anggota->tgl_lahir, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Alamat: ' . $anggota->alamat, 0, 1, 'L');
    $pdf->Cell(0, 10, 'Sekolah: ' . $anggota->sekolah->nama, 0, 1, 'L');

    // Menyimpan atau menampilkan PDF, tergantung kebutuhan Anda
    
    $pdf->Output('Kartu_Anggota.pdf'); 
    $pdf->Output('I'); 
    $pdf = PDF::loadView('kartu_anggota', compact('anggota'));
    return $pdf->stream('Kartu_Anggota.pdf');
}


}
