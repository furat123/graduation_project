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
        'picture',
        'created_date',
        'last_use_date',
        'owner_id',
        'public_state',
        'number_of_feature',
        'number_of_using',
        'state_id',

    ];
    protected $hidden=['owner_id'];
   
    //////////relation/////////
    public function OwnerModel (){
        return $this ->belongsTo('App\Models\User', 'id');
    }
}
