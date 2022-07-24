<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imageable extends Model
{
    public $timestamps = false;

    protected $fillable = ['photo_id','imageable_id','imageable_type'];
}
