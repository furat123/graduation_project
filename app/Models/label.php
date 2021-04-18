<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class label extends Model
{
    use HasFactory;
    protected $table="labels";
    public $timestamps=false;
    protected $fillable=[
        'model_id',
        'label',
        'index',

    ];
}
