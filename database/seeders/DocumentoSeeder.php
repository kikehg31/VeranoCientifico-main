<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('documents')->truncate();

        DB::table('documents')->insert([
            [
                'name' => 'Formato solicitud',
                'document_name' => 'formato_solicitud',
                'created_at' => date('Y-m-d H:m:s'),

            ],
            [
                'name' => 'Carta academica',
                'document_name' => 'carta_academica',
                'created_at' => date('Y-m-d H:m:s'),

            ],
            [
                'name' => 'Carta motivos',
                'document_name' => 'carta_motivos',
                'created_at' => date('Y-m-d H:m:s'),

            ],
            [
                'name' => 'INE',
                'document_name' => 'INE',
                'created_at' => date('Y-m-d H:m:s'),
            ],
            [
                'name' => 'CVU',
                'document_name' => 'CVU',
                'created_at' => date('Y-m-d H:m:s'),
            ],
            [
                'name' => 'Fotografía',
                'document_name' => 'fotografia',
                'created_at' => date('Y-m-d H:m:s'),
            ],
        ]);
    }
}
