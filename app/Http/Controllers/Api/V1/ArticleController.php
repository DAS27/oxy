<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\Fractal\Manager;
use Modules\Blog\Entities\Article;
use League\Fractal;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $fractal = new Manager();

        $articles = Article::getArticles();

        $resource = new Fractal\Resource\Collection($articles, function ($article) {
            return [
                'id'      => (int) $article->id,
                'user_id' => (int) $article->user_id,
                'title'   => $article->title,
                'content' => Str::of($article->content)->limit('200'),
            ];
        });

        return $fractal->createData($resource)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return string
     */
    public function show($id)
    {
        $fractal = new Manager();

        $article = Article::findOrFail($id);

        $resource = new Fractal\Resource\Item($article, function (Article $article) {
            return [
                'id'      => (int) $article->id,
                'user_id' => (int) $article->user_id,
                'title'   => $article->title,
                'content' => Str::of($article->content)->limit('200'),
            ];
        });

        return $fractal->createData($resource)->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
