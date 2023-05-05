<?php

namespace App\Http\Controllers;

use App\Models\Tematicas;
use App\Http\Requests\StoreTematicasRequest;
use App\Http\Requests\UpdateTematicasRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TematicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        protected string $routeName;
        protected string $source;
        protected string $module = 'tematicas';
        protected Tematicas $model;

        public function __construct()
        {
            $this->routeName = "tematicas.";
            $this->source    = "Tematica/";
            $this->model     = new Tematicas();
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

         return Inertia::render("Tematica/Index", [
             'titulo '          => 'Instituciones Registradas',
             'routeName'      => $this->routeName,
             'tematicas'=>  $records->orderBy('id') -> paginate(6),
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
        //dd(Auth::user());
        return Inertia::render("{$this->source}Create", [
            'titulo'=>'Agregar Tematica',
            'routeName'=>$this->routeName,
            'tematicas'=>tematicas::orderBy('id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTematicasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTematicasRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route('tematicas.index')->with('success', 'Temática guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tematicas  $tematicas
     * @return \Illuminate\Http\Response
     */
    public function show(Tematicas $tematicas)
    {
        abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tematicas  $tematicas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tematicas $tematicas)
    {

        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Institución',
            'routeName'      => $this->routeName,
            'tematicas' => $tematicas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTematicasRequest  $request
     * @param  \App\Models\Tematicas  $tematicas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTematicasRequest $request, Tematicas $tematicas)
    {
        $tematicas->update($request->validated());
        return redirect()->route('tematicas.index')->with('success', 'Temática actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tematicas  $tematicas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tematicas $tematicas)
    {
        $tematicas->delete();
        return redirect()->route('tematicas.index')->with('success', 'Temática eliminado con éxito');
    }
}
