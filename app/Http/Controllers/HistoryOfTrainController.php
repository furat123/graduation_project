<?php

namespace App\Http\Controllers;

use App\Models\history_of_train;
use Illuminate\Http\Request;

class historyOfTrainController extends Controller
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
    return history_of_train::create(
          $request->all()
    )->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\history_of_train  $history_of_train
     * @return \Illuminate\Http\Response
     */
    public function show(history_of_train $history_of_train)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\history_of_train  $history_of_train
     * @return \Illuminate\Http\Response
     */
    public function edit(history_of_train $history_of_train)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\history_of_train  $history_of_train
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, history_of_train $history_of_train)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\history_of_train  $history_of_train
     * @return \Illuminate\Http\Response
     */
    public function destroy(history_of_train $history_of_train)
    {
        //
    }
}
