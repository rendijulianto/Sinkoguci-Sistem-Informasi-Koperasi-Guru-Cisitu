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
           Pinjaman::create([
                'id_anggota' => $i, 
                'id_petugas' =>1,
                'tgl_pinjam' => rand(2022, 2023) . '-' . rand(1, 12) . '-' . rand(1, 28),
                'pokok' => rand(1000000, 10000000),
                'lama_angsuran' => rand(10, 20),
            ]);
        }

        // angsuran lancar (tidak ada yang nunggak)
        $pinjaman = Pinjaman::where('tgl_pinjam', '2022-01-01')->get();
        foreach ($pinjaman as $p) {
            $pokok = $p->pokok;
            $lama_angsuran = $p->lama_angsuran;
            for ($i = 1; $i <= $lama_angsuran; $i++) {
            }
        }
    }
}
