<?php
namespace App\Http\Controllers;
use App\Http\Controllers\UserHasModelController;
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
use App\Models\training_file;
use App\Models\user_has_model;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Thread;
use Threaded;

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
    //print_r($request->except('image'));
    $model_tbl = model_tbls::create($request->except('image'));
    //$model_tbl = model_tbls::create($request->all());

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
         , "resource_type	" => "raw" , "folder" => "models/".$model_tbl->id]);
        $uid =$request->user()['id'];
        user_has_model::create(["user_id" =>$uid ,"model_id" => $model_tbl->id,"accept" => 1]);
       
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
        $modeltbl=$request->except(['created_date','last_use_date','owner_id','image']);
        $modeltbl=array_filter($modeltbl);
        $update1=model_tbls::where('id',$id)->update($modeltbl);

        if(is_null($modeltbl)){
           return response()->json(["message"=>'record not find!!!'], 404);
       }
        //$modeltbl->update($request->all());
        $config = Configuration::instance([
          'cloud' => [
            'cloud_name' => 'hi5',
            'api_key' => '323435588613243',
            'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
          'url' => [
            'secure' => true]]);
            $cloudinary = new Cloudinary($config);
          if($request->file('image') != null)
          try{

            $cloudinary->uploadApi()->upload((string)$request->file('image'),
            ["public_id" => 'image' , "type" => "upload"
             , "resource_type	" => "raw" , "folder" => "models/".$id]);
          }catch(Exception $e){
            return response()->json("false",404);
          }
        

       return response()->json("true",200);
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
       $apiRequest = $client->request('POST', 'http://127.0.0.1:5000/object_map_generation/'.$id,['multipart' => $multipart]);
       // $apiRequest = $client->request('POST','https://hi55.herokuapp.com/object_map_generation/'.$id, ['multipart' => $multipart]);
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

    public function getProgress_re(Request $request,$id)
    {
    return model_tbls::FindOrFail($id)['progress_re'];
    }

    public function setProgress_re(Request $request,$id)
    {
     if(model_tbls::FindOrFail($id)->update(['progress_re'=> $request->input('progress')]))
       return response()->json("Progress updated successfully",200);
     else
       return response()->json("Something goes wrong",500);


    }

    public function train(Request $request,$id)
    {
        $client= new Client();
        $labels=new LabelController();
        $labels=$labels->labelsForModel($id);
        $owner = model_tbls::where('id',$id)->get('owner_id');
        $owner=$owner->map(function ($owner) {
        return $owner->only(['owner_id']);

      });

      $owner=$owner[0]['owner_id'];
      print($owner);
      //$apiRequest = $client->request('POST', 'http://127.0.0.1:5000/train/'.$id,['form_params' => [ "owner_id" => $owner ,"labels"=>json_encode($labels)]]);
      $apiRequest = $client->request('POST', 'https://hi55.herokuapp.com/train/'.$id,['form_params' => ["owner_id" => $owner ,"labels"=>json_encode($labels)]]);
      return   $apiRequest->getBody();
    }

    public function test(Request  $request){
      $all = model_tbls::all();
      foreach($all as $k => $r)
      {
        print($r->id);
        $r=$r->toArray();
        print_r($r);
       user_has_model::create(["user_id" =>$r['owner_id'] ,"model_id" => $r['id'],"accept" => 1]);
      }
      return $all;
    }

  public function getCurrent($id){
   $x=  DB::table('history_of_trains')
    ->where('model_id',$id)
    ->where('verify', 1 )
    ->max('id');
  $x1= DB::table('history_of_trains')
  ->where('model_id',$id)
  ->max('id');
  if($x != $x1)
  {
    return -1;
  }

  return $x;

    }

    public function getCurrent_for_predict($id){
      return DB::table('history_of_trains')
       ->where('model_id',$id)
       ->where('verify', 1 )
       ->max('id');
      
   
       }

    public function predict(Request $request,$id)
    {
        $client= new Client();
        $config = Configuration::instance([
         'cloud' => [
         'cloud_name' => 'hi5',
         'api_key' => '323435588613243',
         'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
         'url' => [
         'secure' => true]]);
         $cloudinary = new Cloudinary($config);
         $apiRequest=$cloudinary->adminApi()->asset("models/".$id."/predict/". $request->input('user_id')."/jsons/".
         $request->input('image').".json",  ['type' => 'private' ,'resource_type' => 'raw']);
         $apiRequest = $client->request('get',$apiRequest['url']);

         return response($apiRequest->getBody()->getContents(), 200)
          ->header('Content-Type', 'application/json')->header('Content-disposition','attachment; filename='. $request->input('image').".json");
    }

    public function store_dataset(Request $request,$id)
    {
      // configure globally via a JSON object
        $file = $request->file('image');
       $config = Configuration::instance([
        'cloud' => [
          'cloud_name' => 'hi5',
          'api_key' => '323435588613243',
          'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
        'url' => [
          'secure' => true]]);
          $f = true;
          $cloudinary = new Cloudinary($config);
          $query = str_replace(array('?'), array('\'%s\''), training_file::where('model_id',$id)->where('name',pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->toSql());
          $query = vsprintf($query, training_file::where('model_id',$id)->where('name',pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->getBindings());
  
       if(training_file::where("model_id",$id)->where('name',pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->count()!=0)
          {
            training_file::where("model_id",$id)->where('name',pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))->update(
              ["labels" => null]
            );
            $f=false;

        }
         
          $cloudinary->uploadApi()->upload((string)$file,
          ["public_id" => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) , "type" => "private"
           , "resource_type	" => "private" , "folder" => "models/".$id."/dataset/images"]);
           if($f)
           training_file::create(['model_id'=>$id,'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)]);
           $client = new Client();
           $multipart[] = array('name'=>'image','contents'=>fopen($file,'r'),'filename'=>$file->getClientOriginalName());
           //$client->request('Post','127.0.0.1:5000/object_map_generation/'.$id,['multipart' => $multipart]);
          $client->request('Post','https://hi55.herokuapp.com/object_map_generation/'.$id,['multipart' => $multipart]);
      
           return response()->json('success',200);
    }
   
    public function delete_from_dataset(Request $request,$id)
    {
     
          $config = Configuration::instance([
            
            'cloud' => [
              'cloud_name' => 'hi5',
              'api_key' => '323435588613243',
              'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
            'url' => [
              'secure' => true]]);
              $mod=[];
              $mod1=[];
              $cloudinary = new Cloudinary($config);
              foreach ($request->input('publicIds') as &$node)
               { $mod1[]="models/".$id."/dataset/images/".$node;
                $mod[]= "models/".$id."/dataset/jsons/".$node.".json";
                $mod[]= "models/".$id."/dataset/labeld_object_maps/".$node.".csv";
                $mod[]= "models/".$id."/dataset/object_maps/".$node.".csv";
                training_file::where("model_id",$id)->where("name",$node)->delete();
              
                 }
        
            $cloudinary->adminApi()->deleteAssets($mod,["type" => "private" ,"resource_type" => "raw"]);
            return   $cloudinary->adminApi()->deleteAssets($mod1,["type" => "private"]);
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
           return   $cloudinary->adminApi()->assets(["prefix"=>"models/".$id."/dataset/images", "max_results" => 500 ,'type' => 'private']);

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
          training_file::where('model_id',$id)->delete();
            $cloudinary->adminApi()->deleteAssetsByPrefix("models/".$id."/dataset", ['type' => 'private',"resource_type" => "raw"]);
          return   $cloudinary->adminApi()->deleteAssetsByPrefix("models/".$id."/dataset", ['type' => 'private']);


    }

    public function Re_train(Request $request,$id)
    {   

      $client= new Client();
      $labels=new LabelController();
      $labels=$labels->labelsForModel($id);
      $prog = model_tbls::find($id)->progress;
      if( $this->getCurrent($id) == -1 || ($prog != 0 && $prog != 1)  )
      return response()->json("You cannt do re train while previous version didn't finish and verified",401);
      $apiRequest = $client->request('POST', 'http://127.0.0.1:5000/re_train/'.$id,['form_params' => ['v_id' => $this->getCurrent($id),"labels"=>json_encode($labels)
      ,'user_id' => $request->input('user_id')]]);
      //$apiRequest = $client->request('POST', 'https://hi55.herokuapp.com/re_train/'.$id,['form_params' => ['v_id' => $this->getCurrent($id),"labels"=>json_encode($labels)
      //,'user_id' => $request->input('user_id')]]);
      return   $apiRequest->getBody();
  
    }
    public function store_predict(Request $request,$id)
    {

      if($this->getCurrent_for_predict($id) == null){
        return response()->json('You muts have trained version',406);
      }

      $respose=[];
      $config = Configuration::instance([
       'cloud' => [
       'cloud_name' => 'hi5',
       'api_key' => '323435588613243',
       'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
       'url' => [
       'secure' => true]]);
       $files =[];
       $cloudinary = new Cloudinary($config);
       foreach ($request->file('images') as $file){
         try{
           file::create(['name'=>pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) , 'model_id' => $id ,'user_id' => $request->input('user_id')]);
           $respose[$file->getClientOriginalName()]='Pending';
           $files[]=$file;
       }catch(Exception $exception)
       {
           if($exception->getCode()==23000)
           {
            
            $respose[$file->getClientOriginalName()]=$exception->getMessage();
            }
           else
           $respose[$file->getClientOriginalName()]="Faild";
       }
      }

       $guzzel = new Client();
       $labels=new LabelController();
       $labels=$labels->labelsForModel($id);
       foreach($files as $file)
       $multipart[]=array('name'=>'images', 'contents'=>fopen($file,'r'),'filename'=>pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
       $multipart[]=array('name'=>'user_id','contents'=>$request->input('user_id'));
       $multipart[]=array('name'=>'v_id','contents'=>$this->getCurrent_for_predict($id));
       $multipart[]=array('name'=>'labels','contents'=>json_encode($labels));
       $apiRequest = $guzzel->request('POST', 'https://hi55.herokuapp.com/predict/'.$id,['multipart' => $multipart]);
      //$apiRequest = $guzzel->request('POST', '127.0.0.1:5000/predict/'.$id,['multipart' => $multipart]);
       return  response()->json( $respose,200);
  
    }

    public function delete_from_predict(Request $request,$id)
    {

      $config = Configuration::instance([
        'cloud' => [
          'cloud_name' => 'hi5',
          'api_key' => '323435588613243',
          'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
        'url' => [
          'secure' => true]]);
          $mod=[];
          $mod1=[];
          $cloudinary = new Cloudinary($config);
          foreach ($request->input('publicIds') as &$node)
           {
            $mod1[]="models/".$id."/predict/".$request->input('user_id')."/images/".$node;
            $mod[]="models/".$id."/predict/".$request->input('user_id')."/jsons/".$node.".json";
            $mod[]="models/".$id."/predict/".$request->input('user_id')."/csvs/".$node.".csv";
            file::where('user_id',$request->input('user_id'))->where('model_id',$id)->where('name',$node)->delete();
             }
        $cloudinary->adminApi()->deleteAssets($mod1,["type" => "private"]);
        return   $cloudinary->adminApi()->deleteAssets($mod,["type" => "private" , "resource_type" => "raw"]);

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
          $resposes = [];
          foreach(file::where("user_id",$request->input('user_id'))->where('model_id',$id)->get()->toArray() as $keyP => $raw)
          {

          foreach($raw as $key => $val)
          $resposes[$keyP][$key]=$val;
          
          if($raw['state_id']==1){
         try{ $res=$cloudinary->adminApi()->asset('models/'.$id.'/predict/'.$request->input('user_id').'/images/'. $resposes[$keyP]['name'] ,
         ['type' => 'private']);
          foreach( $res as $key => $val)
          $resposes[$keyP][$key]=$val;
          }catch(Exception $e){}
        }
          
         }

         return $resposes;

    }
    public function name($pi){

      $s = "";
      $index=0;
      for($i = 0 ;$i<strlen($pi);$i++)
      {
        if($pi[$i]=='/')
        {
          $index=$i+1;
        }
      }

      for($i = $index ;$i<strlen($pi);$i++)
      {

          $s.=$pi[$i];


      }
      return $s;

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
         file::where('user_id',$request->input('user_id'))->where('model_id',$id)->delete();
         $cloudinary->adminApi()->deleteAssetsByPrefix("models/".$id."/predict/".$request->input('user_id'),
           ['type' => 'private' , 'resource_type'=>'raw']);
        return $cloudinary->adminApi()->deleteAssetsByPrefix("models/".$id."/predict/".$request->input('user_id'),
        ['type' => 'private']);

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
          $des=DB::table('model_tbls')->find($id)->description_image;
          $multipart[] = array('name'=>'de','contents'=>$des);
          $multipart[] = array('name'=>'nodes','contents'=>$request->input('nodes'));
          $apiRequest = $client->request('POST', "https://hi55.herokuapp.com/object_map_labeling/".$id, [ 'multipart' => $multipart]);
          //$apiRequest = $client->request('POST', "127.0.0.1:5000/object_map_labeling/".$id, [ 'multipart' => $multipart]);
          return  $apiRequest->getBody();

    }

    public function image(Request $request,$id)
    {
          $url = "https://res.cloudinary.com/hi5/image/upload/models/".$id."/image";
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
