<?php
use App\Http\Controllers\UserHasModelController;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\model_tbls;
use App\Models\label;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Cloudinary\Configuration\Configuration;
use ZipArchive;
use Cloudinary\Cloudinary as Cloudinary;
use App\Models\file;
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
    $model_tbl = model_tbls::create($request->except('image'));
    $config = Configuration::instance([
      'cloud' => [
        'cloud_name' => 'hi5',
        'api_key' => '323435588613243',
        'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
      'url' => [
        'secure' => true]]);
        $cloudinary = new Cloudinary($config);
      
        $cloudinary->uploadApi()->upload((string)$request->file('image'),
        ["public_id" => 'image' , "type" => "upload"
         , "resource_type	" => "private" , "folder" => "models/".$model_tbl->id]);
        


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

       $modeltbl = model_tbls::Find($id);

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
        ['multipart' => $multipart]);
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

    public function getProgress_op(Request $request,$id)
    {
    return model_tbls::FindOrFail($id)['progress_op'];
    }

    public function setProgress_op(Request $request,$id)
    {
     if(model_tbls::FindOrFail($id)->update(['progress_op'=> $request->input('progress')]))
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
        $apiRequest = $client->request('POST', 'https://hi55.herokuapp.com/train/'.$id,['form_params' => ["labels"=>json_encode($labels)]]);
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
        $apiRequest = $client->request('POST', 'https://hi55.herokuapp.com/predict/'.$id,['multipart' => $multipart]);
        return   $apiRequest->getBody();
    }


    public function store_dataset(Request $request,$id)
    {

      // configure globally via a JSON object


       $config = Configuration::instance([
        'cloud' => [
          'cloud_name' => 'hi5',
          'api_key' => '323435588613243',
          'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
        'url' => [
          'secure' => true]]);
          $cloudinary = new Cloudinary($config);

          
          foreach ($request->file('images') as $file)
          $cloudinary->uploadApi()->upload((string)$file,
          ["public_id" => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) , "type" => "private"
           , "resource_type	" => "private" , "folder" => "models/".$id."/dataset"]);
          return "Ahmad mohammad ";


    }

    public function delete_from_dataset(Request $request)
    {

          $config = Configuration::instance([
            'cloud' => [
              'cloud_name' => 'hi5',
              'api_key' => '323435588613243',
              'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
            'url' => [
              'secure' => true]]);
              $cloudinary = new Cloudinary($config);
              foreach ($request->input('publicIds') as $node)
              print($node);
            return   $cloudinary->adminApi()->deleteAssets($request->input("publicIds"),["type" => "private"]);


    }


    public function get_dataset(Request $request,$id)
    {

          // $client= new Client();
          // $apiRequest = $client->request('GET', "https://hi55.herokuapp.com/dataset/".$id);
          // $url =  $apiRequest->getBody();
          // $apiRequest = $client->request('GET', (string)$url);
          // return response($apiRequest->getBody()->getContents(), 200)
          // ->header('Content-Type', 'application/zip')->header('Content-disposition','attachment; filename="data_set.zip"');
          $config = Configuration::instance([
            'cloud' => [
              'cloud_name' => 'hi5',
              'api_key' => '323435588613243',
              'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
            'url' => [
              'secure' => true]]);
              $cloudinary = new Cloudinary($config);
           return   $cloudinary->adminApi()->assets(["prefix"=>"models/".$id."/dataset", "max_results" => 500 ,'type' => 'private']);


    }

    public function delete_all_dataset(Request $request,$id)
    {
      $config = Configuration::instance([
        'cloud' => [
          'cloud_name' => 'hi5',
          'api_key' => '323435588613243',
          'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
        'url' => [
          'secure' => true]]);
          $cloudinary = new Cloudinary($config);
          return   $cloudinary->adminApi()->deleteAssetsByPrefix("models/".$id."/dataset", ['type' => 'private']);




    }

    
    public function store_predict(Request $request,$id)
    {

      // configure globally via a JSON object


       $config = Configuration::instance([
        'cloud' => [
        'cloud_name' => 'hi5',
        'api_key' => '323435588613243',
        'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
        'url' => [
        'secure' => true]]);
        $cloudinary = new Cloudinary($config);
        foreach ($request->file('images') as $file){
     $i= file::create(['name'=>$file->getClientOriginalName() , 'model_id' => $id ,'user_id' => $request->input('user_id')]);
     return $i;  
     print_r($i);
        $cloudinary->uploadApi()->upload((string)$file,
        ["public_id" => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) , "type" => "private"
         , "resource_type	" => "private" , "folder" => "models/".$id."/predict"."/".$request->input('user_id')]);
        }
        return "ahmad";


    }

    public function delete_from_predict(Request $request)
    {

          $config = Configuration::instance([
            'cloud' => [
              'cloud_name' => 'hi5',
              'api_key' => '323435588613243',
              'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
            'url' => [
              'secure' => true]]);
              $cloudinary = new Cloudinary($config);
              foreach ($request->input('publicIds') as $node)
              print($node);
            return   $cloudinary->adminApi()->deleteAssets($request->input("publicIds"),["type" => "private"]);


    }


    public function get_predict(Request $request,$id)
    {

          // $client= new Client();
          // $apiRequest = $client->request('GET', "https://hi55.herokuapp.com/dataset/".$id);
          // $url =  $apiRequest->getBody();
          // $apiRequest = $client->request('GET', (string)$url);
          // return response($apiRequest->getBody()->getContents(), 200)
          // ->header('Content-Type', 'application/zip')->header('Content-disposition','attachment; filename="data_set.zip"');
          $config = Configuration::instance([
            'cloud' => [
              'cloud_name' => 'hi5',
              'api_key' => '323435588613243',
              'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
            'url' => [
              'secure' => true]]);
              $cloudinary = new Cloudinary($config);
           return   $cloudinary->adminApi()->assets(["prefix"=>"models/".$id."/dataset", "max_results" => 500 ,'type' => 'private']);


    }

    public function delete_all_predict(Request $request,$id)
    {
      $config = Configuration::instance([
        'cloud' => [
          'cloud_name' => 'hi5',
          'api_key' => '323435588613243',
          'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
        'url' => [
          'secure' => true]]);
          $cloudinary = new Cloudinary($config);
          return   $cloudinary->adminApi()->deleteAssetsByPrefix("models/".$id."/dataset", ['type' => 'private']);




    }


    public function get_csvs(Request $request,$id)
    {

          $client= new Client();
          $apiRequest = $client->request('GET', "https://hi55.herokuapp.com/get_object_maps/".$id);
          $url =  $apiRequest->getBody();
          $apiRequest = $client->request('GET', (string)$url);
          return response($apiRequest->getBody()->getContents(), 200)
          ->header('Content-Type', 'application/zip')->header('Content-disposition','attachment; filename="object_maps.zip"');


    }

    public function object_map_labeling(Request $request,$id)
    {
          $multipart = [];
          $client= new Client();
          foreach ($request->file('csvs') as $file)
          $multipart[] = array('name'=>'csv','contents'=>fopen($file,'r'),'filename'=>$file->getClientOriginalName());
          foreach ($request->input('nodes') as $node)
          $multipart[] = array('name'=>'nodes','contents'=>$node);
          $apiRequest = $client->request('POST', "https://hi55.herokuapp.com/object_map_labeling/".$id, [ 'multipart' => $multipart]);
          return  $apiRequest->getBody();


    }

    public function image(Request $request,$id)
    {
          $url = "https://res.cloudinary.com/hi5/image/upload/v1619392994/models/".$id."/image";

          return  $url;


    }

    public function text_form_box(Request $request)
    {
          $multipart = [];
          $client= new Client();
          $multipart[] = array('name'=>'csv','contents'=>fopen($request->file('csv'),'r'),"filename" => "assa");
          $multipart[] = array('name'=>'node','contents'=>$request->input('node'));
          $apiRequest = $client->request('POST', "https://hi55.herokuapp.com/text_form_box", [ 'multipart' => $multipart]);
          return  $apiRequest->getBody();


    }







}
