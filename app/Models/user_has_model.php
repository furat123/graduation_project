<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_has_model extends Model
{
    use HasFactory;
    protected $table="user_has_models";
    public $timestamps=false;
    protected $fillable=[
        'user_id',
        'model_id',
        'accept',
        'end_date',
        

    ];
     //////////relation/////////
     //relation between user has models and files
     public function fun_file (){
        return $this ->hasMany('App\Models\file', 'user_model_id');
    }
   
    
}
