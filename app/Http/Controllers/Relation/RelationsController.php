<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\model_tbl;
use App\Models\model_tbls;
use App\Models\User;
use App\Models\user_has_model;
use App\Models\file;
use Illuminate\Http\Request;

class RelationsController extends Controller
{
    public function HasOneRelation($id){
       // return response()->json(User::get(),200);
        //return "its okk";
    //  $user="App\Http\Models\User"::find(1);

        //$user = User::FindOrFail(1);
        // $user = User::with('Model_Name')->FindOrFail(1);//return table of user and model
         $user = User::with(['Model_Name'=>function($q){
             $q -> select('name','owner_id');
        }])->FindOrFail($id);

        //return "ddddd";
        if(is_null($user)){
            return response()->json(["message"=>'record not find!!!'], 404);
           }
       // return  $user->Model_Name;//table of model
        //return $user ->Model_Name->name;// model of this user
        return response()->json($user, 200);



    }
    public function HasOneRelationReverse($id){
      // $model= model_tbls::FindOrFail(1);
       //$model = model_tbls::with('OwnerModel')->FindOrFail(1);///
       $model = model_tbls::with(['OwnerModel'=>function($q){
        $q -> select('name','id');
              }])->FindOrFail($id);

     //  $model ->makeVisible(['owner_id']);
      // return $model ->OwnerModel;//all information about owner of the model
        return response()->json($model, 200);
      //return $model -> OwnerModel-> name; owner for this model

    }

    public function getStateOfModel($id){

            $model =model_tbls::FindOrFail($id);
            return  $model-> State_Of_Model -> state ;
        }



    public function getStateOfFile($id){
         $file= file::FindOrFail($id);
         return  $file ->  State_Of_File -> state_name ;// -> state ; //State_Of_File

         //  $file= file::with('State_Of_File')->FindOrFail($id);

       // $file= file::with(['State_Of_File'=>function($q){
        //    $q -> select('state_name','id');
          //        }])->FindOrFail(1);

    }

    ///////////////// one to many relation
    public function  getFilesOfMdel(){
       //$FilesOfMdel= user_has_model::FindOrFail(1);
      // return $FilesOfMdel->fun_file;
      $FilesOfMdel= user_has_model::with('fun_file')->FindOrFail(1);
      //return $FilesOfMdel ;
      $allFile=$FilesOfMdel->fun_file;
      foreach ($allFile as $var){
          echo $var->name ;
          echo "\n";

    }}

    ///////////////// one to many relation
    public function getModelsOFUser($id){
        $user= User::with('User_Models')->FindOrFail($id);
         return $user->User_Models;
    }
    public function getuserslOFmodel($id){
        $model=model_tbls::with(['Users_Of_Model'=>function($q){
            $q->select('users.id','name');
        }])->FindOrFail($id);
         return $model->Users_Of_Model;

   }
}
