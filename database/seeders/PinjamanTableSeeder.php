<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pinjaman;

class PinjamanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
        $tgl_pinjman = date('Y-m-d', strtotime('-' . rand(1, 30) . ' days'));
           Pinjaman::create([
                'id_anggota' => $i,
                'id_petugas' =>1,
                'nominal' => 1000000,
                'lama_angsuran' => 20,
                'sisa_pokok' => 1000000,
                'sisa_jasa' => (1000000 * 0.03),
                'tgl_pinjam' => $tgl_pinjman,
                'tgl_terakhir_bayar' => date('Y-m-d', strtotime('+' . rand(1, 12) . ' months', strtotime($tgl_pinjman))),
            ]);
        }

        // angsuran lancar (tidak ada yang nunggak)
        $pinjaman = Pinjaman::where('tgl_pinjam', '<=', date('Y-m-d'))->take(10)->get();
        foreach ($pinjaman as $p) {
            # Data Pinjaman 
            $pokok_sekarang = $p->sisa_pokok;
            $jasa_sekarang = $p->sisa_jasa;
            $bayar_pokok = $pokok_sekarang / $p->lama_angsuran;
            $bayar_jasa = $jasa_sekarang / $p->lama_angsuran;
            $tgl_bayar = $p->tgl_pinjam;
            $sebelum_pokok = $pokok_sekarang;
            $sebelum_jasa = $jasa_sekarang;
            $setelah_pokok = $pokok_sekarang - $bayar_pokok;
            $setelah_jasa = $jasa_sekarang - $bayar_jasa;

            for ($i = 1; $i <= $p->lama_angsuran; $i++) {
                DB::table('angsuran')->insert([
                    'id_pinjaman' => $p->id_pinjaman,
                    'id_petugas' => 1,
                    'bayar_pokok' => $bayar_pokok,
                    'bayar_jasa' => $bayar_jasa,
                    'tgl_bayar' => $tgl_bayar,
                    'sebelum_pokok' => $sebelum_pokok,
                    'sebelum_jasa' => $sebelum_jasa,
                    'setelah_pokok' => $setelah_pokok,
                    'setelah_jasa' => $setelah_jasa,
                ]);
                $tgl_bayar = date('Y-m-d', strtotime('+1 months', strtotime($tgl_bayar)));
                $sebelum_pokok = $setelah_pokok;
                $sebelum_jasa = $setelah_jasa;
                $setelah_pokok = $setelah_pokok - $bayar_pokok;
                $setelah_jasa = $setelah_jasa - $bayar_jasa;
            }

            $p->update([
                'sisa_pokok' => 0,
                'sisa_jasa' => 0,
                'tgl_terakhir_bayar' => date('Y-m-d', strtotime('-1 months', strtotime($tgl_bayar))),
            ]);
            

        }

        // // angsuran nunggak (ada yang nunggak)
        // $pinjaman = Pinjaman::where('sisa_pokok', '>', 0)->where('tgl_pinjam', '<=', date('Y-m-d'))->take(10)->get();
        // foreach ($pinjaman as $p) {
        

        // }
    }
}
