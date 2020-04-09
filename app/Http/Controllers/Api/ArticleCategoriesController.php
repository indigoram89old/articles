<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCategoryResource;

class ArticleCategoriesController extends Controller
{
    public function index(Request $request)
    {
    	$categories = ArticleCategory::get();

    	return ArticleCategoryResource::collection($categories);
    }
}
