<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\model_tbl;
use App\Models\model_tbls;
use App\Models\User;
use Illuminate\Http\Request;

class RelationsController extends Controller
{
    public function HasOneRelation(){
       // return response()->json(User::get(),200);
        //return "its okk";
    //  $user="App\Http\Models\User"::find(1);
     
        //$user = User::FindOrFail(1);
        // $user = User::with('Model_Name')->FindOrFail(1);//return table of user and model 
         $user = User::with(['Model_Name'=>function($q){
             $q -> select('name','owner_id');
        }])->FindOrFail(1);

        //return "ddddd";
        if(is_null($user)){
            return response()->json(["message"=>'record not find!!!'], 404);
           }
       // return  $user->Model_Name;//table of model
        //return $user ->Model_Name->name;// model of this user 
        return response()->json($user, 200);

      
         
    }
    public function HasOneRelationReverse(){
      // $model= model_tbls::FindOrFail(1);
       //$model = model_tbls::with('OwnerModel')->FindOrFail(1);///
       $model = model_tbls::with(['OwnerModel'=>function($q){
        $q -> select('name','id');
   }])->FindOrFail(1);

     //  $model ->makeVisible(['owner_id']);
      // return $model ->OwnerModel;//all information about owner of the model 
     return response()->json($model, 200);
      //return $model -> OwnerModel-> name; owner for this model

    }

}
