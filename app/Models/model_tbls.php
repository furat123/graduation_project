<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class model_tbls extends Model
{
    
    use HasFactory;
    protected $table="model_tbls";
    public $timestamps=false;
    protected $fillable=[
        'name',
        'created_date',
        'last_use_date',
        'owner_id',
        'public_state',
        'number_of_using',
        'state_id',
        'progress',
        'progress_op',
        'description',
        'type',
        'short_description'
    ];
    protected $hidden=['pivot'];
   
    //////////relation/////////
    public function OwnerModel (){
        return $this ->belongsTo('App\Models\User', 'owner_id');
    }
    public function Users_Of_Model(){
        return $this ->belongsToMany("App\Models\User",'user_has_models','model_id','id');
    }
    public function State_Of_Model(){
       return $this ->belongsTo('App\Models\model_states', 'state_id');
    }
    public function label_for_model(){
        return $this ->hasMany('App\Models\label', 'model_id');
                 }
  
}
