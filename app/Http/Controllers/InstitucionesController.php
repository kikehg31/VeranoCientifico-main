<?php

namespace App\Http\Controllers;

use App\Models\Instituciones;
use App\Http\Requests\StoreInstitucionesRequest;
use App\Http\Requests\UpdateInstitucionesRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class InstitucionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        protected string $routeName;
        protected string $source;
        protected string $module = 'instituciones';
        protected Instituciones $model;
    
        public function __construct()
        {
            $this->source = 'Instituciones/';
        $this->model = new Instituciones();
        $this->routeName = 'instituciones.';

            
            $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
            $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
            $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
            $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']); 
        }
        
    public function index(Request $request)
    {
        $request->status = $request->status === null ? true : $request->status;
        $records = $request->status == '0' ? $this->model->onlyTrashed() : $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name', 'LIKE', '%' . $search . '%');
            }
        });

         return Inertia::render("Instituciones/Index", [
             'titulo '          => 'Instituciones Registradas',
             'routeName'      => $this->routeName,
             'institucion'=>  $records->orderBy('id') -> paginate(6),
             'loadingResults' => false,
             'search'         => $request->search ?? '',
             'status'         => (bool) $request->status, ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'titulo'=>'Agregar Institución',
            'routeName'=>$this->routeName,
            'instituciones'=>instituciones::orderBy('id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstitucionesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstitucionesRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route('instituciones.index')->with('success', 'Institución guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instituciones  $instituciones
     * @return \Illuminate\Http\Response
     */
    public function show(Instituciones $instituciones)
    {
        abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instituciones  $instituciones
     * @return \Illuminate\Http\Response
     */
    public function edit(Instituciones $instituciones)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Institución',
            'routeName'      => $this->routeName,
            'institucion' => $instituciones
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInstitucionesRequest  $request
     * @param  \App\Models\Instituciones  $instituciones
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstitucionesRequest $request, Instituciones $instituciones)
    {
        //dd($request);
        $instituciones->update($request->validated());
        return redirect()->route('instituciones.index')->with('success', 'Institución actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instituciones  $instituciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instituciones $instituciones)
    {
        $instituciones->delete();
        return redirect()->route('instituciones.index')->with('success', 'Proyecto eliminado con éxito');
    }
}
