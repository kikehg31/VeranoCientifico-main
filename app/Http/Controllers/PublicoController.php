<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Publico;
use App\Models\User;
use App\Models\Tematicas;
use App\Models\Proyectos;
use App\Http\Requests\StorePublicoRequest;
use App\Http\Requests\UpdatePublicoRequest;
use Illuminate\Http\Request;

class PublicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *$proyectos = Proyectos::with(['thematics' => function($query) {
      *      $query->select('name');
       * }])->get();
     * @return \Illuminate\Http\Response
     */
    private Proyectos $model;
    private User $model2;
    public function __construct()
    {
        $this->model = new Proyectos();
        $this->model2 = new User();

    }

    public function index(Request $request)
    {

        //$proyectos = Proyectos::with('users','thematics', 'subthematics')->paginate(3);
        if($request != ''){
            $request->status = $request->status === null ? true : $request->status;
            $records = $request->status == '0' ? $this->model->onlyTrashed() : $this->model;
            $records=
            $records = $records->when($request->search || $request->tematica, function ($query, $search) use ($request) {
                $query->when($request->search, function ($query, $search) use ($request) {
                    if($search != '' && $request->tematica != ''){
                        $query->where('thematic_id', $request->tematica)
                        ->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhere('generalobject', 'LIKE', '%' . $search . '%')
                        ->orWhere('keywords', 'LIKE', '%' . $search . '%');
                    }else if ($search != '') {
                        $query->where('title', 'LIKE', '%' . $search . '%')
                            ->orWhere('generalobject', 'LIKE', '%' . $search . '%')
                            ->orWhere('keywords', 'LIKE', '%' . $search . '%');
                    }
                })->when($request->tematica, function ($query, $tematica) {
                    if ($tematica != '') {
                        $query->where('thematic_id', $tematica);
                    }
                });
            });
            $proyectos = $records->orderBy('id')->with('users','thematics', 'institutions', 'subthematics')->paginate(15);
        }else{
            $proyectos = Proyectos::with('users', 'thematics', 'institutions', 'subthematics')->paginate(15);
        }

        //  $proyectos = Proyectos::with('thematics', 'subthematics', 'institutions', 'users')->get();
        //$proyectos = Proyectos::with('subthematics')->get();
        //dd($proyectos);
        return Inertia::render("Verano", ['proyectos' => $proyectos, 'tematicas' => Tematicas::orderby('id')->get()],[
            //'proyectos'=> Proyectos::orderBy('id')->get(),
            //'tematicas' => Tematicas::orderby('id')->get(),
            //'proyectos' => $proyectos,
            'proyectos' => $proyectos,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
            'status'         => (bool) $request->status,
        ]);
    }



    //index profesores publica

    public function indexProfesores(Request $request)
    {

        //$proyectos = Proyectos::with('users','thematics', 'subthematics')->paginate(3);
        if($request != ''){
            $request->status = $request->status === null ? true : $request->status;
            $records = $request->status == '0' ? $this->model2->onlyTrashed() : $this->model2;
            $records=
            $records = $records->when($request->search || $request->tematica, function ($query, $search) use ($request) {
                $query->when($request->search, function ($query, $search) use ($request) {
                    if($search != '' && $request->tematica != ''){
                        $query->where('id_rol', 2)->where('thematic_id', $request->tematica)
                        ->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('lastnamep', 'LIKE', '%' . $search . '%')
                        ->orWhere('job', 'LIKE', '%' . $search . '%');
                    }else if ($search != '') {
                        $query->where('id_rol', 2)->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('lastnamep', 'LIKE', '%' . $search . '%')
                            ->orWhere('job', 'LIKE', '%' . $search . '%');
                    }
                })->when($request->tematica, function ($query, $tematica) {
                    if ($tematica != '') {
                        $query->where('id_rol', 2)->where('thematic_id', $tematica);
                    }
                });
            });
            $profesores = $records->where('id_rol', 2)->orderBy('id')->with('thematics', 'institutions')->paginate(15);
        }else{
            $profesores = User::where('id_rol', 2)->with('thematics', 'institutions')->paginate(15);
        }
        //dd($profesores);

        return Inertia::render("Profesores", ['profesores' => $profesores, 'tematicas' => Tematicas::orderby('id')->get()],[
            'profesores' => $profesores,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePublicoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePublicoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publico  $publico
     * @return \Illuminate\Http\Response
     */
    public function show(Publico $publico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publico  $publico
     * @return \Illuminate\Http\Response
     */
    public function edit(Publico $publico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePublicoRequest  $request
     * @param  \App\Models\Publico  $publico
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePublicoRequest $request, Publico $publico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publico  $publico
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publico $publico)
    {
        //
    }

    public function acerca(Publico $publico){
        return Inertia::render("AcercaVerano", [

        ]);
    }
}
