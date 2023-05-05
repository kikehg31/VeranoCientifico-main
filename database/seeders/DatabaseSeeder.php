<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TematicasSeeder::class,
            SubtematicasSeeder::class,
            InstitucionesSeeder::class,
            PermisosSeeder::class,
            UsuarioSeeder::class,
            ModuloSeeder::class,
            AdminSeeder::class,
            DocumentoSeeder::class,
            ProyectosSeeder::class,

        ]);
    }
}
