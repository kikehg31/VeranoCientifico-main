<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Proyectos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Instituciones;

class ReportesController extends Controller
{

    public function __construct()
    {
        //Se le asigna el permiso nombrado 'pdf' a el metodo pdf de este controlador
        $this->middleware("permission:pdf")->only(['pdf']);
        //Se le asigna el permiso nombrado 'reportes.index' a el metodo index de este controlador
        $this->middleware("permission:reportes")->only(['index']);

    }

    public function index(){
        //dd(asset('/public/img/login.jpg'));
    return Inertia::render("Reportes/Reporte",[
        'instituto' => Instituciones::orderBy('id')->get(),
    ]);

    }

    public function pdf(Request $request){
        //dd($request->tipo2);
        if($request->tipo==1){
            if($request->tipo2!=null){
                $proyectos = Proyectos::select('thematics.name as thematic_name', DB::raw('count(*) as total'))
                ->join('thematics', 'proyectos.thematic_id', '=', 'thematics.id')
                ->where('institution_id', $request->tipo2)
                ->groupBy('thematics.name')
                ->get();
            }else{
                $proyectos = Proyectos::select('thematics.name as thematic_name', DB::raw('count(*) as total'))
                ->join('thematics', 'proyectos.thematic_id', '=', 'thematics.id')
                ->groupBy('thematics.name')
                ->get();
            }
            return Inertia::render('Reportes/Tematicas', [
                'proyectos' => $proyectos
            ]);
        }

        if($request->tipo==2){
            $proyectos = Proyectos::select('institutions.name as institution', DB::raw('count(*) as total'))
                ->join('institutions', 'proyectos.institution_id', '=', 'institutions.id')
                ->groupBy('institutions.name')
                ->get();
            return Inertia::render('Reportes/Instituciones', [
                'proyectos' => $proyectos
            ]);
        }

        if($request->tipo==3){
            $proyectos = Proyectos::select(DB::raw("CONCAT(users.name, ' ', users.lastnamep, ' ', users.lastnamem) as user"), DB::raw('count(*) as total'))
                ->join('users', 'proyectos.user_id', '=', 'users.id')
                ->groupBy('users.id', 'users.name', 'users.lastnamep', 'users.lastnamem')
                ->get();
            return Inertia::render('Reportes/Profesores', [
                'proyectos' => $proyectos
            ]);
        }
    }
}
