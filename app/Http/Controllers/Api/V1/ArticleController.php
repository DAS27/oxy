<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
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
            $author = User::findOrFail($article->user_id);
            return [
                'id'      => (int) $article->id,
                'title'   => (string) $article->title,
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
     *
     * @return string
     */
    public function store(ArticleRequest $request)
    {
        $fractal = new Manager();

        $validatedData = Article::create($request->validated());

        $resource = new Fractal\Resource\Item($validatedData, function (Article $data) {
            $author = User::findOrFail($data->user_id);
            return [
                'title'   => (string) $data->title,
                'content' => $data->content,
                'author'  => [
                    'name'  => $author->name,
                    'email' => $author->email,
                ],
            ];
        });

        $result = $fractal->createData($resource);

        return response()->json($result, 201);
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
            $author = User::findOrFail($article->user_id);
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
