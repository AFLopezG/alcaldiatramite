<?php

namespace App\Http\Controllers;

use App\Models\Adjunto;
use App\Http\Requests\StoreAdjuntoRequest;
use App\Http\Requests\UpdateAdjuntoRequest;
use Illuminate\Http\Request;

class AdjuntoController extends Controller
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
    public function store(StoreAdjuntoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function listAdjunto(Request $request){
        return Adjunto::where('formulario_id',$request->formulario_id)->where('proceso_id',$request->proceso_id)->get();

     }

    public function show($id)
    {
        //
        return Adjunto::with('proceso')->where('formulario_id',$id)->get();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adjunto $adjunto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdjuntoRequest $request, Adjunto $adjunto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adjunto $adjunto)
    {
        //
    }
}



