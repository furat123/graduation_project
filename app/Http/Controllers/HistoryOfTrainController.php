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
        return response()->json(history_of_train::get(),200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row=history_of_train::FindOrFail($id);
        if(is_null($row)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        return response()->json($row, 200);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ht = history_of_train::FindOrFail($id);
      
        if(is_null($ht)){
       // return response()->json(null,204);
        return response()->json(["message"=>'record not find!!!'], 404);
        }

        return $ht->delete();
    }
}
