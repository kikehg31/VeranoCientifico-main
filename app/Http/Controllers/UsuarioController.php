<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\modulo;
use App\Models\Renapo;
use App\Models\Tematicas;
use App\Models\Subtematicas;
use Illuminate\Http\Request;
use App\Models\Instituciones;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreusuarioRequest;
use App\Http\Requests\UpdateusuarioRequest;

class UsuarioController extends Controller
{
    protected string $routeName;
    protected string $source;
    protected string $module = 'usuarios';
    protected User $model;
    private $disk = 'public';

    public function __construct()
    {
        $this->routeName = "usuarios.";
        $this->source    = "Seguridad/Usuarios/";
        $this->model     = new User();
        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }

    public function index(Request $request): Response
    {
        //$usuarios = User::with('institutions')->get();
        $request->validate(['search' => 'nullable']);

        $usuarios = $this->model::filtro($request->all('search', 'profile'))
            ->with('roles')
            ->orderBy('id')
            ->paginate(4)
            ->withQueryString();

        return Inertia::render('Seguridad/Usuarios/Index', [
            'titulo'   => 'Catálogo de Usuarios',
            'usuarios' =>$usuarios,
            'profiles' => Role::get(['id', 'name']),
            'routeName'=> $this->routeName,
            'loadingResults' => false,
            'filtro' => $request->all('search','profile'),
        ]);

    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'instituto' =>Instituciones::orderBy('id')->get(),
            'roles'=> Role::with('permissions:id,name,description,module_key')->orderBy('name')->select('id', 'name', 'description')->where('id', '!=', '1')->get(),
            'subtematica' => Subtematicas::get(),

        ]);

    }
    public function store(StoreusuarioRequest $request): RedirectResponse
    {
        if($request -> hasFile(key:'requestform')){
            $file = $request->file('requestform');
            $formatosolicitud = $request->input('name_doc') .$request->curp .".". $file->guessExtension();

            if (!Storage::disk($this->disk)->exists('DocumentosRevisores/'.$formatosolicitud)){

                $fields= $request->validated();

                //$fields['constancia'] = $request -> constancia -> getClientOriginalName();

                $fields['password'] = Hash::make($fields['password']);
                $usuario = $this->model::create([
                    'rol' => $fields['rol'],
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
                    'requestform' => $formatosolicitud
                ] );
                $roles = Role::where('id', $request->rol)->get();
                $usuario->syncRoles($roles);
                $file->storeAs('public/DocumentosRevisores', $formatosolicitud);
                event(new Registered($usuario));
                return redirect()->route('usuarios.index')->with('success', 'Usuario registrado!');
            }else{
                return 'Este documento ya fue subido';
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
                    'rol' => $fields['rol'],
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
                    'constancy' => $constancia
                ] );
                $roles = Role::where('id', $request->rol)->get();
                $usuario->syncRoles($roles);
                $file->storeAs('public/DocumentosProfesores', $constancia);
                event(new Registered($usuario));
                return redirect()->route('usuarios.index')->with('success', 'Usuario registrado!');
            }else{
                return 'Este documento ya fue subido';
            }

        }

        if($request->rol == 4){
            //dd($request);
            $fields= $request->validated();
            $fields['password'] = Hash::make($fields['password']);
            $usuario = $this->model::create($fields);
            $roles = Role::where('id', $request->rol)->get();
            $usuario->syncRoles($roles);
            //$file->storeAs('public/DocumentosProfesores', $constancia);
            event(new Registered($usuario));
            return redirect()->route('usuarios.index')->with('success', 'Usuario registrado!');
        }
    }
    public function show($request)
    {
        if(Renapo::where('curp',$request)->exists()){
            $records = Renapo::where('curp',$request)->get();
        }else{
            $response = Http::get("https://curpws.bienestar.gob.mx/ServiceCurpPro/ConsultaPor/Curp/".$request);
            $data = $response->object();
            //dd($data);
            $reg = new Renapo();
            $reg->curp = $data->response->curp;
            $reg->curpRespuesta = $data->response->curpRespuesta;
            $reg->nombres = $data->response->nombres;
            $reg->apellidopaterno = $data->response->apellidoPaterno;
            $reg->apellidomaterno = $data->response->apellidoMaterno;
            $reg->save();
            $records = Renapo::where('curp',$request)->get();
        }
        return $records[0];
    }
    public function edit(User $usuarios)
    {
        //dd($usuarios);
        $tematicas = Tematicas::all();
        $instituciones = Instituciones::all();
        $tematicas->load('subtematica');
        return Inertia::render("{$this->source}Edit", [
            'titulo'    => 'Editar Usuario.',
            'routeName' => $this->routeName,
            'user' => User::find($usuarios->id),
            'tematicas' => $tematicas,
            'instituciones' => $instituciones,
            'subtematicas'=> Subtematicas::get(),
        ]);
    }
    public function update(UpdateusuarioRequest $request, User $usuarios)
    {
        //dd($usuarios);
        $usuarios->update($request->validated());
        return redirect()->route('usuarios.index')->with('success', 'Usuario modificado con éxito');
    }
    public function destroy(User $usuarios)
    {
        $usuarios->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado con éxito');
    }
}
