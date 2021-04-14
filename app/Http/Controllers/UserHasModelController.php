<?php

namespace App\Http\Controllers;

use App\Models\user_has_model;
use Illuminate\Http\Request;

class UserHasModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(user_has_model::get(),200);
      
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
         
    $user_model = user_has_model::create($request->all());
    return response()->json($user_model,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
       $user_model=user_has_model::FindOrFail($id);
       if(is_null($user_model)){
       return response()->json(["message"=>'record not find!!!'], 404);
       }
       return response()->json($user_model, 200);
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
       //not now
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_model=user_has_model::FindOrFail($id);
        if(is_null($user_model)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $user_model->delete();
        return response()->json(null,204);
    
    }
}
