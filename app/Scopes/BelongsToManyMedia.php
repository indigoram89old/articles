<?php

namespace App\Scopes;

use App\Models\ArticleMedia;

trait BelongsToManyMedia
{
	public function media()
	{
		return $this->belongsToMany(ArticleMedia::class, 'article_media_pivot', 'article_id', 'media_id')
					->withPivot('type');
	}

	public function attachMedia(ArticleMedia $media, array $attributes)
	{
		$types = ArticleMedia::getTypes()->pluck('id')->implode(',');

		$validated = validate($attributes, [
			'type' => ['required', 'string', "in:{$types}"],
		]);

		if ($this->media()->where('id', $media->id)->doesntExist()) {
			$this->media()->attach($media, $validated);
		}

		return $this;
	}
}