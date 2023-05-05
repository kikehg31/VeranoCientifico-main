<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // se importa de SPATIE
use Spatie\Permission\Models\Permission; //se importa de SPATIE

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol1=Role::create(['name'=>'Administrador']);
        $rol2=Role::create(['name'=>'Profesor']);
        $rol3=Role::create(['name'=>'Revisor Institucional']);
        $rol4=Role::create(['name'=>'Alumno']);

        Permission::create(['name' => 'proyectos.index'])->syncRoles([$rol2]);
        Permission::create(['name'=> 'convocatoria.index'])->syncRoles([$rol1,$rol2]);
        Permission::create(['name' => 'convocatoria.create'])->syncRoles([$rol1]);
        Permission::create(['name' => 'convocatoria.edit'])->syncRoles([$rol1]);
        Permission::create(['name' => 'convocatoria.destroy'])->syncRoles([$rol1]);
    }
}
