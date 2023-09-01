<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Anggota, KategoriSimpanan, KategoriSimpananAnggota, Simpanan};
use DB;
class SimpananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anggota = Anggota::all();
        $kategori = KategoriSimpanan::all();
        foreach ($anggota as $a) {
            foreach ($kategori as $k) {
                Simpanan::create([
                    'id_anggota' => $a->id_anggota,
                    'id_kategori' => $k->id_kategori,
                    'id_petugas' => 1, // id petugas default
                    'tgl_bayar' => date('Y-m-d'),
                    'jumlah' => $k->jumlah,
                    'keterangan' => 'Simpanan Awal',
                ]);
                if (preg_match('/Simpanan/', $k->nama)) {
                    $saldo = $k->jumlah;
                } else {
                    $saldo = 0;
                }
                DB::table('kategori_simpanan_anggota')->where('id_anggota', $a->id_anggota)->where('id_kategori', $k->id_kategori)->update([
                    'saldo' => $saldo,
                ]);
            }
        }
    }
}
