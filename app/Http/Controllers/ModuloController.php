<?php

namespace App\Http\Controllers;

use App\Models\modulo;
use App\Http\Requests\StoremoduloRequest;
use App\Http\Requests\UpdatemoduloRequest;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;

class ModuloController extends Controller
{
    private modulo $model;
    private string $source;
    private string $routeName;
    private string $module = 'modulo';

    //Para proteger nuestras rutas
    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Seguridad/Modulos/';
        $this->model = new modulo();
        $this->routeName = 'modulo.';

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);
    }
    public function index(Request $request): Response
    {
        $request->status = $request->status === null ? true : $request->status;
        $records = $request->status == '0' ? $this->model->onlyTrashed() : $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('nombre', 'LIKE', '%' . $search . '%')
                    ->orWhere('descripcion', 'LIKE', '%' . $search . '%');
            }
        });

        return Inertia::render("{$this->source}Index", [
            'modulos'        =>  $records->paginate(3),
            'titulo'          => 'Catálogo de Módulos',
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
            'titulo'          => 'Agregar Módulos',
            'routeName'      => $this->routeName
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoremoduloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoremoduloRequest $request): RedirectResponse
    {
        modulo::create($request->validated());
        return redirect()->route('modulo.index')->with('success', 'Módulo guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function show(modulo $modulo)
    {
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function edit(modulo $modulo)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Módulos',
            'routeName'      => $this->routeName,
            'modulos' => $modulo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemoduloRequest  $request
     * @param  \App\Models\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatemoduloRequest $request, modulo $modulo): RedirectResponse
    {
        $modulo->update($request->validated());
        return redirect()->route('modulo.index')->with('success', 'Módulo actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\modulo  $modulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(modulo $modulo)
    {
        $modulo->delete();
        return redirect()->route('modulo.index')->with('success', 'Módulo eliminado con éxito');
    }
}
