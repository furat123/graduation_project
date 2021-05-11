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
use Illuminate\Support\Facades\DB;



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

      
         
    }
    public function HasOneRelationReverse($id){
    
        $model= model_tbls::FindOrFail($id);
        return $model-> OwnerModel -> name; 
      
    
     
      if(is_null($model)){
        return response()->json(["message"=>'record not find!!!'], 404);
       }
     //   return response()->json($model, 200);
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
  
    public function getVerifyOfFile($id){
    //  return 0;
      $file= file::FindOrFail($id);
      return  $file ->  Verify_Of_File -> verify_state;

    }

    ///////////////// one to many relation 
    public function  getFilesOfMdel($id){
      //nothing to commit 
       //$FilesOfMdel= user_has_model::FindOrFail(1);
      // return $FilesOfMdel->fun_file;
      $FilesOfMdel= user_has_model::with('fun_file')->FindOrFail($id);
      //return $FilesOfMdel ;
      $allFile=$FilesOfMdel->fun_file;
      foreach ($allFile as $var){
          echo $var->name ; 
          echo "\n";

    }}

    ///////////////// many to many relation 
    public function getModelsOFUser($id){
        $user= User::with('User_Models')->FindOrFail($id);
       //  return $user->User_Models;
         $name_of_model=$user->User_Models;
         foreach ($name_of_model as $var){
             echo $var->name ; 
             echo "\n";
   
       }
    }
     //nothing to commit 
    public function getusersOFmodel($id){

      
        $model=model_tbls::with('Users_Of_Model')->FindOrFail($id);
        return $model->Users_Of_Model;
           //  $name_of_user = $model -> Users_Of_Model;
            // foreach ($name_of_user as $var){
            // echo $var->id ; 
            // echo "\n";
            // }
    

   }

   public function getLabelOfModel($id){
  //  $model= model_tbls::FindOrFail($id);
    $model= model_tbls::with('label_for_model')->FindOrFail($id);
    //return $FilesOfMdel ;
    $allFile=$model->label_for_model;
    return $allFile;
   
}
   public function ShowModelOfowner($id){
       
          $data = DB::table('model_tbls')
        //  ->join('model_tbls','model_tbls.id','=','user_has_models.model_id')
        //  ->select('model_tbls.id','model_tbls.name',)
         // ->where('user_has_models.user_id',$id)
          ->where('model_tbls.owner_id',$id)
          ->get();
           return $data;
        }

        public function ShowModelUsed($id){
              
                 $data = DB::table('user_has_models')
                 ->join('model_tbls','model_tbls.id','=','user_has_models.model_id')
                 ->where('user_has_models.user_id',$id)
                 ->whereColumn('owner_id','!=','user_id')
                 ->get();
                 return $data;
                 }

                public function getallmodel($id){
                $data = DB::table('user_has_models')
                ->join('model_tbls','model_tbls.id','=','user_has_models.model_id')
                //->select('model_id')
                ->where('user_id',$id)
                ->where('accept',1)
              
               // -> select('name','created_date',)
                ->get();
                return $data;
             //  foreach($data as $val){
             //    echo $val->name;
             //    echo "\n";
             //  }
               }
               public function getOwnerID($id){
                $data = DB::table('user_has_models')
                ->join('model_tbls','model_tbls.id','=','user_has_models.model_id')
               // ->select('model_tbls.owner_id')
                ->where('user_has_models.id',$id)
                ->get();
               //  return $data;
               foreach($data as $val){
                echo $val->owner_id;
                echo "\n";
              }

               }
               
                

                
              
            


}
