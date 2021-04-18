<?php

namespace App\Http\Controllers;

use App\Models\training_state;
use Illuminate\Http\Request;

class TrainingStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(training_state::get(),200);
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
        $train_state = training_state::create($request->all());
        return response()->json($train_state,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $train_state=training_state::FindOrFail($id);
       if(is_null($train_state)){
       return response()->json(["message"=>'record not find!!!'], 404);
       }
       return response()->json($train_state, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $train_state=$request->except(['id']);
        $train_state=array_filter( $train_state);
        $update1=training_state::where('id',$id)->update($train_state);

        if(is_null($train_state)){
           return response()->json(["message"=>'record not find!!!'], 404);
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $train_state=training_state::FindOrFail($id);
        if(is_null( $train_state )){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $train_state->delete();
        return response()->json(null,204);
    }
}
