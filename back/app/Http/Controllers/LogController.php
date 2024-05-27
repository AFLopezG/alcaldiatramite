<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Log;
use App\Models\User;
use App\Models\Formulario;
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

        $user2=User::find($request->user_id);
        $log=new Log;
        $log->fecha=date('Y-m-d');
        $log->hora=date('H:i:s');
        $log->obs=$request->obs;
        $log->user_id=$request->user()->id;
        $log->user_id2=$request->user_id;    
        $log->formulario_id=$request->formulario_id;
        $log->cargo_id=$user2->cargo_id;
        $log->save();

        $formulario=Formulario::find($request->formulario_id);
        $formulario->estado='PROCESO';
        $formulario->save();
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
    public function show(Log $log)
    {
        //
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
