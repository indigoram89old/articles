<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
	protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
    	'id', 'article_id',
        'title', 'primary',
    ];

    protected $casts = [
    	'primary' => 'boolean',
    ];

    public static function search(string $id, string $title = null)
    {
    	$validated = validate(compact('id', 'title'), [
    		'id' => ['required', 'string', 'max:250'],
    		'title' => ['nullable', 'string', 'max:250'],
    	]);

    	return static::firstOrCreate([
    		'id' => $validated['id'],
    	], [
    		'title' => ($validated['title'] ?? ucfirst($validated['id'])),
    	]);
    }
}
