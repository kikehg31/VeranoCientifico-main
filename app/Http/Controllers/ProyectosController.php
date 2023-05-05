<?php

namespace App\Http\Controllers;

use App\Models\Proyectos;
use App\Http\Requests\StoreProyectosRequest;
use App\Http\Requests\UpdateProyectosRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Tematicas;
use App\Models\Subtematicas;
use Illuminate\Support\Facades\Auth;
use TCPDF;

class ProyectosController extends Controller
{

    private Proyectos $model;
    private string $source;
    private string $routeName;
    private string $module = 'proyectos';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->source = 'Proyectos/';
        $this->model = new Proyectos();
        $this->routeName = 'proyectos.';


        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);
        $this->middleware("permission:indexadmin")->only(['indexadmin']);
    }
    public function index(Request $request)
    {
        $usid = Auth::id();
        $request->status = $request->status === null ? true : $request->status;
         $records = $request->status == '0' ? $this->model->onlyTrashed() : $this->model;
         $records=
         $records = $records->when($request->search, function ($query, $search) {
             if ($search != '') {
                 $query->where('title', 'LIKE', '%' . $search . '%')
                     ->orWhere('generalobject', 'LIKE', '%' . $search . '%');
             }else{
                 $query->where('user_id', '=', '$usid' );
             }
         });

         return Inertia::render("Proyectos/Index", [
             'title '          => 'Proyectos',
             'routeName'      => $this->routeName,
             'proyectos' => $records->where('user_id', $usid)->paginate(3),
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
        $thematic = Tematicas::all();
        $thematic->load('subtematica');
        return Inertia::render("{$this->source}Create", [
            'titulo'          => 'Agregar Proyecto',
            'routeName'      => $this->routeName,
            'tematica'=>$thematic,
            'subtematica' => Subtematicas::get(),
            'idlog' => Auth::id(),
            'idinstlog' => Auth::user()->institution_id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProyectosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProyectosRequest $request)
    {
        Proyectos::create($request->validated());
        return redirect()->route('proyectos.index')->with('success', 'Proyecto guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyectos $proyectos)
    {
        $tematicas = Tematicas::all();
        $tematicas->load('subtematica');
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar proyecto',
            'routeName'      => $this->routeName,
            'proyectos' => $proyectos,
            'tematicas' => $tematicas,
            'subtematica'=> Subtematicas::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProyectosRequest  $request
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProyectosRequest $request, Proyectos $proyectos)
    {
        $proyectos->update($request->validated());
        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyectos  $proyectos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyectos $proyectos)
    {
        //dd($proyectos);
        $proyectos->delete();
        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado con éxito');
    }

    public function indexadmin(Request $request){

        if($request != ''){
            //$proyectos = Proyectos::with('users','thematics', 'subthematics')->paginate(3);
            $request->status = $request->status === null ? true : $request->status;
            $records = $request->status == '0' ? $this->model->onlyTrashed() : $this->model;
            $records=
            $records = $records->when($request->search, function ($query, $search) {
                if ($search != '') {
                    $query->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('generalobject', 'LIKE', '%' . $search . '%');
                }
            });
            $proyectos = $records->orderBy('id')->with('users','thematics', 'subthematics')->paginate(3);
        }else{
            $proyectos = Proyectos::with('users','thematics', 'subthematics')->paginate(3);
        }

         return Inertia::render("Proyectos/IndexAdmin", [
             'title '          => 'Proyectos',
             'routeName'      => $this->routeName,
             'proyectos' => $proyectos,
             'loadingResults' => false,
             'search'         => $request->search ?? '',
             'status'         => (bool) $request->status,


         ]);
    }

    public function reportespdf(){




    }
}
