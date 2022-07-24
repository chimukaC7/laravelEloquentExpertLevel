<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    use Translatable;

    protected $fillable = ['title', 'article_text'];
    public $translatedAttributes = ['title', 'article_text'];

//    public function scopeNewest($query){
//        return $query->where('created_at','>', now()->subDays(30));
//    }

    public function scopeNewest($query,$days = 30){
        return $query->where('created_at','>', now()->subDays($days));
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::addGlobalScope('user_filter',function (Builder $builder){
            $builder->where('user_id',1);
        });
    }
}
