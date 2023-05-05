<?php

namespace App\Http\Controllers;

use App\Models\permisos;
use App\Http\Requests\StorepermisosRequest;
use App\Http\Requests\UpdatepermisosRequest;
use Spatie\Permission\Models\Permission;
use App\Models\modulo;
use Inertia\Response;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class PermisosController extends Controller
{
    protected string $routeName;
    protected string $source;
    protected string $module = 'permiso';
    protected Permission $model;

    public function __construct()
    {
        $this->routeName = "permiso.";
        $this->source    = "Seguridad/Permisos/";
        $this->model     = new Permission();
        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']); 
    }

    public function index(Request $request): Response
    {
        $records = $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('description', 'LIKE', "%$search%");
                $query->orWhere('module_key',  'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Catálogo de Permisos',
            'records'        => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
            'status'         => (bool) $request->status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'titulo'=>'Agregar Permisos',
            'routeName'=>$this->routeName,
            'modulos'=>modulo::orderBy('id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepermisosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorepermisosRequest $request): RedirectResponse
    {
        $this->model::create($request->validated());
        return redirect()->route('permiso.index')->with('success', 'Permiso guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $perfil): Response
    {
        $perfil = Cache::rememberForever("profile.{$perfil->id}", function () use ($perfil) {
            return $perfil->load('permissions:id,name,description,module_key');
        });
        $permissions = Cache::rememberForever('permissions', function () {
            return Permission::get(['id', 'name', 'description', 'module_key'])->groupBy('module_key')->toArray();
        });
        return Inertia::render('Roles/Edit', [
            'title'    => 'Editar perfil.',
            'perfil'   => $perfil,
            'modules'  => Module::orderBy('key')->get(['id', 'name', 'description', 'key']),
            'permisos' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepermisosRequest  $request
     * @param  \App\Models\permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepermisosRequest $request, permisos $per)
    {
        $per->update($request->validated());
        Cache::forget('permissions');
        return redirect()->route("{$this->routeName}index")
        ->with('success', 'Permiso editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function destroy(permisos $permisos)
    {
        //
    }
}
