<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Unit::all();
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
    public function store(StoreUnitRequest $request)
    {
        //
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|unique:units'
        ]);
        $unit =new Unit();
        $unit->nombre=strtoupper($request->nombre);
        $unit->codigo=strtoupper($request->codigo);
        $unit->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        //
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|unique:units'.$request->id
        ]);
        $unit = Unit::find($request->id);
        $unit->nombre=strtoupper($request->nombre);
        $unit->codigo=strtoupper($request->codigo);
        $unit->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $unit = Unit::find($id);
        $unit->delete();

    }
}
