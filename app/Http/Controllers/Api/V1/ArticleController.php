<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            $author = User::find($article->user_id);
            return [
                'id'      => (int) $article->id,
                'title'   => $article->title,
                'content' => Str::of($article->content)->limit('200'),
                'author'  => [
                    'name'  => $author->name,
                    'email' => $author->email,
                ],
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
            $author = User::find($article->user_id);
            return [
                'id'      => (int) $article->id,
                'title'   => $article->title,
                'content' => Str::of($article->content)->limit('200'),
                'author'  => [
                    'name'  => $author->name,
                    'email' => $author->email,
                ],
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
