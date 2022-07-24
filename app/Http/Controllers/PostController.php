<?php

namespace App\Http\Controllers;

use App\Imageable;
use App\Photo;
use App\Post;
use App\Role;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::with('photos')->get();

        //what if we want to show roles with their posts
        //what have the administrators written and what have the editors written
        $roles = Role::with('users.post')->get();

        return view('posts.index', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $post = Post::create($request->only(['title']));

        $photos = explode(",", $request->get('photos'));

        foreach ($photos as $photo){
            Photo::create([
                'imageable_id' => $post->id,
                'imageable_type' => 'App\Post',
                'filename' => $photo
            ]);
        }

        //many to many
        foreach ($photos as $filename){
            $photo = Photo::create([
                'filename' => $filename
            ]);

            Imageable::create([
                'photo_id' => $photo->id,
                'imageable_id' => $post->id,
                'imageable_type' => 'App\Post',
            ]);
        }

        return redirect()->route('photos.index');
    }

    public function show(Post $post)
    {
    }

    public function edit(Post $post)
    {
    }

    public function update(Request $request, Post $post)
    {
    }

    public function destroy(Post $post)
    {
    }
}
