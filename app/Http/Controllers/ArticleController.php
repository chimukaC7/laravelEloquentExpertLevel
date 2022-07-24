<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();

        echo 'Total articles: ' . $articles->count() . '<hr/>';
        echo 'Total word written: ' . $articles->sum('word_count') . '<hr/>';//for all the articles

        echo 'Minimum word written: ' .number_format($articles->min('word_count'),2) . '<hr/>';
        echo 'Maximum word written: ' .number_format($articles->max('word_count'),2) . '<hr/>';
        echo 'Average word written: ' .number_format($articles->avg('word_count'),2) . '<hr/>';
        echo 'Median word written: ' .number_format($articles->median('word_count'),2) . '<hr/>';

        echo 'Most often word count: ' . implode($articles->mode('word_count') ). '<hr/>';

        $titles = [];
        foreach ($articles as $article){
            if ($article->category_id == 1){
                $titles[] =  $article->title;
            }
        }

        $articles->filter(function ($article){
           return $article->category_id == 1;
        })->map(function ($article){
            return $article->title;
        });

        //--------------------------------------------------------------------------------------------------------------
        $articles = Article::where('user_id',1)
            ->where(function ($query){//brackets in eloquent
                return $query
                    ->whereYear('created_at',2018)
                    ->orWhereYear('created_at',2022);
            })
            ->get();
        //--------------------------------------------------------------------------------------------------------------
        $articles = Article::newest(90)->get();
        //--------------------------------------------------------------------------------------------------------------

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select(['name','id'])->get()
            ->prepend(new User(['name' => '-- please choose author --']));

        $users = User::select(['name','id'])->get()->shuffle()->chunk(3);//people into teams of 3

        return view('articles.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticlesRequest $request)
    {
        if(! Gate::allows('article_create')){
            return abort(401);
        }
        Article::create(
            [
                'en' => [
                    'title' => $request->en_title,
                    'article_text' => $request->en_article_text
                ],
                'es' => [
                    'title' => $request->es_title,
                    'article_text' => $request->es_article_text
                ]
            ]
        );
        return redirect()->route('admin.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
