<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
	protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
    	'id', 'article_id',
        'name', 'primary',
    ];

    protected $casts = [
    	'primary' => 'boolean',
    ];
}
