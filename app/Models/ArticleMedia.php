<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleMedia extends Model
{
	protected $fillable = [
		'uuid', 'article_id',
		'published_at',
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
}
