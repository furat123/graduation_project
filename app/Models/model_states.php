<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class model_states extends Model
{
    
    use HasFactory;
    protected $table="model_states";
    public $timestamps=false;
    protected $fillable=[
        'id',
        'state',

    ];
}
