<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Documento;
use App\Models\Expedientes;
use App\Models\ProyectoUsuario;
use Illuminate\Http\Request;
use App\Models\DocumentoUsuario;
use App\Notifications\Expediente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notification;
use App\Http\Requests\StoreDocumentoUsuarioRequest;
use App\Http\Requests\UpdateDocumentoUsuarioRequest;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcherInterface;

class DocumentoUsuarioController extends Controller
{



    private $disk = 'public';
    private string $module = 'docuser';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->middleware('auth');

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.edit")->only(['edit']);
        $this->middleware("permission:{$this->module}.update")->only(['update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }
    //index donde el alumno subira sus documentos
    public function index()
    {
        $id = Auth::id();
        $exp = Expedientes::where('student_id', $id)->first();
        if($exp == null || $exp->status == 'Rechazado'){
            //recuperamos el id del alumno autentificado
            $curp = Auth::user()->curp;//curp del usuario autentificado

            //declaramos variables que usaremos
            $doc1 = '';
            $doc2 = '';
            $doc3 = '';
            $doc4 = '';
            $doc5 = '';
            $doc6 = '';
            $comments = '';
            if($exp != null && $exp->comments != ''){
                $comments = $exp->comments;
            }
            //preguntamos si ya existe el documento 'formato_solicituD' en el storage
            if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/formato_solicituD'.$id.'.pdf')){
                //si ya existe a la variable doc1 le asignamos el url con el que va a poder visualizar el archivo
                $doc1 = asset('storage/Expedientes/'.$curp.'/formato_solicituD'.$id.'.pdf');
            }
            //preguntamos si ya existe el documento 'carta academica' en el storage
            if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/carta_academicA'.$id.'.pdf')){
                //si ya existe a la variable doc2 le asignamos el url con el que va a poder visualizar el archivo
                $doc2 = asset('storage/Expedientes/'.$curp.'/carta_academicA'.$id.'.pdf');
            }

            if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/carta_motivos'.$id.'.pdf')){
                //si ya existe a la variable doc3 le asignamos el url con el que va a poder visualizar el archivo
                $doc3 = asset('storage/Expedientes/'.$curp.'/carta_motivos'.$id.'.pdf');
            }

            if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/ine'.$id.'.pdf')){
                //si ya existe a la variable doc4 le asignamos el url con el que va a poder visualizar el archivo
                $doc4 = asset('storage/Expedientes/'.$curp.'/ine'.$id.'.pdf');
            }

