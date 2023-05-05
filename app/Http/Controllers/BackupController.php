<?php
namespace App\Http\Controllers;
use Spatie\DbDumper\Databases\MySql;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    //constructor
    public function __construct()
    {
        //Se le asigna el permiso nombrado 'backup' a el metodo backup de este controlador
        $this->middleware("permission:backup")->only(['backup']);
        //Se le asigna el permiso nombrado 'restore' a el metodo restore de este controlador
        $this->middleware("permission:restore")->only(['restoreDataBase']);
        //Se le asigna el permiso nombrado 'backup.index' a el metodo index de este controlador
        $this->middleware("permission:backup.index")->only(['index']);
    }
    //En este metodo el administrador podra descargar el respaldo de la base de datos en un archivo .sql
    public function backup()
    {
        $databaseName = env('DB_DATABASE');//se hace referencia al dato 'DB_DATABASE' que se encuentra en el .env
        $databaseUser = env('DB_USERNAME');//se hace referencia al dato 'DB_USERNAME' que se encuentra en el .env
        $databasePassword = env('DB_PASSWORD');//se hace referencia al dato 'DB_PASSWORD' que se encuentra en el .env
        $backupPath = storage_path('app/backups/');//se obtiene la ruta total de la carpeta 'backups' en el storage
        $backupName = $databaseName . '-' . date('Y-m-d-H-i-s') . '.sql';//se le da el nombre al archivo del respaldo

        // Ejecutar el comando mysqldump utilizando los datos anteriormente extraidos del .env
        $command = "mysqldump --column-statistics=0 --host=localhost --user={$databaseUser} --password={$databasePassword} --databases {$databaseName} > {$backupPath}{$backupName}";
        exec($command);

        // Guardar la copia de seguridad en la carpeta de almacenamiento
        Storage::disk('local')->put('backups/' . $backupName, file_get_contents($backupPath . $backupName));

        // Descargar la copia de seguridad
        return response()->download($backupPath . $backupName);
    }

    //en este método el administrador podra hacer la carga del archivo .sql para la restauración de la base de datos
    //Entrada: Un archivo .sql con la configuracion de la base de datos
    //Salida: Cadena de confirmación o de aviso de fallo
    public function restoreDataBase(Request $request)
    {
        if ($request->hasFile('archivo')) {//se pregunta si en el request viene un dato tipo file llamando 'archivo'
            $archivo = $request->file('archivo');//asignamos a la variable $archivo el archivo que viene en el request
            $rutaTemporal = $archivo->getRealPath();//obtenemos la ruta temporal que crea laravel cuando ingresa un archivo al sistema
            $sql = file_get_contents($rutaTemporal);//leemos el contenido del archivo
            DB::unprepared($sql);//esta linea nos sirve para ejecutar el contenido del archivo SQL en la base de datos.
            return "El archivo se ha inyectado correctamente en la base de datos.";
        }
        return 'No se ha seleccionado ningún archivo.';
    }


    public function index(){
        return Inertia::render("Seguridad/BaseDatos/RespRecup",[
            'instituto' => '',
        ]);
    }
}
