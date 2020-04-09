<?php

namespace App\Scopes;

use App\Models\ArticleCategory;

trait BelongsToManyCategories
{
	public function categories()
	{
		return $this->belongsToMany(ArticleCategory::class, 'article_category', 'article_id', 'category_id')
					->withPivot('primary');
	}

	public function attachCategory(ArticleCategory $category, array $attributes)
	{
		$validated = validate($attributes, [
			'primary' => ['nullable', 'boolean'],
		]);

		$validated['primary'] = ($validated['primary'] ?? false);

		if ($this->categories()->where('id', $category->id)->doesntExist()) {
			$this->categories()->attach($category, $attributes);
		}

		return $this;
	}
}