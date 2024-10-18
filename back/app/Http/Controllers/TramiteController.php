<?php

namespace App\Http\Controllers;

use App\Models\Tramite;
use App\Models\Requisito;
use App\Models\Proceso;
use App\Models\User;
use App\Models\Log;
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
        return Tramite::with('unit')->get();
    }

    public function unitTramite(Request $request){
        $listu=DB::SELECT("SELECT unit_id from unit_user where user_id=".$request->user()->id);
        $resultado=[];
        //return $listu;
            foreach ($listu as  $value) {
                # code...
                array_push($resultado,$value->unit_id);
            }
        return Tramite::with('requisitos')->with('procesos')->where('estado','ACTIVO')->whereIN('unit_id',$resultado)->get();
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

    public function agregarRequisito(Request $request ){
        $valida = DB::SELECT("SELECT * from requisito_tramite where requisito_id=$request->requisito_id and tramite_id=$request->tramite_id");
        if(sizeof($valida)==0)
        {
            DB::SELECT("INSERT INTO requisito_tramite  (requisito_id,tramite_id) values ($request->requisito_id, $request->tramite_id)");
        }
    }

    public function agregarProceso(Request $request ){
        $valida = DB::SELECT("SELECT * from proceso_tramite where proceso_id=$request->proceso_id and tramite_id=$request->tramite_id and orden = $request->orden");

        if(sizeof($valida)==0)
        {
            DB::SELECT("INSERT INTO proceso_tramite  (proceso_id,tramite_id,orden) values ($request->proceso_id, $request->tramite_id,$request->orden)");
        }
    }

    public function retirarRequisito(Request $request){
        return DB::SELECT("DELETE FROM requisito_tramite where requisito_id=$request->requisito_id and tramite_id=$request->tramite_id ");
    }

    public function retirarProceso(Request $request){
        $cambio =DB::select("SELECT * FROM proceso_tramite where orden > $request->orden and tramite_id=$request->tramite_id");
        foreach ($cambio as $value) {
            # code...
            DB::SELECT("UPDATE proceso_tramite set orden=orden - 1 where id = $value->id");
        }
        return DB::SELECT("DELETE FROM proceso_tramite where proceso_id=$request->proceso_id and tramite_id=$request->tramite_id");
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
    public function show($id)
    {
        //
        return Tramite::with('requisitos')->with('procesos')->where('id',$id)->first();

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

    public function nextProc(Request $request){
        $norden=$request->orden + 1;

        $r1=Tramite::with('procesos')->where('id',$request->id)->first();
        //return $r1;
        foreach ($r1->procesos as $value) {
            if($value->pivot['orden']==$norden){
            $users =DB::SELECT("SELECT u.id,u.name,ps.prof from users u inner join profile_user p on u.id=p.user_id inner join profiles ps on ps.id=p.profile_id
            where u.state='ACTIVO' and p.profile_id in (select pp.profile_id from procesos pr inner join proceso_profile pp on pr.id = pp.proceso_id where pr.id=$value->id)");
            $value->usuarios=$users;
            if(sizeof($users)==0)
                return response(['message' => 'Fin de Tramite'],400);
            return $value;
        }

            # code...
        }
        /*$res= Proceso::with(['profiles', 'profiles.users.profile'])
        ->whereHas('proceso_tramite', function($query) use ($request) {
            $query->where('tramite_id', $request->id);
        })
        ->whereHas('tramites', function ($query) use ($norden) {
            $query->wherePivot('orden', $norden);
        })
        ->get();*/
    }

    public function listProcUser(Request $request){
        $r1=Proceso::with('profiles')->where('id',$request->id)->first();
        $list=[];
        foreach ($r1->profiles as  $value) {
            # code...
            array_push($list,$value['id']);
        }
        $users = User::whereHas('profiles', function($query) use ($list) {
                $query->whereIn('profile_id', $list);}
        )->get();
        $r1->usuarios=$users;
        if(sizeof($users)==0)
            return false;
        return $r1;
    }

    public function cambioUserProc(Request $request){
        $log=Log::find($request->id);
        if($log->user_id2==$request->user_id)
            return false;
        $log->obs =$log->obs.' * '.$request->motivo;
        $log->estado='CAMBIO';
        $log->save();

        $log2=new Log();
        $log2->fecha=date('Y-m-d');
        $log2->hora=date('H:i:s');
        $log2->orden=$log->orden;
        $log2->estado='EN PROCESO';
        $log2->user_id=$log->user_id;
        $log2->user_id2=$request->user_id;
        $log2->formulario_id=$log->formulario_id;
        $log2->proceso_id=$log->proceso_id;
        $log2->save();

    }

    public function rechazar(Request $request){
        //return $request;

        $log= Log::find($request->latest_log['id']);
        $log->obs=$log->obs.' * '.$request->comentario;
        $log->estado='RECHAZADO';
        $log->save();

        $norden=$log->orden - 1;

        $r1=Tramite::with('procesos')->where('id',$request->tramite_id)->first();
        //return $r1;
        foreach ($r1->procesos as $value) {
            if($value->pivot['orden']==$norden){
                $proceso=$value;
            }
        }


        $log2=new Log();
        $log2->formulario_id= $log->formulario_id;
        $log2->user_id=$log->user_id2;
        $log2->user_id2=$log->user_id;
        $log2->fecha=date('Y-m-d');
        $log2->hora=date('H:i:s');
        $log2->orden=$norden;
        $log2->estado='EN PROCESO';
        $log2->proceso_id=$proceso->id;
        $log2->save();

    }

}
