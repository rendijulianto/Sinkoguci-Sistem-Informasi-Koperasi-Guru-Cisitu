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
            $nominal = $p->nominal;
            $lama_angsuran = $p->lama_angsuran;
            $tgl_pinjam = $p->tgl_pinjam;
            $tgl_terakhir_bayar = $p->tgl_terakhir_bayar;
            $sisa_pokok = $p->sisa_pokok;
            $sisa_jasa = $p->sisa_jasa;
            $tgl_bayar = $tgl_pinjam;
            $bayar_pokok = $nominal / $lama_angsuran;
            $bayar_jasa = $sisa_jasa / $lama_angsuran;
            for ($i = 1; $i <= $lama_angsuran; $i++) {
                DB::table('angsuran')->insert([
                    'id_pinjaman' => $p->id_pinjaman,
                    'id_petugas' => 1,
                    'bayar_pokok' => $bayar_pokok,
                    'bayar_jasa' => $bayar_jasa,
                    'tgl_bayar' => $tgl_bayar,
                    'created_at' => date('Y-m-d H:i:s', strtotime($tgl_bayar)),
                    'updated_at' => date('Y-m-d H:i:s', strtotime($tgl_bayar)),
                ]);
                $tgl_bayar = date('Y-m-d', strtotime('+' . rand(1, 12) . ' months', strtotime($tgl_bayar)));
                $sisa_pokok -= $bayar_pokok;
                $sisa_jasa -= $bayar_jasa;
            }
            $p->update([
                'sisa_pokok' => $sisa_pokok,
                'sisa_jasa' => $sisa_jasa,
                'tgl_terakhir_bayar' => $tgl_terakhir_bayar,
            ]);
        }

        // angsuran nunggak (ada yang nunggak)
        $pinjaman = Pinjaman::where('sisa_pokok', '>', 0)->where('tgl_pinjam', '<=', date('Y-m-d'))->take(10)->get();
        foreach ($pinjaman as $p) {
        //   dibuat seolah2 ada yang hanya menggangus 2 bulan 3 bulan dan dll
            $nominal = $p->nominal;
            $lama_angsuran = $p->lama_angsuran;
            $tgl_pinjam = $p->tgl_pinjam;
            $tgl_terakhir_bayar = $p->tgl_terakhir_bayar;
            $sisa_pokok = $p->sisa_pokok;
            $sisa_jasa = $p->sisa_jasa;
            $tgl_bayar = $tgl_pinjam;
            $bayar_pokok = $nominal / $lama_angsuran;
            $bayar_jasa = $sisa_jasa / $lama_angsuran;
            for ($i = 1; $i <= rand(1, $lama_angsuran); $i++) {
                DB::table('angsuran')->insert([
                    'id_pinjaman' => $p->id_pinjaman,
                    'id_petugas' => 1,
                    'bayar_pokok' => $bayar_pokok,
                    'bayar_jasa' => $bayar_jasa,
                    'tgl_bayar' => $tgl_bayar,
                    'created_at' => date('Y-m-d H:i:s', strtotime($tgl_bayar)),
                    'updated_at' => date('Y-m-d H:i:s', strtotime($tgl_bayar)),
                ]);
                $tgl_bayar = date('Y-m-d', strtotime('+' . rand(1, 12) . ' months', strtotime($tgl_bayar)));
                $sisa_pokok -= $bayar_pokok;
                $sisa_jasa -= $bayar_jasa;
            }
            $p->update([
                'sisa_pokok' => $sisa_pokok,
                'sisa_jasa' => $sisa_jasa,
                'tgl_terakhir_bayar' => $tgl_terakhir_bayar,
            ]);

        }
    }
}
