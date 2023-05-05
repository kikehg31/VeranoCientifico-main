<?php

namespace App\Http\Controllers;
//
use App\Models\perfiles;
use App\Http\Requests\StoreperfilesRequest;
use App\Http\Requests\UpdateperfilesRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\modulo;

class PerfilesController extends Controller
{
    //Variables
    protected string $routeName;//nombre de la ruta
    protected string $source;//ruta de las vistas
    protected string $module = 'perfiles';//modulo
    protected Role $model; //Modelo usado

    public function __construct()
    {
        //Asignación de valores
        $this->routeName = "perfiles.";
        $this->source    = "Seguridad/Perfiles/";
        $this->model     = new Role();
        //usamos middleware para que solo los usuarios con este permiso tengan acceso a los metodos de este controlador
        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);
    }
    public function index(Request $request): Response
    {
    //Renderizamos a la vista de Index de perfiles los  
        return Inertia::render("{$this->source}Index", [//definimos la viasta a que va a renderizar
            'titulo'          => 'Catálogo de Roles',//En la variable titulo ponemos el valor del titulo
            'records'        =>$this->model::orderBy('id')->paginate(15),//hacemos una consulta de los roles ordenados por ID con una paginación de 15 registros
            'routeName'      => $this->routeName,//mandamos el nombre de la ruta
            'loadingResults' => false
        ]);
    }

    public function create():Response
    {
        return Inertia::render("{$this->source}Create", [ 
            'titulo'    => 'Agregar Roles',
            'routeName'      => $this->routeName,
            'modulos'  => modulo::orderBy('key')->get(['id', 'nombre', 'descripcion', 'key']),
            'permisos' => Permission::get(['id', 'name', 'description', 'module_key'])->groupBy('module_key')->toArray(),
        ]);
    }

    public function store(StoreperfilesRequest $request)
    {
        $perfil= Role::create($request->validated()); 
        $permisos = Permission::whereIn('id', $request->permisos)->get();
        $perfil->syncPermissions($permisos);
        return redirect()->route('perfiles.index')->with('Rol guardado con éxito');
    }

    public function show()
    {
        abort(405);
    }

    public function edit(Role $perfiles)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'    => 'Editar Roles.',
            'perfil'   => $perfiles->load('permissions:id,name,description,module_key'),
            'modules'  => modulo::orderBy('key')->get(['id', 'nombre', 'descripcion', 'key']),
            'permisos' => Permission::get(['id', 'name', 'description', 'module_key'])->groupBy('module_key')->toArray(),
            'routeName'=>$this->routeName,
        ]);
    }
    public function update(UpdateperfilesRequest $request, Role $perfiles)
    {
        $perfiles->update($request->validated());
        $permisos = Permission::whereIn('id', $request->permisos)->get();
        $perfiles->syncPermissions($permisos);
        Cache::forget("profile.{$perfiles->id}");
        return redirect()->route('perfiles.index')->with('Rol guardado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\perfiles  $perfiles
     * @return \Illuminate\Http\Response
     */
    public function destroy(role $perfiles)
    {
        Cache::forget("profile.{$perfiles->id}");
        $perfiles->delete();
        return redirect()->route('perfiles.index')->with('Rol eliminado con éxito');
    }
}
