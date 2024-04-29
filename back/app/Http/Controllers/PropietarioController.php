<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use App\Http\Requests\StorePropietarioRequest;
use App\Http\Requests\UpdatePropietarioRequest;
use Illuminate\Http\Request;

class PropietarioController extends Controller
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
    public function store(StorePropietarioRequest $request)
    {
        //
    }

    public function searchProp(Request $request){
        if($request->complemento!=null)
            return Propietario::where('cedula',$request->cedula)->where('complemento',$request->complemento)->first();
        else
            return Propietario::where('cedula',$request->cedula)->first();
    }
    /**
     * Display the specified resource.
     */
    public function show(Propietario $propietario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Propietario $propietario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropietarioRequest $request, Propietario $propietario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Propietario $propietario)
    {
        //
    }
}
