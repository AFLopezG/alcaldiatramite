<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Log;
use App\Models\User;
use App\Models\Formulario;
use App\Models\Tramite;
use App\Http\Requests\StoreLogRequest;
use App\Http\Requests\UpdateLogRequest;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreLogRequest $request)
    {
        //
        $lg=Log::find($request->log_id);
        $lg->estado='DERIVADO';
        $lg->save();
        
        $norden=$request->orden + 1;
        $r1=Tramite::with('procesos')->where('id',$request->tramite_id)->first();
        //return $r1;
        foreach ($r1->procesos as $value) {
            if($value->pivot['orden']==$norden){
                $proceso=$value;
            }
        }
        $log=new Log;
        $log->fecha=date('Y-m-d');
        $log->hora=date('H:i:s');
        $log->orden=$norden;
        $log->estado='EN PROCESO';
        $log->user_id=$request->user()->id;
        $log->user_id2=$request->user_id;    
        $log->formulario_id=$request->formulario_id;
        $log->proceso_id=$proceso->id;
        $log->save();

    }

    public function reasignar(Request $request){
        //$formulario=Formulario::find($request->id);

        $log=Log::where('formulario_id',$request->formulario_id)->orderBy('id','desc')->first();
        $log->user_id2=$request->user_id;
        $log->save();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return Log::with('proceso')->with('user2')->where('formulario_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLogRequest $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log)
    {
        //
    }
}
