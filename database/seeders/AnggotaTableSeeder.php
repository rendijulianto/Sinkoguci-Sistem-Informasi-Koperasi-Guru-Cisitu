<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Faker\Factory as Faker;
class AnggotaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 179; $i++) {
            $faker = Faker::create('id_ID');
            $id_petugas = rand(1, 10);
            $id_sekolah = rand(1, 10);
            Anggota::create([
                'id_petugas' => $id_petugas,
                'id_sekolah' => $id_sekolah,
                'nama'     => $faker->name,
                'alamat'  => substr($faker->address, 0, 60),
                'tgl_lahir' => $faker->date,
            ]);
        }
       
    }
}
