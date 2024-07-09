<?php

namespace App\Http\Controllers;

use App\Models\Delegado;
use App\Http\Requests\StoreDelegadoRequest;
use App\Http\Requests\UpdateDelegadoRequest;

class DelegadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Delegado::all();
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
    public function store(StoreDelegadoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Delegado $delegado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delegado $delegado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDelegadoRequest $request, Delegado $delegado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delegado $delegado)
    {
        //
    }
}
