<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TematicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thematics')->insert(['name' => 'Física, Matemáticas y Ciencias']);
        DB::table('thematics')->insert(['name' => 'Biología y Química']);
        DB::table('thematics')->insert(['name' => 'Medicina y Salud']);
        DB::table('thematics')->insert(['name' => 'Biotecnología y Ciencias Agropecuarias']);
        DB::table('thematics')->insert(['name' => 'Tecnología 4.0 ']);
        DB::table('thematics')->insert(['name' => 'Ingeniería e Industria']);
        DB::table('thematics')->insert(['name' => 'Ciencias sociales']);
    }
}
