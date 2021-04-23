<?php

namespace App\Http\Controllers;

use App\Models\file_state;
use Illuminate\Http\Request;

class FileStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(file_state::get(),200);

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
        
        $file_state = file_state::create($request->all());
        return response()->json($file_state,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file_state=file_state::FindOrFail($id);
        if(is_null( $file_state)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        return response()->json( $file_state, 200);
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
        $file_state=$request->except(['id']);
        $file_state=array_filter( $file_state);
        $update1=file_state::where('id',$id)->update($file_state);

        if(is_null($file_state)){
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
       
        $file_state = file_state::FindOrFail($id);
        if(is_null($file_state)){
       // return response()->json(null,204);
        return response()->json(["message"=>'record not find!!!'], 404);
        }

        $file_state->delete();

    
}}
