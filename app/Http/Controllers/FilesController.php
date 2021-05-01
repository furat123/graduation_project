<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\file;
use Illuminate\Support\Facades\Validator;


class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json (file::get(),200);
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
        $file_tbl = file::create($request->all());
        return response()->json($file_tbl,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file_tbl=file::FindOrFail($id);
        if(is_null($file_tbl)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        return response()->json($file_tbl, 200);
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
       /* $file_tbl=$request->except(['created_date','last_use_date','owner_id','state_id']);
        $modeltbl=array_filter($modeltbl);
        $update1=model_tbls::where('id',$id)->update($modeltbl);

        if(is_null($modeltbl)){
           return response()->json(["message"=>'record not find!!!'], 404);
       }
        //$modeltbl->update($request->all());
    }
*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file_tbl=file::FindOrFail($id);
        if(is_null( $file_tbl)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $file_tbl->delete();
        return response()->json(null,204);
    
    }

    public function predict($id)
    {
        
        //
    
    }
    
    public function set_labels(Request $request,$id)
    {   
        
        file::where('user_id' , $request->input('user_id'))->where('model_id',$id )->where('name',$request->input('image'))
        ->update(['labels' => $request->input('labels')]);
       

    }

    public function update_vs(Request $request,$id)
    {   
        
        file::where('user_id' , $request->input('user_id'))->where('model_id',$id )->
        where('name',$request->input('image'))->update([ 'verify_state'
        => file::raw('1-verify_state')]);

        return file::where('user_id' , $request->input('user_id'))->where('model_id',$id )->
        where('name',$request->input('image'))->pluck('verify_state')->toArray();

    }

    public function vs(Request $request,$id)
    {   
        

       return file::where('user_id' , $request->input('user_id'))->where('model_id',$id )->
       where('name',$request->input('image'))->pluck('verify_state')->toArray();
        

       

    }

 



}
