<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class file_state extends Model
{
    use HasFactory;
    protected $table="file_states";
    public $timestamps=false;
    protected $fillable=[
        'id',
        'state',

    ];
}
