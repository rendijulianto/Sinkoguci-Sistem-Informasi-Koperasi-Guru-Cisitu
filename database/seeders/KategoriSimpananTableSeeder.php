<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KategoriSimpanan;

class KategoriSimpananTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriSimpanan::create([
            'nama' => 'Simpanan Pokok',
            'jumlah' => 100000,
        ]);
        KategoriSimpanan::create([
            'nama' => 'Simpanan Wajib',
            'jumlah' => 65000,
        ]);
        KategoriSimpanan::create([
            'nama' => 'Simpanan Khusus',
            'jumlah' => 10000,
        ]);
        KategoriSimpanan::create([
            'nama' => 'Dana Khusus',
            'jumlah' => 2500,
        ]);
        KategoriSimpanan::create([
            'nama' => 'Simpanan Sukarela',
            'jumlah' => 0,
        ]);
        KategoriSimpanan::create([
            'nama' => 'Hari Koperasi',
            'jumlah' => 0,
        ]);
        KategoriSimpanan::create([
            'nama' => 'Simpanan Hari Raya',
            'jumlah' => 22500,
        ]);
        KategoriSimpanan::create([
            'nama' => 'Simpanan Karya Wisata',
            'jumlah' => 50000,
        ]);
    }
}
