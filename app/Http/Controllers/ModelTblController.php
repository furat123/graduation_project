<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\model_tbls;
use App\Models\label;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
class ModelTblController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(model_tbls::get(),200);
        return "nnn";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "nothing to save ";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $model_tbl = model_tbls::create($request->all());
    return response()->json($model_tbl,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
       $modeltbl=model_tbls::FindOrFail($id);
       if(is_null($modeltbl)){
       return response()->json(["message"=>'record not find!!!'], 404);
       }
       return response()->json($modeltbl, 200);


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
        $modeltbl=$request->except(['created_date','last_use_date','owner_id','state_id']);
        $modeltbl=array_filter($modeltbl);
        $update1=model_tbls::where('id',$id)->update($modeltbl);

        if(is_null($modeltbl)){
           return response()->json(["message"=>'record not find!!!'], 404);
       }
        //$modeltbl->update($request->all());
     //  return response()->json($modeltbl,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
        $modeltbl=model_tbls::FindOrFail($id);
        if(is_null($modeltbl)){
        return response()->json(["message"=>'record not find!!!'], 404);
        }
        $modeltbl->delete();
        return response()->json(null,204);
    } 
     public function csvs(Request $request,$id)
    {
        $multipart=[];
        $client= new Client();
        foreach ($request->file('images') as $file)
       $multipart[] = array('name'=>'images','contents'=>fopen($file,'r'),'filename'=>$file->getClientOriginalName()); 
       //$apiRequest = $client->request('POST', 'http://127.0.0.1:5000/predict/'.$id,['multipart' => $multipart]);
       $apiRequest = $client->request('POST','https://hi55.herokuapp.com/object_map_generation/'.$id, 
        [
        'multipart' => $multipart]);
        return   $apiRequest->getBody();

    }
    
    public function getProgress(Request $request,$id)
    {
    return model_tbls::FindOrFail($id)['progress'];
    }

    public function setProgress(Request $request,$id)
    {
     if(model_tbls::FindOrFail($id)->update(['progress'=> $request->input('progress')]))
       return response()->json("Progress updated successfully",200);
     else 
       return response()->json("Something goes wrong",500);

     
    }

    public function train(Request $request,$id)
    {

        $client= new Client();
        $labels=new LabelController();
        $labels=$labels->labelsForModel($id);
        //$apiRequest = $client->request('POST', 'http://127.0.0.1:5000/train/'.$id,['form_params' => ["labels"=>json_encode($labels)]]);
        $apiRequest = $client->request('POST', 'https://hi55.herokuapp.com/train'.$id,['form_params' => ["labels"=>json_encode($labels)]]);
        return   $apiRequest->getBody();  
    }


    public function predict(Request $request,$id)
    {

        $client= new Client();
        $labels=new LabelController();
        $labels=$labels->labelsForModel($id);
        $file=$request->file('image');
        $multipart[]=array('name'=>'image','contents'=>fopen($file,'r'),'filename'=>$file->getClientOriginalName());
        $multipart[]=array('name'=>'labels','contents'=>json_encode($labels));
        //$apiRequest = $client->request('POST', 'http://127.0.0.1:5000/predict/'.$id,['multipart' => $multipart]);
        $apiRequest = $client->request('POST', 'https://graduationprojectt.herokuapp.com/api/predict/'.$id,['multipart' => $multipart]);
        return   $apiRequest->getBody();  
    }
    

    public function store_op(Request $request,$id)
    {

       
    }



}
