<?php

namespace App\Http\Controllers;

use App\Models\file;
use App\Models\label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(label::get(),200);

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
        $label_tbl = label::create($request->all());
        $x = label::where('color',$request->color)->where('model_id',$request->model_id)->count();
        if($x>0)
        return response()->json("This color duplicated for model",400);
        return response()->json($label_tbl,201);
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $label_tbl=label::FindOrFail($id);
        if(is_null($label_tbl)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        return response()->json($label_tbl, 200);
    }
 
    public function labelsForModel($id)
    {   
        $label_tbl=label::where('model_id', '=', $id)->orderBy('id')->pluck('label')->toArray();;
        if(is_null($label_tbl)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        array_unshift($label_tbl , 'o');
        return $label_tbl;
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
        $label_tbl=$request->except(['id']);
        $label_tbl=array_filter($label_tbl);
        $update1=label::where('id',$id)->update($label_tbl);

        if(is_null($label_tbl)){
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
        $label_tbl=label::FindOrFail($id);
        if(is_null($label_tbl)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $label_tbl->delete();
        return response()->json(null,204);
    }
}
