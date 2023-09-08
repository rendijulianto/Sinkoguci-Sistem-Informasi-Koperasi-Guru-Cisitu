<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{PenarikanDanaSosial};
class PenarikanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) {
            PenarikanDanaSosial::create([
                'id_petugas' => 1,
                'tgl_penarikan' => date('Y-m-' . ($i+1)),
                'jumlah' => 100000,
                'keterangan' => 'Penarikan Dana Sosial',
            ]);
        }
    }
}
