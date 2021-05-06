<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hestory_of_model extends Model
{
    use HasFactory;
    protected $fillable=[
        'model_id',
        'user_id',
        'acc',
    ];
}
