<?php

namespace App\Http\Controllers;

use App\Models\hestory_of_model;
use Illuminate\Http\Request;

class HestoryOfModelController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    hestory_of_model::create(
          $request->all()
    );
    return hestory_of_model::getPdo()->lastInsertId();;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\hestory_of_model  $hestory_of_model
     * @return \Illuminate\Http\Response
     */
    public function show(hestory_of_model $hestory_of_model)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\hestory_of_model  $hestory_of_model
     * @return \Illuminate\Http\Response
     */
    public function edit(hestory_of_model $hestory_of_model)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\hestory_of_model  $hestory_of_model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, hestory_of_model $hestory_of_model)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\hestory_of_model  $hestory_of_model
     * @return \Illuminate\Http\Response
     */
    public function destroy(hestory_of_model $hestory_of_model)
    {
        //
    }
}
