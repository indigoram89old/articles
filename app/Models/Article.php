<?php

namespace App\Models;

use App\Scopes\HasManyContents;
use App\Scopes\BelongsToManyMedia;
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
    	]);

    	return $query->where(function ($query) use ($validated) {
    		
    		if ($search = ($validated['search'] ?? null)) {
    			$query->where('search', 'like', "%{$search}%");
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
}
