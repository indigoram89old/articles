<?php

namespace App\Scopes;

use App\Models\Article;

trait BelongsToArticle
{
	public function article()
	{
		return $this->belongsTo(Article::class);
	}
}