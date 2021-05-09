<?php

namespace App\Http\Controllers;

use App\Models\training_file;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Mockery\Expectation;

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
    public function set_labels(Request $request,$id)
    {   
        
      return  training_file::where('model_id',$id )->where('name',$request->input('image'))
        ->update(['labels' => $request->input('labels')]);

       

    }

    public function labels(Request $request,$id)
    {   
    $config = Configuration::instance([
        'cloud' => [
            'cloud_name' => 'hi5',
            'api_key' => '323435588613243',
            'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
        'url' => [
            'secure' => true]]);
            $f = true;
            $cloudinary = new Cloudinary($config);
    $a=[];
    $query = str_replace(array('?'), array('\'%s\''), training_file::where('model_id',$id)->where('name',$request->input('image'))->toSql());
    $query = vsprintf($query, training_file::where('model_id',$id)->where('name',$request->input('image'))->getBindings());
    
    $a[0]['labels']=training_file::where('model_id',$id )->where('name',$request->input('image'))
      ->pluck('labels')->all()[0];
      $client = new Client();
     try{ $url = $cloudinary->adminApi()->asset("models/".$id."/dataset/jsons/".$request->input('image').".json",["resource_type" => "raw","type" => "private"])['url'];
      $res=$client->request('get',$url);
      $a[1] = $res->getBody()->getContents();
     }
     catch(Exception $exception){
        $a[1] = null;
     }
      return $a;

    }

}
