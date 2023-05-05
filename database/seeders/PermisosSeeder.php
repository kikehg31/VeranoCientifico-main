<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CREAMOS LO MÓDULOS DEL SISTEMA
        Permission::create(['name' => 'modulo.catalogos', 'guard_name' => 'web', 'description' => 'Catálogos del Sistema', 'module_key' => 'modulo']);
        Permission::create(['name' => 'modulo.profesores', 'guard_name' => 'web', 'description' => 'Profesores', 'module_key' => 'modulo']);
        Permission::create(['name' => 'modulo.seguridad', 'guard_name' => 'web', 'description' => 'Administración de Seguridad', 'module_key' => 'modulo']);

        Permission::create(['name' => 'backup', 'guard_name' => 'web', 'description' => 'Creacion de la base de datos', 'module_key' => 'cat']);
        Permission::create(['name' => 'restore', 'guard_name' => 'web', 'description' => 'Restauracion de la base de datos', 'module_key' => 'cat']);
        Permission::create(['name' => 'backup.index', 'guard_name' => 'web', 'description' => 'Vista principal Backup', 'module_key' => 'cat']);
        Permission::create(['name' => 'reportes', 'guard_name' => 'web', 'description' => 'Reportes PDF', 'module_key' => 'cat']);
        Permission::create(['name' => 'pdf', 'guard_name' => 'web', 'description' => 'Reportes PDF', 'module_key' => 'cat']);
        Permission::create(['name' => 'savesql', 'guard_name' => 'web', 'description' => 'Guardar registro de la recuperacion de datos', 'module_key' => 'cat']);

        Permission::create(['name' => 'modulo.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'modulo.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'modulo.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'modulo.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'permissions.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'permissions.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'permissions.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'permissions.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'perfiles.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'perfiles.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'perfiles.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'perfiles.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'usuarios.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'usuarios.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'usuarios.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'usuarios.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'documento.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'documento.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'documento.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'documento.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'docuser.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'docuser.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'docuser.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'docuser.edit', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'docuser.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'proyectos.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'proyectos.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'proyectos.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'proyectos.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'indexadmin', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'instituciones.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'instituciones.store', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'instituciones.update', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'instituciones.delete', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'tematicas.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'tematicas.store', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'tematicas.update', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'tematicas.delete', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'subtematicas.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'subtematicas.store', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'subtematicas.update', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'subtematicas.delete', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'proyectospro.index', 'guard_name' => 'web', 'description' => 'Leer Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'proyectospro.store', 'guard_name' => 'web', 'description' => 'Crear Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'proyectospro.edit', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'proyectospro.update', 'guard_name' => 'web', 'description' => 'Actualizar Registros', 'module_key' => 'cat']);
        Permission::create(['name' => 'proyectospro.delete', 'guard_name' => 'web', 'description' => 'Eliminar Registros', 'module_key' => 'cat']);

        Permission::create(['name' => 'filedelete', 'guard_name' => 'web', 'description' => 'Eliminar archivos del storage', 'module_key' => 'cat']);
        Permission::create(['name' => 'filesave', 'guard_name' => 'web', 'description' => 'Subir archivos al storage', 'module_key' => 'cat']);
        Permission::create(['name' => 'status', 'guard_name' => 'web', 'description' => 'Ver el estado del expediente', 'module_key' => 'cat']);

    }
}
