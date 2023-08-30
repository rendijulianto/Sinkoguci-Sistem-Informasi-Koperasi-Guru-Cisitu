<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      for ($i=0; $i < 10; $i++) {
            $tingkat = ['SD', 'SMP', 'SMA', 'SMK'];
            $tipe = ['Negeri', 'Swasta'];
            $nomor = rand(1, 10);
            $nama = $tingkat[rand(0, 3)].' '.$tipe[rand(0, 1)].' '.$nomor;
            Sekolah::create([
                'nama' =>  $nama,
            ]);
        }
    }
}
