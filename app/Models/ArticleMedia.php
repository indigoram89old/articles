<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ArticleMedia extends Model
{
	protected $fillable = [
		'uuid', 'article_id',
		'created_at', 'updated_at', 'published_at',
        'type', 'file',
        'slug', 'link',
        'source', 'copyright', 'caption', 'credit',
        'width', 'height',
	];

	protected $dates = [
		'published_at',
	];

    const TYPE_FEATURED = 'featured';
    
    const FILE_IMAGE = 'image';

    public static function search(array $attributes)
    {
    	$files = static::getFiles()->pluck('id')->implode(',');

    	$validated = validate($attributes, [
    		'uuid' => ['nullable', 'string', 'uuid'],
			'created_at' => ['nullable', 'string', 'date'],
			'updated_at' => ['nullable', 'string', 'date'],
			'published_at' => ['nullable', 'string', 'date'],
	        
	        'file' => ['required', 'string', "in:{$files}"],
	        'slug' => ['required', 'string', 'max:250'],
	        'link' => ['required', 'string', 'url'],
	        
	        'source' => ['nullable', 'string', 'max:250'],
	        'copyright' => ['nullable', 'string', 'max:250'],
	        'caption' => ['nullable', 'string', 'max:250'],
	        'credit' => ['nullable', 'string', 'max:250'],
	        'width' => ['nullable', 'integer', 'min:0', 'max:9999'],
	        'height' => ['nullable', 'integer', 'min:0', 'max:9999'],
    	]);

    	return static::firstOrCreate([
			'uuid' => ($validated['uuid'] ?? Str::uuid()),
		], [
			'created_at' => ($validated['created_at'] ?? now()),
			'updated_at' => ($validated['updated_at'] ?? now()),
			'published_at' => ($validated['published_at'] ?? now()),
	        
	        'file' => $validated['file'],
	        'slug' => $validated['slug'],
	        'link' => $validated['link'],
	        
	        'source' => ($validated['source'] ?? null),
	        'copyright' => ($validated['copyright'] ?? null),
	        'caption' => ($validated['caption'] ?? null),
	        'credit' => ($validated['credit'] ?? null),
	        'width' => ($validated['width'] ?? null),
	        'height' => ($validated['height'] ?? null),
		]);
    }

    public static function getTypes()
    {
    	return new Collection([
    		['id' => static::TYPE_FEATURED],
    	]);
    }

    public static function getFiles()
    {
    	return new Collection([
    		['id' => static::FILE_IMAGE],
    	]);
    }
}
