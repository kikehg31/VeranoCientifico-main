<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('proyectos')->insert([
            [
                'title' => 'ARQUITECTURA INCLUSIVA',
                'studentnum' => '2',
                'thematic_id' => 3,
                'subthematic_id' => 15,
                'generalobject' => 'Inclusivo',
                'modality' => 'Mixto',
                'requirements' => 'Inclisividad',
                'keywords' => 'inclusivo',
                'students' => 0,
                'institution_id' => 5,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:m:s'),
            ],
            [
                'title' => 'SITIOS WEB INCLUSIVOS',
                'studentnum' => '2',
                'thematic_id' => 3,
                'subthematic_id' => 15,
                'generalobject' => 'Inclusivo',
                'modality' => 'Mixto',
                'requirements' => 'Inclisividad',
                'keywords' => 'inclusivo',
                'students' => 0,
                'institution_id' => 5,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:m:s'),

            ],
            [
                'title' => 'CONTROL ROBUSTO DE SISTEMAS MECATRÓNICOS',
                'studentnum' => '2',
                'thematic_id' => 3,
                'subthematic_id' => 15,
                'generalobject' => 'Inclusivo',
                'modality' => 'Mixto',
                'requirements' => 'Inclisividad',
                'keywords' => 'inclusivo',
                'students' => 0,
                'institution_id' => 5,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:m:s'),

            ],
            [
                'title' => 'CONTROL PID NEURONAL APLICADO A UN ROBOT MÓVIL',
                'studentnum' => '2',
                'thematic_id' => 3,
                'subthematic_id' => 15,
                'generalobject' => 'Inclusivo',
                'modality' => 'Mixto',
                'requirements' => 'Inclisividad',
                'keywords' => 'inclusivo',
                'students' => 0,
                'institution_id' => 5,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:m:s'),
            ],
            [
                'title' => 'MODELACIÓN DE ELEMENTOS PASIVOS BIOCLIMÁTICOS',
                'studentnum' => '2',
                'thematic_id' => 3,
                'subthematic_id' => 15,
                'generalobject' => 'Inclusivo',
                'modality' => 'Mixto',
                'requirements' => 'Inclisividad',
                'keywords' => 'inclusivo',
                'students' => 0,
                'institution_id' => 5,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:m:s'),
            ],
            [
                'title' => 'ANÁLISIS DEL FLUJO DEL LITIO EN MÉXICO',
                'studentnum' => '2',
                'thematic_id' => 3,
                'subthematic_id' => 15,
                'generalobject' => 'Inclusivo',
                'modality' => 'Mixto',
                'requirements' => 'Inclisividad',
                'keywords' => 'inclusivo',
                'students' => 0,
                'institution_id' => 5,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:m:s'),
            ],
        ]);
    }
}
