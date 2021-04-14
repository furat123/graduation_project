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
        'state',
        'accuracy',
    ];
}
