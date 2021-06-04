<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history_of_train extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=[
        'model_id',
        'user_id',
        'acc',
        'verify',
    ];
}
