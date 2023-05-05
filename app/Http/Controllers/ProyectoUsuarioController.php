<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Proyectos;
use App\Models\Expedientes;
use App\Models\Tematicas;
use App\Models\DocumentoUsuario;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Notifications\Expediente;
use Illuminate\Notifications\Notification;
use Illuminate\Http\Request;
use App\Models\ProyectoUsuario;
use App\Http\Requests\StoreProyectoUsuarioRequest;
use App\Http\Requests\UpdateProyectoUsuarioRequest;

class ProyectoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private Proyectos $model;
    private string $module = 'proyectospro';

    public function __construct()
    {
        $this->model = new Proyectos();

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store']);
        $this->middleware("permission:{$this->module}.update")->only(['update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }

    //alumno
    public function solicitudes(){
        $id = Auth::id();
        $solicitudes = ProyectoUsuario::where('user_id', $id)->with('proyecto')->get();
        //dd($solicitudes);
        return Inertia::render("Proyectos/Solicitudes", [
            'solicitudes' => $solicitudes,
        ]);
    }


    public function index(Request $request)
    {
        $id = Auth::id();
        if($request != ''){
            //
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
            $proyectos = $records->orderBy('id')->with('users','thematics', 'institutions', 'subthematics')->get();
        }else{
            $proyectos = Proyectos::with('users', 'thematics', 'institutions', 'subthematics')->get();
        }
        $accept = '';

        if(Expedientes::where('student_id', $id)->where('status', 'Documentos Subidos')->first() != null && ProyectoUsuario::where('user_id', $id)->where('status', 'Aceptado')->first() == null && ProyectoUsuario::where('user_id', $id)->where('status', '!=', 'Rechazado')->count() < 3){
            $accept = 'si';
        }
        //dd($accept);
        return Inertia::render("Proyectos/IndexAlumno", ['proyectoss' => $proyectos, 'ready' => $accept, 'tematicas' => Tematicas::orderby('id')->get(),],[
            //'proyectos'=> Proyectos::orderBy('id')->get(),

            //'proyectos' => $proyectos,
            'proyectoss' => $proyectos,
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
        $id = Auth::id();
        $proy = ProyectoUsuario::where('teach_id', $id)->with('alumnos', 'proyecto')->paginate(5);
        //dd($proy);
        $docs = DocumentoUsuario::where('document_id', 5)->get();

        return Inertia::render("Proyectos/IndexProfesor", [
            'solicitudes' => $proy,
            'docs' => $docs,

        ]);

    }

    public function expedienteProyecto(Request $request){
        $aux1 = '';
        $aux2 = '';
        $aux3 = '';
        $rechazos = [];
        $id = Auth::id();
        $ins = Auth::user()->institution_id;
        $solic = ProyectoUsuario::where('user_id', $id)->get();
        $total = ProyectoUsuario::where('user_id', $id)->where('status', '!=', 'Rechazado')->count();
        if(!ProyectoUsuario::where('user_id', $id)->exists()){
            DB::table('records')
                    ->where('student_id', $id)
                    ->update(['status' => 'En Revisión', ]);
            $name = Auth::user()->name.' '.Auth::user()->lastnamep.' '.Auth::user()->lastnamem;

            $datos = [
                    'titulo' => 'Expediente para validar',
                    'contenido' => 'El alumno '.$name.' ',
                    'ruta' => 'docuser/'.$id.'/edit'
                ];

            $revs = User::where('id_rol', 3)->where('institution_id', $ins)->get();
            foreach ($revs as $rev) {
                $rev->notify(new Expediente($datos));
            }
        }



        //dd($solic);
        foreach($solic as $sol){
            if($sol->proyecto_id == $request->proyecto1){
                $post = Proyectos::where('id', $request->proyecto1)->first();
                $rechazos = [
                    'proyecto' => $post->title,
                    'motivo' => 'Ya te habias postulado a este proyecto'
                ];
                $aux1 = $sol->proyecto_id;
                //return redirect()->route('dashboard')->with('success', 'Ya te habías postulado al proyecto: '.$post->title);
            }
            if($sol->proyecto_id == $request->proyecto2){
                $post = Proyectos::where('id', $request->proyecto2)->first();
                $rechazos = [
                    'proyecto' => $post->title,
                    'motivo' => 'Ya te habias postulado a este proyecto'
                ];
                $aux2 = $sol->proyecto_id;
                //return redirect()->route('dashboard')->with('success', 'Ya te habías postulado al proyecto: '.$post->title);
            }
            if($sol->proyecto_id == $request->proyecto3){
                $post = Proyectos::where('id', $request->proyecto3)->first();
                $rechazos = [
                    'proyecto' => $post->title,
                    'motivo' => 'Ya te habias postulado a este proyecto'
                ];
                $aux3 = $sol->proyecto_id;
                //return redirect()->route('dashboard')->with('success', 'Ya te habías postulado al proyecto: '.$post->title);
            }
        }
        if($total + 1 < 4 ){
            if($request->proyecto1 != null && $aux1 != $request->proyecto1){
                $proy = Proyectos::where('id', $request->proyecto1)->first();
                //dd($proy->user_id);
                ProyectoUsuario::create([
                    'user_id' => $id,
                    'proyecto_id' => $request->proyecto1,
                    'status' => 'Expediente Pendiente',
                    'priority' => 1,
                    'teach_id' => $proy->user_id,
                ]);
                $total + 1;

            }
        }else{
            return redirect()->route('dashboard')->with('success', 'Ya alcanzaste el limite de solicitudes para proyectos (3).');
        }

        if($total + 1 < 4 ){
            if($request->proyecto2 != null && $aux2 != $request->proyecto2){
                $proy = Proyectos::where('id', $request->proyecto2)->first();
                ProyectoUsuario::create([
                    'user_id' => $id,
                    'proyecto_id' => $request->proyecto2,
                    'status' => 'Expediente pendiente',
                    'priority' => 2,
                    'teach_id' => $proy->user_id,
                ]);

                $total + 1;
            }
        }else{
            return redirect()->route('dashboard')->with('success', 'Ya alcanzaste el limite de solicitudes para proyectos (3).');
        }

        if($total + 1 < 4 ){
            if($request->proyecto3 != null){
                $proy = Proyectos::where('id', $request->proyecto3)->first();
                ProyectoUsuario::create([
                    'user_id' => $id,
                    'proyecto_id' => $request->proyecto3,
                    'status' => 'Expediente pendiente',
                    'priority' => 3,
                    'teach_id' => $proy->user_id,
                ]);

                $total + 1;
            }
        }else{
            return redirect()->route('dashboard')->with('success', 'Ya alcanzaste el limite de solicitudes para proyectos (3).');
        }

        if(empty($rechazos)){
            return redirect()->route('dashboard')->with('success', '¡Tus expediente y postulaciones han sido enviadas con exito, primero se validara tu expediente, una vez que el estado de tu expediente sea "Aceptado" se le enviarán tus postulaciones a los profesores de los proyectos que elegiste, es importante que estes al pendiente de tu correo, ahí te llegara la notificación de la respuesta del revisor y del profesor!');
        }else{
            return redirect()->route('dashboard')->with('message', 'En tus postulaciones hubo solicitudes duplicadas, consulta tus solicitudes en Proyectos->Solicitudes' );
        }
            //ProyectoUsuario::create(ProyectoUsuario::create($request->validated()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProyectoUsuarioRequest  $request
     * @return \Illuminate\Http\Response
     */

     //alumno
    public function store(Request $request)
    {
        $aux1 = '';
        $aux2 = '';
        $aux3 = '';
        $rechazos = [];
        $id = Auth::id();
        $solic = ProyectoUsuario::where('user_id', $id)->get();
        $total = ProyectoUsuario::where('user_id', $id)->where('status', '!=', 'Rechazado')->count();
        //dd($solic);
        foreach($solic as $sol){
            if($sol->proyecto_id == $request->proyecto1){
                $post = Proyectos::where('id', $request->proyecto1)->first();
                $rechazos = [
                    'proyecto' => $post->title,
                    'motivo' => 'Ya te habias postulado a este proyecto'
                ];
                $aux1 = $sol->proyecto_id;
                //return redirect()->route('dashboard')->with('success', 'Ya te habías postulado al proyecto: '.$post->title);
            }
            if($sol->proyecto_id == $request->proyecto2){
                $post = Proyectos::where('id', $request->proyecto2)->first();
                $rechazos = [
                    'proyecto' => $post->title,
                    'motivo' => 'Ya te habias postulado a este proyecto'
                ];
                $aux2 = $sol->proyecto_id;
                //return redirect()->route('dashboard')->with('success', 'Ya te habías postulado al proyecto: '.$post->title);
            }
            if($sol->proyecto_id == $request->proyecto3){
                $post = Proyectos::where('id', $request->proyecto3)->first();
                $rechazos = [
                    'proyecto' => $post->title,
                    'motivo' => 'Ya te habias postulado a este proyecto'
                ];
                $aux3 = $sol->proyecto_id;
                //return redirect()->route('dashboard')->with('success', 'Ya te habías postulado al proyecto: '.$post->title);
            }
        }
        if($total + 1 < 4 ){
            if($request->proyecto1 != null && $aux1 != $request->proyecto1){
                $proy = Proyectos::where('id', $request->proyecto1)->first();
                //dd($proy->user_id);
                ProyectoUsuario::create([
                    'user_id' => $id,
                    'proyecto_id' => $request->proyecto1,
                    'status' => 'En Revisión',
                    'priority' => 1,
                    'teach_id' => $proy->user_id,
                ]);
                $idpost = ProyectoUsuario::where('user_id', $id)->where('proyecto_id', $request->proyecto1)->first();
                //dd($idpost->id);
                $profe = User::where('id', $proy->user_id)->first();
                $name = Auth::user()->name.' '.Auth::user()->lastnamep.' '.Auth::user()->lastnamem;                $datos = [
                    'titulo' => 'Solicitud de proyecto',
                    'contenido' => 'El alumno '.$name.' quiere ser parte de uno de sus proyectos y selecciono que su poryecto es de ¡¡MAYOR PRIORIDAD!!, atienda a la BREVEDAD su solicitud',
                    'ruta' => 'proyectospro/'.$idpost->id.'/edit'
                ];
                $total + 1;
                $profe->notify(new Expediente($datos));
            }
        }else{
            return redirect()->route('dashboard')->with('success', 'Ya alcanzaste el limite de solicitudes para proyectos (3).');
        }

        if($total + 1 < 4 ){
            if($request->proyecto2 != null && $aux2 != $request->proyecto2){
                $proy = Proyectos::where('id', $request->proyecto2)->first();
                ProyectoUsuario::create([
                    'user_id' => $id,
                    'proyecto_id' => $request->proyecto2,
                    'status' => 'En Revisión',
                    'priority' => 2,
                    'teach_id' => $proy->user_id,
                ]);
                $idpost = ProyectoUsuario::where('user_id', $id)->where('proyecto_id', $request->proyecto2)->first();
                //dd($idpost->id);
                $profe = User::where('id', $proy->user_id)->first();
                $name = Auth::user()->name.' '.Auth::user()->lastnamep.' '.Auth::user()->lastnamem;
                $datos = [
                    'titulo' => 'Solicitud de proyecto',
                    'contenido' => 'El alumno '.$name.' quiere ser parte de uno de tus proyectos, podras visualizar su cv al presionar el boton, o en la seccion "Seleccion de almnos" ',
                    'ruta' => 'proyectospro/'.$idpost->id.'/edit'
                ];
                $profe->notify(new Expediente($datos));
                $total + 1;
            }
        }else{
            return redirect()->route('dashboard')->with('success', 'Ya alcanzaste el limite de solicitudes para proyectos (3).');
        }

        if($total + 1 < 4 ){
            if($request->proyecto3 != null){
                $proy = Proyectos::where('id', $request->proyecto3)->first();
                ProyectoUsuario::create([
                    'user_id' => $id,
                    'proyecto_id' => $request->proyecto3,
                    'status' => 'En Revisión',
                    'priority' => 3,
                    'teach_id' => $proy->user_id,
                ]);

                $idpost = ProyectoUsuario::where('user_id', $id)->where('proyecto_id', $request->proyecto3)->first();
                //dd($idpost->id);
                $profe = User::where('id', $proy->user_id)->first();
                $name = Auth::user()->name.' '.Auth::user()->lastnamep.' '.Auth::user()->lastnamem;
                $datos = [
                    'titulo' => 'Solicitud de proyecto',
                    'contenido' => 'El alumno '.$name.' quiere ser parte de uno de tus proyectos, podras visualizar su cv al presionar el boton, o en la seccion "Seleccion de almnos" ',
                    'ruta' => 'proyectospro/'.$idpost->id.'/edit'
                ];
                $profe->notify(new Expediente($datos));
                $total + 1;
            }
        }else{
            return redirect()->route('dashboard')->with('success', 'Ya alcanzaste el limite de solicitudes para proyectos (3).');
        }

        if(empty($rechazos)){
            return redirect()->route('dashboard')->with('success', 'Tus postulaciones han sido enviadas con exito, es importante que estes al pendiete de tu correo ahi te llegara la notificación de la respuesta del revisor y del profesor!');
        }else{
            return redirect()->route('dashboard')->with('message', 'En tus postulaciones hubo solicitudes duplicadas, consulta tus solicitudes en Proyectos->Solicitudes' );
        }
            //ProyectoUsuario::create(ProyectoUsuario::create($request->validated()));
        }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProyectoUsuario  $proyectoUsuario
     * @return \Illuminate\Http\Response
     */
    public function show(ProyectoUsuario $proyectoUsuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProyectoUsuario  $proyectoUsuario
     * @return \Illuminate\Http\Response
     */

     //profesor
    public function edit($idpost)
    {
        $post = ProyectoUsuario::where('id', $idpost)->first();
        $alumno = User::where('id', $post->user_id)->first();
        $proyecto = Proyectos::where('id',$post->proyecto_id )->first();
        $documento = DocumentoUsuario::where('user_id', $post->user_id)->where('document_id', 5)->first();
        //dd($documento->path);
        return Inertia::render("Proyectos/SeleccionAlumno", [
            'cvu' => $documento->path,
            'titulo' => 'Selección de alumno',
            'alumno' => $alumno,
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProyectoUsuarioRequest  $request
     * @param  \App\Models\ProyectoUsuario  $proyectoUsuario
     * @return \Illuminate\Http\Response
     */

     //profesor
    public function update(Request $request, $proyecto)
    {
        $validate = ProyectoUsuario::where('user_id', $request->alumno)->where('status', 'Aceptado')->get();
        $proy = Proyectos::where('id', $proyecto)->first();
        $profesor = Auth::user()->name.' '. Auth::user()->lastnamep .' '. Auth::user()->lastnamem;
        //dd($validate);
        if(ProyectoUsuario::where('user_id', $request->alumno)->where('status', 'Aceptado')->exists()){
            DB::table('proyecto_usuarios')->where('user_id', $request->alumno)->where('proyecto_id', $proyecto)->update(['status' => 'No Aplica']);
            return redirect()->route('proyectospro.create')->with('message', 'El alumno ya ha sido seleccionado en otro proyecto.');

        }else{
            if($request->seleccion == 'Aceptado'){

                if($proy->students < $proy->studentnum){
                    DB::table('proyecto_usuarios')->where('user_id', $request->alumno)->where('proyecto_id', $proyecto)->update(['status' => $request->seleccion]);

                    $num = $proy->students + 1;
                    DB::table('proyectos')
                        ->where('id', $proyecto)
                        ->update(['students' => $num, ]);
                    $cont = 'Se le hace llegar este correo con el fin de hacerle saber que ha sido aceptado en el proyecto: '.$proy->title;
                    $ruta = 'dashboard';
                    $datos = [
                        'titulo' => 'Solicitud aceptada.',
                        'contenido' => $cont,
                        'ruta' => $ruta,
                    ];
                    $alum = User::where('id', $request->alumno)->first();
                    $alum->notify(new Expediente($datos));
                    return redirect()->route('proyectospro.create')->with('success', 'El alumno ha sido aceptado en el proyecto '.$proy->title.'.');
                }else{
                    DB::table('proyecto_usuarios')->where('user_id', $request->alumno)->where('proyecto_id', $proyecto)->update(['status' => 'Proyecto lleno']);
                    $cont = 'El proyecto: '.$proy->title.' ha alcanzado el limite de estudiantes por lo que no ha sido posible inscribirte en él, ofrezco una disculpa, te invito a que veas mas proyectos de los que he publicado y si alguno es de tu interés envia tu postulación. Atte: Profesor '.$profesor.'.';
                    $ruta = 'dashboard';
                    $datos = [
                        'titulo' => 'Postulación de proyecto.',
                        'contenido' => $cont,
                        'ruta' => $ruta,
                    ];
                    $alum = User::where('id', $request->alumno)->first();
                    $alum->notify(new Expediente($datos));
                    return redirect()->route('proyectospro.create')->with('message', 'El proyecto: '.$proy->title.' ha alcanzado el limite de alumnos, por lo que no se ha podido aceptar al alumno.');

                }

            }

            if($request->seleccion == 'Rechazado'){
                DB::table('proyecto_usuarios')->where('user_id', $request->alumno)->where('proyecto_id', $proyecto)->update(['status' => $request->seleccion]);

                $cont = 'Se le hace llegar este correo con el fin de hacerle saber que su postulación en el proyecto: '.$proy->title.' ha sido rechazada.';
                $ruta = 'dashboard';
                $datos = [
                    'titulo' => 'Solicitud rechazada.',
                    'contenido' => $cont,
                    'ruta' => $ruta,
                ];
                $alum = User::where('id', $request->alumno)->first();
                $alum->notify(new Expediente($datos));
                return redirect()->route('proyectospro.create')->with('success', 'El alumno ha sido rechazado.');

            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProyectoUsuario  $proyectoUsuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProyectoUsuario $proyectoUsuario)
    {
        //
    }
}
