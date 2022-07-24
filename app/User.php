<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullNameAttribute(){
        return $this->name .' '. $this->surname;
    }

    public function setNameAttribute($value){
        $this->attributes['name'] = ucfirst($value);
    }

    public function setSurnameAttribute($value){
        $this->attributes['surname'] = ucfirst($value);
    }

    public function getDaysActiveAttribute(){
        return $this->created_at->diffInDays($this->updated_at);
    }

    public function roles(){
        //to add time stamps to the pivot table, you have to specify withTimestamps
        //for extra columns to be queriable, you haev to specify withPivot
        return $this->belongsToMany(Role::class)->withTimestamps()->withPivot(['approved']);
    }

    //filter the pivot table relationship
    public function approvedRoles(){
        return $this->belongsToMany(Role::class)->wherePivot('approved',1);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

}
