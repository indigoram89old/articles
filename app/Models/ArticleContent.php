<?php

namespace App\Models;

use App\Scopes\BelongsToArticle;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ArticleContent extends Model
{
	use BelongsToArticle;

    protected $fillable = [
    	'article_id',
    	'type', 'body',
    ];

    const TYPE_TEXT = 'text';
    const TYPE_HTML = 'html';

    public static function booting()
    {
    	static::saved(function ($model) {
    		$model->article->updateSearch();
    	});
    }

    public static function createForArticle(Article $article, array $attributes)
    {
    	$types = static::getTypes()->pluck('id')->implode(',');

    	$validated = validate($attributes, [
    		'type' => ['nullable', 'string', "in:{$types}"],
    		'body' => ['required', 'string'],
    	]);

    	return $article->contents()->create([
			'type' => ($validated['type'] ?? static::TYPE_TEXT),
			'body' => $validated['body'],
		]);
    }

    public static function getTypes()
    {
    	return new Collection([
    		['id' => static::TYPE_TEXT],
    		['id' => static::TYPE_HTML],
    	]);
    }
}
