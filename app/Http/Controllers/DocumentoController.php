<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\documento;
use App\Models\DocumentoUsuario;
use App\Notifications\Expediente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notification;
use App\Http\Requests\StoredocumentoRequest;
use App\Http\Requests\UpdatedocumentoRequest;
use Illuminate\Support\Facades\Artisan;

class DocumentoController extends Controller
{
    private documento $model;
    private string $source;
    private string $routeName;
    private string $module = 'documento';
    private $disk = 'public';

    //Para proteger nuestras rutas
    public function __construct()
    {
        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);
    }

    //Metodo donde renderiza al metodo donde subira el los documentos el alumno
    public function index()
    {

    }


    public function create()
    {
        return Inertia::render("Documentos/Create", [
            'titulo'          => 'Agregar Documentos',

        ]);
    }


    public function store(StoredocumentoRequest $request)
    {
        documento::create($request->validated());
        return redirect()->route('documento.index')->with('success', 'Documento guardado con éxito!');
    }


    public function show(documento $documento)
    {
        //
    }


    public function edit(documento $documento)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Documentos',
            'routeName'      => $this->routeName,
            'documentos' => $documento
        ]);
    }
    public function update(UpdatedocumentoRequest $request, documento $documento)
    {
        $documento->update($request->validated());
        return redirect()->route('documento.index')->with('success', 'Documento actualizado correctamente!');
    }
    public function destroy(documento $documento)
    {
        $documento->delete();
        return redirect()->route('documento.index')->with('success', 'Documento eliminado con éxito');
    }
}
