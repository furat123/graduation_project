<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\model_tbl;
use App\Models\model_tbls;
use App\Models\User;
use App\Models\user_has_model;
use App\Models\file;
use App\Models\label;
use Illuminate\Http\Request;

class RelationsController extends Controller
{
    public function HasOneRelation($id){
      
        $user =User::FindOrFail($id);
        return  $user-> Model_Name -> name ; 
     
        // $user = User::with('Model_Name')->FindOrFail(1);//return table of user and model 
       //  $user = User::with(['Model_Name'=>function($q){
        //     $q -> select('name','owner_id');
      //  }])->FindOrFail($id);

        //return "ddddd";
        if(is_null($user)){
            return response()->json(["message"=>'record not find!!!'], 404);
           }
        //return $user ->Model_Name->name;// model of this user 
        return response()->json($user, 200);

      // muhannad 
      // asdfasdf
         
    }
    public function HasOneRelationReverse($id){
        $model= model_tbls::FindOrFail($id);
        return  $model-> OwnerModel -> name ; 
     

     //$model = model_tbls::with('OwnerModel')->FindOrFail(1);///
      // $model = model_tbls::with(['OwnerModel'=>function($q){
      //  $q -> select('name','id');
       //       }])->FindOrFail($id);

     //  $model ->makeVisible(['owner_id']);
      // return $model ->OwnerModel;//all information about owner of the model 
      if(is_null($model)){
        return response()->json(["message"=>'record not find!!!'], 404);
       }
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
      //nothing to commit 
       //$FilesOfMdel= user_has_model::FindOrFail(1);
      // return $FilesOfMdel->fun_file;
      $FilesOfMdel= user_has_model::with('fun_file')->FindOrFail(1);
      //return $FilesOfMdel ;
      $allFile=$FilesOfMdel->fun_file;
      foreach ($allFile as $var){
          echo $var->name ; 
          echo "\n";

    }}

    ///////////////// many to many relation 
    public function getModelsOFUser($id){
        $user= User::with('User_Models')->FindOrFail($id);
         return $user->User_Models;
    }
     //nothing to commit 
    public function getusersOFmodel($id){
     
        $model=model_tbls::with(['Users_Of_Model'=>function($q){
            $q->select('users.id','name');
        }])->FindOrFail($id);
         return $model->Users_Of_Model;

   }

   public function getLabelOfModel($id){
  //  $model= model_tbls::FindOrFail($id);
    $model= model_tbls::with('label_for_model')->FindOrFail($id);
    //return $FilesOfMdel ;
    $allFile=$model->label_for_model;
    foreach ($allFile as $var){
        echo $var->label ; 
        echo "\n";
   
}}}
