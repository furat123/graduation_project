<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class training_state extends Model
{
    use HasFactory;
    protected $table="training_states";
    public $timestamps=false;
    protected $fillable=[
        'id',
        'training_state', ];
}
