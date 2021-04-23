<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class training_file extends Model
{
    use HasFactory;
    protected $table="training_files";
    public $timestamps=false;
    protected $fillable=[
        'model_id',
        'name',
        'path',
        'output_path',
        'uploaded_date',
        'state',
        'type',

    ];
}
