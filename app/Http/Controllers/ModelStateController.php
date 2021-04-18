<?php

namespace App\Http\Controllers;

use App\Models\model_states;
use Illuminate\Http\Request;

class ModelStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(model_states::get(),200);

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
        $model_state = model_states::create($request->all());
        return response()->json($model_state,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model_state=model_states::FindOrFail($id);
       if(is_null($model_state)){
       return response()->json(["message"=>'record not find!!!'], 404);
       }
       return response()->json($model_state, 200);

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
        
        $model_state=$request->except(['id']);
        $model_state=array_filter($model_state);
        $update1=model_states::where('id',$id)->update($model_state);

        if(is_null($model_state)){
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
        $model_sate=model_states::FindOrFail($id);
        if(is_null($model_sate)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $model_sate->delete();
        return response()->json(null,204);
    }
        
    
    }

