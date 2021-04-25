<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    use HasFactory;
    protected $table="files";
    public $timestamps=true;
    protected $fillable=[
        'user_model_id',
        'name',
        'path',
        'output_path',
        'uploaded_date',
        'verify_state',
        'remember_token',
         'state_id',
        'accuracy',
    ];
   //////////relation/////////
     //relation between  files and user has models 
     public function fun_UserHasModel (){
        return $this ->belongsTo('App\Models\user_has_models', 'user_model_id');
    }

    public function State_Of_File (){
        
        return  $this ->belongsTo('App\Models\file_state', 'state_id');
       
     }
     public function Verify_Of_File (){
        
        return  $this ->belongsTo('App\Models\verify_state', 'verify_state');
       
     }

}
