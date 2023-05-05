<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('modulos')->truncate();

        DB::table('c_modulo')->insert([
            [
                'nombre' => 'Módulos del Sistema',
                'descripcion' => 'Módulos del Sistema',
                'key' => 'modulo',
                'audit_user_id' => 1,
                'created_at' => date('Y-m-d H:m:s')
            ],
            [
                'nombre' => 'Catálogos del Sistema',
                'descripcion' => 'Catálogos del Sistema',
                'key' => 'cat',
                'audit_user_id' => 1,
                'created_at' => date('Y-m-d H:m:s')
            ],
            [
                'nombre' => 'CRUD',
                'descripcion' => 'CRUD',
                'key' => 'crud',
                'audit_user_id' => 1,
                'created_at' => date('Y-m-d H:m:s')
            ],
        ]);
    }
}