<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use App\Models\Requisito;
use App\Models\Proceso;
use App\Http\Requests\StoreTramiteRequest;
use App\Http\Requests\UpdateTramiteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TramiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Tramite::with('unit')->with('requisitos')->with('procesos')->get();
    }

    public function unitTramite(Request $request){
        $listu=DB::SELECT("SELECT unit_id from unit_user where user_id=".$request->user()->id);
        $resultado=[];
        //return $listu;
            foreach ($listu as  $value) {
                # code...
                array_push($resultado,$value->unit_id);
            }
        return Tramite::where('estado','ACTIVO')->whereIN('unit_id',$resultado)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTramiteRequest $request)
    {
        //
        $tramite=new Tramite();
         $tramite->nombre=strtoupper($request->nombre);
         $tramite->descripcion=$request->descripcion;
         $tramite->codigo=$request->codigo;
         $tramite->unit_id=$request->unit_id;
         $tramite->save();
    }

    public function updaterequisitos(Request $request,Tramite $tramite){
        $requisitos= array();
        foreach ($request->requisitos as $requisito){
            if ($requisito['estado']==true)
                $requisitos[]=$requisito['id'];
        }
        $requisito = Requisito::find($requisitos);
        $tramite->requisitos()->detach();
        $tramite->requisitos()->attach($requisito);
    }

    public function updateprocesos(Request $request,Tramite $tramite){
        $procesos= array();
        foreach ($request->procesos as $proceso){
            if ($proceso['estado']==true)
                $procesos[]=$proceso['id'];
        }
        $proceso = Requisito::find($procesos);
        $tramite->procesos()->detach();
        $tramite->procesos()->attach($proceso);
    }
    /**
     * Display the specified resource.
     */
    public function show(Tramite $tramite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tramite $tramite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTramiteRequest $request, Tramite $tramite)
    {
        //
        $tramite=Tramite::find($request->id);
        $tramite->nombre=strtoupper($request->nombre);
        $tramite->descripcion=$request->descripcion;
        $tramite->codigo=$request->codigo;
        $tramite->unit_id=$request->unit_id;
        $tramite->save();
    }

    public function activarTramite(Request $request){
        $tramite=Tramite::find($request->id);
        if($tramite->estado=='ACTIVO')
            $tramite->estado='INACTIVO';
        else
            $tramite->estado='ACTIVO';
        $tramite->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $tramite=Tramite::find("$id");
        $tramite->delete();
    }
}
