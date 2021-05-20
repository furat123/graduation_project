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

    public function showforuser(Request $request, $id )
    {
        $uid =  $request->user()->id;
        return response()->json(user_has_model::join('model_tbls' ,'user_has_models.model_id', '=', 'model_tbls.id')
        ->join('users','users.id',"=","user_has_models.user_id")
         ->where('owner_id','!=',$uid)->where('user_id',$uid)->select('user_has_models.*','users.name','owner_id')->get(),200);
      
    }

    public function showforowner($id)
    {
        return response()->json(user_has_model::join('model_tbls' ,'user_has_models.model_id', '=', 'model_tbls.id')
        ->join('users','users.id',"=","user_has_models.user_id")
         ->where('owner_id',$id)->where('user_has_models.user_id','!=',$id)->select('user_has_models.*','users.name','owner_id')->get(),200); 
    }

    public function showformodel(Request $request ,$id)
    {    $uid =  $request->user()->id;
        return response()->json(user_has_model::join('model_tbls' ,'user_has_models.model_id', '=', 'model_tbls.id')
        ->join('users','users.id',"=","user_has_models.user_id")
         ->where('owner_id',$uid)->where('user_id','!=',$uid)->where('user_has_models.model_id',$id)->select('user_has_models.*','users.name','owner_id')->get(),200); 
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
    $num = user_has_model::where('user_id',$request->user_id)->where('model_id',$request->model_id)->count();
    if($num > 0)
    {
        return response()->json("Error the user was sent request to this model ",400);
    }
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
        $user_model=$request->except(['user_id','model_id','end_date']);
        $modeltbl=array_filter( $user_model);
        $update1=user_has_model::where('id',$id)->update($user_model);

        if(is_null($user_model)){
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
        $user_model=user_has_model::FindOrFail($id);
        if(is_null($user_model)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        
        //delete files for this model
        $user_model->fun_file()->delete();
        $user_model->delete();
    
    }
    public function user_model_id($id,$modelId)
    {
   
       return user_has_model::where('user_id', $id)->where('model_id',$modelId);
    }
}
