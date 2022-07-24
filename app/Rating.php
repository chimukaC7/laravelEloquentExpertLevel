<?php

namespace App\Http;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['book_id','rating'];
}
