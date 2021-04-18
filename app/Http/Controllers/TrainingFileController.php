<?php

namespace App\Http\Controllers;

use App\Models\training_file;
use Illuminate\Http\Request;

class TrainingFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(training_file::get(),200);
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
    $train_file = training_file::create($request->all());
    return response()->json($train_file,201);
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $train_file=training_file::FindOrFail($id);
       if(is_null($train_file)){
       return response()->json(["message"=>'record not find!!!'], 404);
       }
       return response()->json($train_file, 200);
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
        //no
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $train_file=training_file::FindOrFail($id);
        if(is_null( $train_file )){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $train_file->delete();
        return response()->json(null,204);
    
    }
}
