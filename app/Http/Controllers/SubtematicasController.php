<?php

namespace App\Http\Controllers;

use App\Models\Subtematicas;
use App\Http\Requests\StoreSubtematicasRequest;
use App\Http\Requests\UpdateSubtematicasRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Tematicas;

class SubtematicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected string $routeName;
     protected string $source;
     protected string $module = 'subtematicas';
     protected Subtematicas $model;

     public function __construct()
     {
        $this->routeName = "subtematicas.";
        $this->source    = "Subtematica/";
        $this->model     = new Subtematicas();
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

         return Inertia::render("Subtematica/Index", [
             'titulo '          => 'Subtemáticas Registradas',
             'routeName'      => $this->routeName,
             'subtematicas'=>  $records->orderBy('id')->with('tematica') -> paginate(6),
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
            'titulo'=>'Agregar Subtemática',
            'routeName'=>$this->routeName,
            'tematicas'=> Tematicas::orderBy('id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubtematicasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubtematicasRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route('subtematicas.index')->with('success', 'Subtemática guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subtematicas  $subtematicas
     * @return \Illuminate\Http\Response
     */
    public function show(Subtematicas $subtematicas)
    {
        abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subtematicas  $subtematicas
     * @return \Illuminate\Http\Response
     */
    public function edit(Subtematicas $subtematicas)
    {

        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Subtemática',
            'routeName'      => $this->routeName,
            'subtematicas' => $subtematicas,
            'tematicas' => Tematicas::where('id', $subtematicas->thematic_id)->get(),
            'tematicas'=> Tematicas::orderBy('id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubtematicasRequest  $request
     * @param  \App\Models\Subtematicas  $subtematicas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubtematicasRequest $request, Subtematicas $subtematicas)
    {
        $subtematicas->update($request->validated());
        return redirect()->route('subtematicas.index')->with('success', 'Subtemática actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subtematicas  $subtematicas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subtematicas $subtematicas)
    {
        $subtematicas->delete();
        return redirect()->route('subtematicas.index')->with('success', 'Subtemática eliminado con éxito');
    }
}
