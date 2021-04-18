<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verify_state extends Model
{
    use HasFactory;
    protected $table="verify_states";
    public $timestamps=false;
    protected $fillable=[
        'id',
        'verify_state',

    ];
}
