<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        //sort by, sorts by collection
        //it doesn't sort the records from the query but from the collection

//         $users = User::all()->sortBy('days_active');
         $users = User::all()->sortByDesc('days_active');

         $users = User::select(DB::raw('id, name, email, created_at, DATEDIFF(updated_at, created_at) AS days_active'))
             ->get();

         $users = User::selectRaw('id, name, email, created_at, DATEDIFF(updated_at, created_at) AS days_active')
             ->whereRaw('DATEDIFF(updated_at, created_at) > 300')
             ->get();

         $users = User::select(DB::raw('id, name, email, created_at, DATEDIFF(updated_at, created) AS days_active'))
             ->orderByRaw('DATEDIFF(updated_at, created_at) DESC')
             ->get();

         //each works just like foreach
         $users = User::all()->each(function ($user){
            if ($user->password == ''){
                info('User '. $user->email. ' has not changed password');
            }
         });

         //maps forms a new collection with what you specify
        //goes through al the records and forms a new collection with some transformation that you specify
         $users = User::all()->map(function ($user){
             return strlen($user->name);
         });

         //return all records with name with lenght greater than 17
        $users = User::all()->filter(function ($user){
             return strlen($user->name) > 17;
         });


        $users = User::all()->reject(function ($user){
            return strlen($user->name) > 17;
        });

         return view('user.index', compact('users'));
    }

    public function create(){

    }

    public function store($request, User $user){
        //use an array to save extra information in a pivot table
        $user->roles()->attach(1,['approved' => 1]);
    }
}
