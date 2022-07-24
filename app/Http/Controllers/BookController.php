<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('author')->get();

        //querying records with relationships
        //----------------------------------------------------------------------------------------------
        $books = Book::join('authors','books.author_id','=','auhors.id')
            ->where('authors.name','Chris Beatty')
            ->where('title','like','%a')
            ->pluck('title')
            ->dd();
        //----------------------------------------------------------------------------------------------
         $author = Author::where('authors.name','Chris Beatty')->first();
         $books = $author->books()
             ->where('title','like','%a')
             ->pluck('title')
             ->dd();
        //----------------------------------------------------------------------------------------------
        Author::has('books')->get()->dd();
        Author::has('books','>=',5)->get()->dd();//authors with more than 5  books
        Author::doesntHave('books')->get()->dd();
        //----------------------------------------------------------------------------------------------
         Author::has('books.ratings')->get()->dd();
        //----------------------------------------------------------------------------------------------
        Author::whereHas('books',function ($query){
           $query->where('title','like','%a%');
        })->get()->dd();
        //----------------------------------------------------------------------------------------------

        //Eager Loading
        //----------------------------------------------------------------------------------------------
        $books = Book::with('author')
            ->where('title','like','%a%')
            ->take(100)
            ->get();
        //----------------------------------------------------------------------------------------------
        $books = Book::
            where('title','like','%a%')
            ->take(100)
            ->get();

        $books->load('author');
        //----------------------------------------------------------------------------------------------




        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $author = Author::firstOrCreate(['name' => $request->author]);
        Book::create([
            'author_id' => $author->id,
            'title' => $request->title
        ]);
        //----------------------------------------------------------------------------------------------
        $book = Book::create($request->all());
        //----------------------------------------------------------------------------------------------
        $author = Author::firstOrCreate(['name' => $request->author]);
        //creating records with relationships
        $author->books()->create([
           'title'=>$request->title,
        ]);
        //----------------------------------------------------------------------------------------------
        $titles = explode(',', $request->title);
        foreach ($titles as $title){
            Book::create([
                'author_id' => $author->id,
                'title'=> $title,
            ]);
        }
        //----------------------------------------------------------------------------------------------
        $titles = collect(explode(',', $request->title))->map(function ($item){
           return ['title' => $item];
        })->toArray();

        $author->books()->createMany($titles);
        //----------------------------------------------------------------------------------------------

        if ($request->hasFile('cover_image')) {
            $book->addMediaFromRequest('cover_image')->toMediaCollection('cover_images');
        }

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
}
