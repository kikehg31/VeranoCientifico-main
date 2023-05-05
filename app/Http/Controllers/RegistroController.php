<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Renapo;
use App\Models\User;
use App\Models\Tematicas;
use App\Models\Subtematicas;
use App\Models\Instituciones;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRegistroRequest;
use App\Http\Requests\UpdateRegistroRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected string $routeName;
    protected string $source, $source2;
    protected string $module = 'usuarios';
    protected User $model;
    private $disk = 'public';

    public function __construct()
    {

        $this->routeName = "usuarios.";
        $this->source    = "Auth/";
        $this->source2    = "Usuarios/";
        $this->model     = new User();

    }

    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //En este metodo se renderizara al usuario al formulario de registro donde ya vendran cargados los catalogos necesarios
    public function create()
    {
        $thematic = Tematicas::all();//obtenemos todas las tematicas
        $thematic->load('subtematica'); //cargamos las subtematicas de cada tematica
        return Inertia::render("{$this->source}Register", [//renderizamos a la vista del registro con inertia
            'tematica'=>$thematic,//ponemos todos los props que vamos a necesitar
            'instituto' =>Instituciones::orderBy('id')->get(),
            //obtenemos los roles que puede elegir el usuario
            'roles'=> Role::with('permissions:id,name,description,module_key')->orderBy('name')->select('id', 'name', 'description')->where('id', '!=', '1')->get(),
            'subtematica' => Subtematicas::get(),

        ]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $url = Storage::url($path);
            return response()->json(['url' => $url]);
        } else {
            return response()->json(['error' => 'No se encontró ninguna imagen.'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegistroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegistroRequest $request): RedirectResponse
    {
        //dd($request);

        if($request -> hasFile(key:'requestform')){
            $file = $request->file('requestform');
            $formatosolicitud = $request->input('name_doc') .$request->curp .".". $file->guessExtension();

            if (!Storage::disk($this->disk)->exists('DocumentosRevisores/'.$formatosolicitud)){

                $fields= $request->validated();

                //$fields['constancia'] = $request -> constancia -> getClientOriginalName();

                $fields['password'] = Hash::make($fields['password']);
                $usuario = $this->model::create([
                    'id_rol' => $fields['id_rol'],
                    'name' => $fields['name'],
                    'lastnamep' => $fields['lastnamep'],
                    'lastnamem' => $fields['lastnamem'],
                    'curp' => $fields['curp'],
                    'email' => $fields['email'],
                    'emailcon' => $fields['emailcon'],
                    'phone' => $fields['phone'],
                    'institution_id' => $fields['institution_id'],
                    'thematic_id' => $fields['thematic_id'],
                    'subthematic_id' => $fields['subthematic_id'],
                    'snilevel' => $fields['snilevel'],
                    'grademax' => $fields['maxgrade'],
                    'invline' => $fields['invline'],
                    'job' => $fields['job'],
                    'password' => $fields['password'],
                    'requestform' => $formatosolicitud,
                    'photo' => asset('storage/ImagenesPerfil/newUser.png'),
                ] );
                $roles = Role::where('id', $request->id_rol)->get();
                $usuario->syncRoles($roles);
                $file->storeAs('public/DocumentosRevisores', $formatosolicitud);
                event(new Registered($usuario));
                return redirect()->route('login')->with('success', 'Usuario registrado!');
            }else{

            }
        }

        if($request -> hasFile(key:'constancy')){
            $file = $request->file('constancy');
            $constancia = $request->input('name_doc') .$request->curp .".". $file->guessExtension();
            //dd($constancia);
            //$constancia = $request -> constancia -> getClientOriginalName();
            //$request->constancia = $constancia;
            if (!Storage::disk($this->disk)->exists('DocumentosProfesores/'.$constancia)){

                $fields= $request->validated();

                //$fields['constancia'] = $request -> constancia -> getClientOriginalName();

                $fields['password'] = Hash::make($fields['password']);
                $usuario = $this->model::create([
                    'id_rol' => $fields['id_rol'],
                    'name' => $fields['name'],
                    'lastnamep' => $fields['lastnamep'],
                    'lastnamem' => $fields['lastnamem'],
                    'curp' => $fields['curp'],
                    'email' => $fields['email'],
                    'emailcon' => $fields['emailcon'],
                    'phone' => $fields['phone'],
                    'institution_id' => $fields['institution_id'],
                    'thematic_id' => $fields['thematic_id'],
                    'subthematic_id' => $fields['subthematic_id'],
                    'snilevel' => $fields['snilevel'],
                    'grademax' => $fields['maxgrade'],
                    'invline' => $fields['invline'],
                    'job' => $fields['job'],
                    'password' => $fields['password'],
                    'constancy' => $constancia,
                    'photo' => asset('storage/ImagenesPerfil/newUser.png'),
                ] );
                $roles = Role::where('id', $request->id_rol)->get();
                $usuario->syncRoles($roles);
                $file->storeAs('public/DocumentosProfesores', $constancia);
                event(new Registered($usuario));
                return redirect()->route('loggin')->with('success', 'Usuario registrado!');
            }else{

            }

        }

        if($request->id_rol == 4){
            //dd($request);
            $fields= $request->validated();
            $fields['password'] = Hash::make($fields['password']);
            $usuario = $this->model::create([
                'id_rol' => $fields['id_rol'],
                'name' => $fields['name'],
                'lastnamep' => $fields['lastnamep'],
                'lastnamem' => $fields['lastnamem'],
                'curp' => $fields['curp'],
                'email' => $fields['email'],
                'emailcon' => $fields['emailcon'],
                'phone' => $fields['phone'],
                'institution_id' => $fields['institution_id'],
                'thematic_id' => $fields['thematic_id'],
                'subthematic_id' => $fields['subthematic_id'],
                'snilevel' => $fields['snilevel'],
                'grademax' => $fields['maxgrade'],
                'invline' => $fields['invline'],
                'job' => $fields['job'],
                'password' => $fields['password'],
                'photo' => asset('storage/ImagenesPerfil/newUser.png'),
            ] );
            $roles = Role::where('id', $request->id_rol)->get();
            $usuario->syncRoles($roles);
            //$file->storeAs('public/DocumentosProfesores', $constancia);
            event(new Registered($usuario));
            return redirect()->route('login')->with('success', 'Usuario registrado!');
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */

    //en esta funcion se realizara la consulta al renapo, como entrada se solicitara la curp
    public function show($curp)
    {
        if(Renapo::where('curp',$curp)->exists()){//consultamos primero si en nuestra tabla renapo existe ya esa consulta
            $records = Renapo::where('curp',$curp)->get();//si existe obtenemos la información y ya no ejecutamos el servicio RENAPO
        }else{
            //si no existe el registro, se llama al servicio por medio de la función HTTP, haciendo uso de la url concatenado con el curp que se solicitud
            $response = Http::get("https://curpws.bienestar.gob.mx/ServiceCurpPro/ConsultaPor/Curp/".$curp);
            //recuperamos el objeto que se obtuvo como respuesta
            $data = $response->object();
            //dd($data);
            //creamos una instancia a la clase Renapo
            $reg = new Renapo();
            //se asignan los valores que se necesitan para poder guardar en la tabla renapo la curp consultada, y en caso de que necesire la consulta
            //de nuevo no se ejecutara el servicio a renapo y solo se consulta a la tabla renapo
            $reg->curp = $data->response->curp;
            $reg->curpRespuesta = $data->response->curpRespuesta;
            $reg->nombres = $data->response->nombres;
            $reg->apellidopaterno = $data->response->apellidoPaterno;
            $reg->apellidomaterno = $data->response->apellidoMaterno;
            //se guarda la informacion en la tabla de la base de datos
            $reg->save();
            //ahora que ya esta registrada en la tabla, se have la consulta, y se almacena en records
            $records = Renapo::where('curp',$request)->get();
        }
        //se retorna records
        return $records[0];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        $datos = User::where('id', $user)->first();
        $tematicas = Tematicas::all();
        $instituciones = Instituciones::all();
        $tematicas->load('subtematica');

        return Inertia::render("{$this->source2}Edit", [
            'user'=>Auth::user(),
            'tematicas' => $tematicas,
            'instituciones' => $instituciones,
            'subtematicas'=> Subtematicas::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegistroRequest  $request
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegistroRequest $request, $user)
    {
        //dd($user);
        User::where('id', $user)->update($request->validated());
        return redirect()->back()->with('success', 'Información actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registro  $registro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registro $registro)
    {
        //
    }
}
