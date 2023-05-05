<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubtematicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('subthematics')->insert([['name' => 'Astrofísica',  'thematic_id' => '1']]);
        DB::table('subthematics')->insert(['name' => 'Astronomía',  'thematic_id' => '1']);
        DB::table('subthematics')->insert(['name' => 'Ciencias de la Tierra y del espacio',  'thematic_id' => '1']);
        DB::table('subthematics')->insert(['name' => 'Física',  'thematic_id' => '1']);
        DB::table('subthematics')->insert(['name' => 'Lógica',  'thematic_id' => '1']);
        DB::table('subthematics')->insert(['name' => 'Matemáticas',  'thematic_id' => '1']);
        DB::table('subthematics')->insert(['name' => 'Prospectiva',  'thematic_id' => '1']);
        DB::table('subthematics')->insert(['name' => 'Ciencias del mar',  'thematic_id' => '1']);

        DB::table('subthematics')->insert(['name' => 'Ciencias de la vida',  'thematic_id' => '2']);
        DB::table('subthematics')->insert(['name' => 'Prospectiva',  'thematic_id' => '2']);
        DB::table('subthematics')->insert(['name' => 'Ciencias biomédicas',  'thematic_id' => '2']);
        DB::table('subthematics')->insert(['name' => 'Biología',  'thematic_id' => '2']);
        DB::table('subthematics')->insert(['name' => 'Química',  'thematic_id' => '2']);
        DB::table('subthematics')->insert(['name' => 'Ciencias Ambientales',  'thematic_id' => '2']);

        DB::table('subthematics')->insert(['name' => 'Ciencias médicas',  'thematic_id' => '3']);
        DB::table('subthematics')->insert(['name' => 'Medicina',  'thematic_id' => '3']);
        DB::table('subthematics')->insert(['name' => 'Enfermería',  'thematic_id' => '3']);
        DB::table('subthematics')->insert(['name' => 'Ingeniería biomédica',  'thematic_id' => '3']);
        DB::table('subthematics')->insert(['name' => 'Especialidad médica',  'thematic_id' => '3']);
        DB::table('subthematics')->insert(['name' => 'Odontología',  'thematic_id' => '3']);
        DB::table('subthematics')->insert(['name' => 'Investigación médica',  'thematic_id' => '3']);

        DB::table('subthematics')->insert(['name' => 'Biotecnología',  'thematic_id' => '4']);
        DB::table('subthematics')->insert(['name' => 'Ciencias agrarías',  'thematic_id' => '4']);
        DB::table('subthematics')->insert(['name' => 'Biotecnología agrícola',  'thematic_id' => '4']);
        DB::table('subthematics')->insert(['name' => 'Salud y Producción Animal',  'thematic_id' => '4']);
        DB::table('subthematics')->insert(['name' => 'Pesca',  'thematic_id' => '4']);

        DB::table('subthematics')->insert(['name' => 'Robótica',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Simulaciones',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Materiales avanzados',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Realidad virtual',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Realidad Aumentada',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Big Data',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Inteligencia artificial',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Software como servicio',  'thematic_id' => '5']);
        DB::table('subthematics')->insert(['name' => 'Manufactura aditiva',  'thematic_id' => '5']);

        DB::table('subthematics')->insert(['name' => 'Ciencias tecnologícas',  'thematic_id' => '6']);
        DB::table('subthematics')->insert(['name' => 'Ingeniería',  'thematic_id' => '6']);
        DB::table('subthematics')->insert(['name' => 'Prospectiva',  'thematic_id' => '6']);

        DB::table('subthematics')->insert(['name' => 'Ciencia política',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Ciencias de la educación',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Ciencias económicas',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Ciencias jurídicas y Derecho',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Demografía',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Formación docente',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Geografía',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Historia',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Sociología',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Administración y negocios',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Medios de comunicación y comunicaciones',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Comunicación científica',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Gestión',  'thematic_id' => '7']);
        DB::table('subthematics')->insert(['name' => 'Estudios de Género',  'thematic_id' => '7']);
    }
}
