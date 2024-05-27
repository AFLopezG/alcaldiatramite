<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\Profile;
use App\Http\Requests\StoreProcesoRequest;
use App\Http\Requests\UpdateProcesoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Proceso::with('profiles')->get();
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
    public function store(StoreProcesoRequest $request)
    {
        //
        $proceso=new Proceso();
        $proceso->nombre=strtoupper($request->nombre);
        $proceso->descripcion=$request->descripcion;
        $proceso->esfuerzo=$request->esfuerzo;
        $proceso->dias=$request->dias;
        $proceso->save();

    }

    /**
     * Display the specified resource.
     */
    public function show(Proceso $proceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proceso $proceso)
    {
        //
    }

    public function upPerfilProc(Request $request,Proceso $proceso){
        //return $proceso;
        $profiles= array();
        foreach ($request->perfiles as $profile){
            if ($profile['estado']==true)
                $profiles[]=$profile['id'];
        }
        $profile = Profile::find($profiles);
        $proceso->profiles()->detach();
        $proceso->profiles()->attach($profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcesoRequest $request, Proceso $proceso)
    {
        //
        $proceso=Proceso::find($request->id);
        $proceso->nombre=strtoupper($request->nombre);
        $proceso->descripcion=$request->descripcion;
        $proceso->esfuerzo=$request->esfuerzo;
        $proceso->dias=$request->dias;
        $proceso->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $proceso=Proceso::find($id);
        $proceso->delete();
    }
}
