<?php

namespace App\Http\Controllers;

use App\Models\Expedientes;
use App\Http\Requests\StoreExpedientesRequest;
use App\Http\Requests\UpdateExpedientesRequest;

class ExpedientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreExpedientesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpedientesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expedientes  $expedientes
     * @return \Illuminate\Http\Response
     */
    public function show(Expedientes $expedientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expedientes  $expedientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Expedientes $expedientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpedientesRequest  $request
     * @param  \App\Models\Expedientes  $expedientes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpedientesRequest $request, Expedientes $expedientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expedientes  $expedientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expedientes $expedientes)
    {
        //
    }
}
