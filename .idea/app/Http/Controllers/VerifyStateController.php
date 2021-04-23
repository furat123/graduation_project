<?php

namespace App\Http\Controllers;

use App\Models\verify_state;
use Illuminate\Http\Request;

class VerifyStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(verify_state::get(),200);

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
        $verify_state = verify_state::create($request->all());
        return response()->json($verify_state,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $verify_state=verify_state::FindOrFail($id);
       if(is_null($verify_state)){
       return response()->json(["message"=>'record not find!!!'], 404);
       }
       return response()->json($verify_state, 200);
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
        $verify_state=$request->except(['id']);
        $verify_state=array_filter($verify_state);
        $update1=verify_state::where('id',$id)->update($verify_state);

        if(is_null($verify_state)){
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
        $verify_sate=verify_state::FindOrFail($id);
        if(is_null($verify_sate)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $verify_sate->delete();
        return response()->json(null,204);
    }
}