            if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/cvu'.$id.'.pdf')){
                //si ya existe a la variable doc5 le asignamos el url con el que va a poder visualizar el archivo
                $doc5 = asset('storage/Expedientes/'.$curp.'/cvu'.$id.'.pdf');
            }

            if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/fotografia'.$id.'.jpeg')){
                //si ya existe a la variable doc6 le asignamos el url con el que va a poder visualizar el archivo
                $doc6 = asset('storage/Expedientes/'.$curp.'/fotografia'.$id.'.jpeg');
            }else{
                if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/fotografia'.$id.'.jpg')){
                    $doc6 = asset('storage/Expedientes/'.$curp.'/fotografia'.$id.'.jpg');
                }else{
                    if(Storage::disk($this->disk)->exists('Expedientes/'.$curp.'/fotografia'.$id.'.png')){
                        $doc6 = asset('storage/Expedientes/'.$curp.'/fotografia'.$id.'.png');
                    }
                }
            }


            //renderizamos al usuario con inertia a la vista a la que deseamos mandar la informacion
            return Inertia::render("Documentos/Index", [
                //definimos los props que vamos a utilizar en la vista
                'titulo'          => 'Subir documentos del expediente',
                'documento1' => $doc1,
                'documento2' => $doc2,
                'documento3' => $doc3,
                'documento4' => $doc4,
                'documento5' => $doc5,
                'documento6' => $doc6,
                'comentarios' => $comments,

            ]);
        }else{
            $us = User::where('id', $id)->first();

            $docs = DocumentoUsuario::where('user_id', $id)->get();

            $alldocs = [
                [
                    'name' => 'Formato Solicitud',
                    'url' => $docs[0]->path,
                ],
                [
                    'name' => 'Carta Academica',
                    'url' => $docs[1]->path,
                ],
                [
                    'name' => 'Carta Motivos',
                    'url' => $docs[2]->path,
                ],
                [
                    'name' => 'INE',
                    'url' => $docs[3]->path,
                ],
                [
                    'name' => 'CVU',
                    'url' => $docs[4]->path,
                ],
                [
                    'name' => 'Foto',
                    'url' => $docs[5]->path,
                ],
            ];
            //dd($us[0]->curp);
            return Inertia::render("Documentos/Expediente", [
                'docs' => $alldocs,
                'exp' => $exp->status,
            ]);
        }

    }

    //El revisor va a poder observar por una tabla los expedientes de su institucion a revisar
    public function indexRevisor(){
        $ins = Auth::user()->institution_id;
        $exp = User::where('institution_id', $ins)->where('id_rol', 4)->with('expediente')->paginate(5);
        $rev = Expedientes::with('userRev')->get();
        $exp2 = User::where('institution_id', $ins)->where('id_rol', 4)->with('expediente')->first();
        //dd($exp2->expediente);
        if($exp2->expediente =! null){
            $info = '';
        }else{
            $info = 'sin datos';
        }
        //dd($exp);
        return Inertia::render("Documentos/IndexRevisor", [
            //definimos los props que vamos a utilizar en la vista
            'expedientes' => $exp,
            'datos' => $info,
        ]);

    }


    //el alumno podra visualizar el estado de su expediente
    public function status()
    {
        $userId = Auth::id();
        $us = User::where('id', $userId)->first();
        $exp = Expedientes::where('student_id', $userId)->first();

        $docs = DocumentoUsuario::where('user_id', $userId)->get();

        $alldocs = [
            [
                'name' => 'Formato Solicitud',
                'url' => $docs[0]->path,
            ],
            [
                'name' => 'Carta Academica',
                'url' => $docs[1]->path,
            ],
            [
                'name' => 'Carta Motivos',
                'url' => $docs[2]->path,
            ],
            [
                'name' => 'INE',
                'url' => $docs[3]->path,
            ],
            [
                'name' => 'CVU',
                'url' => $docs[4]->path,
            ],
            [
                'name' => 'Foto',
                'url' => $docs[5]->path,
            ],
        ];
        //dd($us[0]->curp);
        return Inertia::render("Documentos/Expediente", [
            'docs' => $alldocs,
            'exp' => $exp->status,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDocumentoUsuarioRequest  $request
     * @return \Illuminate\Http\Response
     */

     //alumno
    public function store(StoreDocumentoUsuarioRequest $request)
    {
        $id = Auth::id();
        $curp = Auth::user()->curp;
        $ins = Auth::user()->institution_id;
        if(!Expedientes::where('student_id', $id)->first()){
            Expedientes::create(['student_id' => $id,'status' => 'Documentos Subidos']);

        }
        $record = Expedientes::where('student_id', $id)->first();
        if(!DocumentoUsuario::where('user_id', $id)->where('document_id', 1)->first()){
            DocumentoUsuario::create(['user_id' => $id, 'document_id' => 1,'path' => $request->requestform, 'record_id' => $record->id]);
        }

        if(!DocumentoUsuario::where('user_id', $id)->where('document_id', 2)->first()){
            DocumentoUsuario::create(['user_id' => $id,'document_id' => 2,'path' => $request->academicdoc, 'record_id' => $record->id]);
        }

        if(!DocumentoUsuario::where('user_id', $id)->where('document_id', 3)->first()){
            DocumentoUsuario::create(['user_id' => $id,'document_id' => 3,'path' => $request->motivedoc, 'record_id' => $record->id]);
        }

        if(!DocumentoUsuario::where('user_id', $id)->where('document_id', 4)->first()){
            DocumentoUsuario::create(['user_id' => $id,'document_id' => 4,'path' => $request->ine, 'record_id' => $record->id]);
        }

        if(!DocumentoUsuario::where('user_id', $id)->where('document_id', 5)->first()){
            DocumentoUsuario::create(['user_id' => $id,'document_id' => 5,'path' => $request->cvu, 'record_id' => $record->id]);
        }

        if(!DocumentoUsuario::where('user_id', $id)->where('document_id', 6)->first()){
            DocumentoUsuario::create(['user_id' => $id,'document_id' => 6,'path' => $request->foto, 'record_id' => $record->id]);
        }

        if(DocumentoUsuario::where('user_id', $id)->count() == 6){


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






    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentoUsuario  $documentoUsuario
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentoUsuario $documentoUsuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentoUsuario  $documentoUsuario
     * @return \Illuminate\Http\Response
     */

    //revisor
    public function edit($userId)
    {
        $us = User::where('id', $userId)->first();
        $docs = DocumentoUsuario::where('user_id', $userId)->get();
        $exp = Expedientes::where('student_id', $userId)->first();

        $alldocs = [
            [
                'name' => 'Formato Solicitud',
                'url' => $docs[0]->path,
            ],
            [
                'name' => 'Carta Academica',
                'url' => $docs[1]->path,
            ],
            [
                'name' => 'Carta Motivos',
                'url' => $docs[2]->path,
            ],
            [
                'name' => 'INE',
                'url' => $docs[3]->path,
            ],
            [
                'name' => 'CVU',
                'url' => $docs[4]->path,
            ],
            [
                'name' => 'Foto',
                'url' => $docs[5]->path,
            ],
        ];
        //dd($us[0]->curp);
        return Inertia::render("Documentos/RevisionExp", [
            'docs' => $alldocs,
            'alumn' => $userId,
            'status' => $exp->status,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDocumentoUsuarioRequest  $request
     * @param  \App\Models\DocumentoUsuario  $documentoUsuario
     * @return \Illuminate\Http\Response
     */

    //revisor
    public function update(UpdateDocumentoUsuarioRequest $request, $userId)
    {
        $id = Auth::id();
        //dd($request);
        $text = '';

        DB::table('records')
              ->where('student_id', $userId)
              ->update(['status' => $request->status, 'rev_id' => $id, 'comments' => $request->comments
        ]);
        $name = Auth::user()->name.' '.Auth::user()->lastnamep.' '.Auth::user()->lastnamem;
        $cont ='';
        $ruta = '';
        if($request->status == 'Aceptado'){
            $posts = ProyectoUsuario::where('user_id', $userId)->get();
            DB::table('proyecto_usuarios')
              ->where('user_id', $userId)
              ->update(['status' => 'En Revisión']);
            foreach ($posts as $post) {
                $profe = User::where('id', $post->teach_id)->first();
                if($post->priority == 1){
                    $text = 'El alumno '.$name.' quiere ser parte de uno de sus proyectos y selecciono que su proyecto es de ¡¡MAYOR PRIORIDAD!!, atienda a la BREVEDAD su solicitud';
                }
                if($post->priority == 2 || $post->priority == 3){
                    $text = 'El alumno '.$name.' quiere ser parte de uno de sus proyectos, puede consultar la solicitud dando click en el botón o en el apartado "Alumnos-Proyectos->Selección de alumnos".';
                }

                $datos = [
                    'titulo' => 'Solicitud de proyecto',
                    'contenido' => $text,
                    'ruta' => 'proyectospro/'.$post->id.'/edit'
                ];
                $profe->notify(new Expediente($datos));
            }
            //dd($idpost->id);
            $cont = 'Le hago llegar esta notificacion con el fin de expresarle que su expediente ha sido revisado, su expediente es correcto, ya se le han enviado las postulaciones a los  profesores de los proyectos que seleccionaste, te notificaran por correo si te aceptan o rechazan en su proyecto.';
            $ruta = 'dashboard';
        }
        if($request->status == 'Rechazado'){
            $cont = 'Le hago llegar esta notificacion con el fin de expresarle que su expediente ha sido revisado y se han encontrado algunos detalles que no permites aceptar su expediente, le adjunto los comentarios, antenderlos a la brevedad y enviar de nuevo el expediente ya corregido. Observaciones: '.$request->comments;
            $ruta = 'docuser';
        }

        $datos = [
            'titulo' => 'Expediente Validado',
            'contenido' => $cont,
            'ruta' => $ruta,
        ];
        $alum = User::where('id', $userId)->first();
        $alum->notify(new Expediente($datos));

        return redirect()->route('revisor')->with('success', 'Expediente validado con exito!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentoUsuario  $documentoUsuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentoUsuario $documentoUsuario)
    {
        //
    }
}
