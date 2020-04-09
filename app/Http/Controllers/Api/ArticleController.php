<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
    	$articles = Article::filter($request->all())->latest()->paginate();

    	Article::loadRelations($articles, $request->input('with'));

    	return ArticleResource::collection($articles);
    }

    public function show(Article $article)
    {
    	$article->load('categories', 'media', 'contents');

    	return ArticleResource::make($article);
    }
}
