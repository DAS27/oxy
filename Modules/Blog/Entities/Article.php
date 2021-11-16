<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\ArticleFactory::new();
    }

    public static function getArticles()
    {
        return DB::table('articles')->orderBy('created_at')->paginate(25);
    }
}
