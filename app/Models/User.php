<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table="users";
    public $timestamps=true;
    protected $fillable=[
        'name',
        'email',
        'email_verified_at',
        'password',
        'admin_status',
        'mobile',
        'remember_token',
        'created_at',
        'updated_at',
    ];
    public function Model_Name(){
        return $this -> hasOne("App\Models\model_tbls", 'owner_id');//,'name');
        // return $this -> hasOne(model_tbl::class);

    }
   

}
