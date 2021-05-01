<?php

namespace App\Jobs;

use App\Http\Controllers\LabelController;
use App\Models\file;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id , Request $request ) {
        $this->id = $id;
        $this->request = $request;
    }
  
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $respose=[];
        $config = Configuration::instance([
         'cloud' => [
         'cloud_name' => 'hi5',
         'api_key' => '323435588613243',
         'api_secret' => 'cWSgE3yKhL0alVclbqPLsT6PY1g'],
         'url' => [
         'secure' => true]]);
         $files 
         $cloudinary = new Cloudinary($config);
         foreach ($this->request->file('images') as $file){
           try{
             file::create(['name'=>pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) , 'model_id' => $this->id ,'user_id' => $this->request->input('user_id')]);
 
         }catch(Exception $exception)
         {
             if($exception->getCode()==23000)
             {
               $respose[$file->getClientOriginalName()]="Name of image duplicated";
              }
             else
             $respose[$file->getClientOriginalName()]="Faild";
             continue;
           
         }
        }
         $guzzel = new Client();
         $labels=new LabelController();
         $labels=$labels->labelsForModel($this->id);
         $cloudinary->uploadApi()->upload((string)$file,["public_id" => pathinfo($file->getClientOriginalName(),
         PATHINFO_FILENAME) , "type" => "private", "resource_type	" => "raw" , "folder" => "models/".$this->id."/predict/".$this->request->input('user_id')."/images"]);
         $respose[$file->getClientOriginalName()]="success";
         $multipart[]=array('name'=>'image', 'contents'=>fopen($file,'r'),'filename'=>pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
         $multipart[]=array('name'=>'user_id','contents'=>$this->request->input('user_id'));
         $multipart[]=array('name'=>'labels','contents'=>json_encode($labels));
         $apiRequest = $guzzel->request('POST', 'https://hi55.herokuapp.com/predict/'.$this->id,['multipart' => $multipart]);
    }

}
