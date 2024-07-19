<?php

namespace App\Http\Controllers;

use App\Models\Rectificado;
use App\Models\Formulario;
use App\Models\Log;
use App\Http\Requests\StoreRectificadoRequest;
use App\Http\Requests\UpdateRectificadoRequest;
use Illuminate\Http\Request;

class RectificadoController extends Controller
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
    public function store(StoreRectificadoRequest $request)
    {
        //
        $formulario=Formulario::find($request->formulario_id);
        if($formulario->estado='EN PROCESO')
        {
            $formulario->estado='RECTIFICAR';
            $formulario->save();

            $rectificado=new Rectificado();
            $rectificado->inicio=date('Y-m-d H:i:s');
            $rectificado->orden=$request->orden;
            $rectificado->descripcion=$request->descripcion;
            $rectificado->formulario_id=$request->formulario_id;
            $rectificado->proceso_id=$request->proceso_id;
            $rectificado->user_id=$request->user()->id;
            $rectificado->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rectificado $rectificado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rectificado $rectificado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRectificadoRequest $request, Rectificado $rectificado)
    {
        //
        $rectificado=Rectificado::find($request->id);
        $formulario=Formulario::find($rectificado->formulario_id);
        if($formulario->estado='RECTIFICAR')
        {
            $formulario->estado='EN PROCESO';
            $formulario->save();

            $rectificado->fin=date('Y-m-d H:i:s');
            $rectificado->save();
        }
    }

    public function cancelarTramite(Request $request){
        $formulario=Formulario::find($request->formulario_id);
        if($formulario->estado='RECTIFICAR')
        {
            $formulario->estado='CANCELADO';
            $formulario->save();
            $log=Log::where('formulario_id',$formulario->id)->orderBy('id','desc')->first();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rectificado $rectificado)
    {
        //
    }
}
