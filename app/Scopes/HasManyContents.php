<?php

namespace App\Scopes;

use App\Models\ArticleContent;

trait HasManyContents
{
	public function contents()
	{
		return $this->hasMany(ArticleContent::class);
	}
}