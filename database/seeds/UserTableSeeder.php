<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\User::create('users')->insert([
//            'name' => 'Admin',
//            'email' => 'admin@admin.com',
//            'password' => bcrypt('password'),
//        ]);

        //factory(\App\User::class, 50)->create();

        factory(\App\User::class, 50)->create()->each(function ($user){
            $user->articles()->saveMany(factory(\App\Article::class, 3)->make());
        });
    }
}
