<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Petugas;
use Faker\Factory as Faker;
class PetugasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petugas::create([
            'nama'     => 'Rendi Julianto',
            'email'    => 'petugas@gmail.com',
            'password' => bcrypt('123'),
            'level'    => 'petugas'
        ]);
        Petugas::create([
            'nama'     => 'Ariyandi Julian',
            'email'    => 'petugas1@gmail.com',
            'password' => bcrypt('123'),
            'level'    => 'petugas'
        ]);
        Petugas::create([
            'nama'     => 'Ihsan Ramadhan',
            'email'    => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'level'    => 'admin'
        ]);
       for ($i=0; $i < 10; $i++) {
            $faker = Faker::create('id_ID');
            $randomLevel = ['admin', 'petugas'];
            Petugas::create([
                'nama'     => $faker->name,
                'email'    => $faker->email,
                'password' => bcrypt('12345678'),
                'level'    => $randomLevel[rand(0, 1)],
            ]);
        }
    }
}
