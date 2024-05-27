<?php

namespace App\Http\Controllers;

use App\Models\Requisito;
use App\Http\Requests\StoreRequisitoRequest;
use App\Http\Requests\UpdateRequisitoRequest;

class RequisitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Requisito::all();
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
    public function store(StoreRequisitoRequest $request)
    {
        //  
        $requisito=new Requisito();
        $requisito->detalle=$request->detalle;
        $requisito->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Requisito $requisito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requisito $requisito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequisitoRequest $request, Requisito $requisito)
    {
        //
        $requisito=Requisito::find($request->id);
        $requisito->detalle=$request->detalle;
        $requisito->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $requisito=Requisito::find($id);
        $requisito->delete();
    }
}
