<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory , HasApiTokens;
    protected $table="users";
    public $timestamps=true;
    protected $fillable=[
        'name',
        'email',
        'password',
        'admin_status',
        'mobile',
        'created_at',
        'updated_at',
    ];
    protected $hidden =['pivot'];

    public function Model_Name(){
        return $this -> hasOne("App\Models\model_tbls", 'owner_id');//,'name');
        // return $this -> hasOne(model_tbl::class);

    }
    public function User_Models(){
        return $this ->belongsToMany("App\Models\model_tbls",'user_has_models','user_id','model_id');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

}
