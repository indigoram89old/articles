<?php

namespace App\Models;

use App\Scopes\HasManyContents;
use App\Scopes\BelongsToManyMedia;
use Illuminate\Support\Collection;
use App\Scopes\BelongsToManyCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
	use HasManyContents, BelongsToManyCategories, BelongsToManyMedia;

    protected $fillable = [
    	'uuid', 'title', 'slug',
    	'content_type', 'content',
    	'search',
    ];

    const RELATIONS = [
    	'categories', 'media',
    ];

    public static function booting()
    {
    	static::saving(function ($model) {
    		$model->fillSearch();
    	});
    }

    public static function slugExists(string $slug)
    {
    	return static::where(compact('slug'))->exists();
    }

    public function scopeFilter(Builder $query, array $filter)
    {
    	$validated = validate($filter, [
    		'search' => ['nullable', 'string', 'max:15'],
    		'category_id' => ['nullable', 'string'],
    	]);

    	return $query->where(function ($query) use ($validated) {
    		
    		if ($search = ($validated['search'] ?? null)) {
    			$query->where('search', 'like', "%{$search}%");
    		}
    		
    		if ($category_id = ($validated['category_id'] ?? null)) {
    			$query->whereHas('categories', function ($query) use ($category_id) {
    				$query->where('id', $category_id);
    			});
    		}
    	});
    }

    public function fillSearch()
    {
    	$search = $this->title;

    	foreach ($this->contents as $content) {
    		$search .= strip_tags($content);
    	}

    	return $this->fill(compact('search'));
    }

    public function updateSearch()
    {
    	$this->fillSearch()->save();
    }

    public static function loadRelations($articles, string $relations = null)
    {
    	$relations = explode(',', $relations);

    	$relations = array_filter($relations, function ($relation) {
    		return in_array($relation, static::RELATIONS);
    	});

    	return $articles->load($relations);
    }
}
