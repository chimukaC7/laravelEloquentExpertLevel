<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Author extends Model
{
    protected $fillable = ['name'];

    public function books(){
        return $this->hasMany(Book::class);
    }

    public function getBooksCountAttribute(){
        return Cache::remember('author-books-'.$this->id,15,function (){
            return $this->books->count();
        });
    }
}
