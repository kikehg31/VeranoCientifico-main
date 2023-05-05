<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //recuperamos los tipos de roles que tenemos registrados
        $admin = Role::where('name', 'Administrador')->first();
        $profe = Role::where('name', 'Profesor')->first();
        $alum = Role::where('name', 'Alumno')->first();
        $rev = Role::where('name', 'Revisor Institucional')->first();

        // Cobertura de visibilidad completa
        //$perfil->givePermissionTo(Permission::where('module_key', 'modulo')->get());
        //$perfil->givePermissionTo(Permission::where('module_key', 'cat')->get());

        //Solo acceso como administrador
        $admin->givePermissionTo([
            Permission::where('name', 'backup')->get(),
            Permission::where('name', 'restore')->get(),
            Permission::where('name', 'backup.index')->get(),
            Permission::where('name', 'reportes')->get(),
            Permission::where('name', 'pdf')->get(),
            Permission::where('name', 'savesql')->get(),
            Permission::where('name', 'permissions.index')->get(),
            Permission::where('name', 'permissions.store')->get(),
            Permission::where('name', 'permissions.update')->get(),
            Permission::where('name', 'permissions.delete')->get(),
            Permission::where('name', 'perfiles.index')->get(),
            Permission::where('name', 'perfiles.store')->get(),
            Permission::where('name', 'perfiles.update')->get(),
            Permission::where('name', 'perfiles.delete')->get(),
            Permission::where('name', 'usuarios.index')->get(),
            Permission::where('name', 'usuarios.store')->get(),
            Permission::where('name', 'usuarios.update')->get(),
            Permission::where('name', 'usuarios.delete')->get(),
            Permission::where('name', 'indexadmin')->get(),
            Permission::where('name', 'instituciones.index')->get(),
            Permission::where('name', 'instituciones.store')->get(),
            Permission::where('name', 'instituciones.update')->get(),
            Permission::where('name', 'instituciones.delete')->get(),
            Permission::where('name', 'tematicas.index')->get(),
            Permission::where('name', 'tematicas.store')->get(),
            Permission::where('name', 'tematicas.update')->get(),
            Permission::where('name', 'tematicas.delete')->get(),
            Permission::where('name', 'subtematicas.index')->get(),
            Permission::where('name', 'subtematicas.store')->get(),
            Permission::where('name', 'subtematicas.update')->get(),
            Permission::where('name', 'subtematicas.delete')->get(),
            Permission::where('name', 'documento.index')->get(),
            Permission::where('name', 'documento.store')->get(),
            Permission::where('name', 'documento.update')->get(),
            Permission::where('name', 'documento.delete')->get(),
        ]);

        //Visibilidad solo profesores
        $profe->givePermissionTo([
            Permission::where('name', 'modulo.profesores')->get(),
            Permission::where('name', 'proyectos.index')->get(),
            Permission::where('name', 'proyectos.store')->get(),
            Permission::where('name', 'proyectos.update')->get(),
            Permission::where('name', 'proyectos.delete')->get(),
            Permission::where('name', 'proyectospro.edit')->get(),
            Permission::where('name', 'proyectospro.update')->get(),
        ]);


        $alum->givePermissionTo([
            Permission::where('name', 'docuser.index')->get(),
            Permission::where('name', 'status')->get(),
            Permission::where('name', 'docuser.store')->get(),
            Permission::where('name', 'proyectospro.index')->get(),
            Permission::where('name', 'proyectospro.store')->get(),

        ]);

        $rev->givePermissionTo([
            Permission::where('name', 'docuser.edit')->get(),
            Permission::where('name', 'docuser.update')->get(),

        ]);

        //$profe->givePermissionTo(Permission::where('module_key', 'cat')->get());

        /*$cap->givePermissionTo(Permission::where('name', 'modulo.catalogos')->get());
        $cap->givePermissionTo(Permission::where('name', 'convocatoria.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'evento.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'calendario.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'modulo.index')->get());
        $cap->givePermissionTo(Permission::where('name', 'permissions.index')->get());*/
    }
}
