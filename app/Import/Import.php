<?php

namespace App\Import;

use App\Models\Article;
use App\Import\Rules\File;
use Illuminate\Support\Arr;
use App\Models\ArticleMedia;
use App\Import\Rules\Password;
use App\Models\ArticleContent;
use App\Models\ArticleCategory;
use Illuminate\Support\Collection;
use App\Import\Exceptions\ImportException;

class Import implements ImportInterface
{
	protected $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function config(string $key)
	{
		return Arr::get($this->config, $key);
	}

	public function start(array $attributes)
	{
		$validated = validate($attributes, [
			'file' => ['required', 'string', 'url', new File],
			'password' => ['required', 'string', new Password],
		]);

		$content = file_get_contents($validated['file']);

		$json = json_decode($content, true);

		if (is_null($json)) {
			throw new ImportException(__('Import supports only JSON files.'));
		}

		foreach ($json as $attributes) {
			if (Article::slugExists($attributes['slug'])) continue;

			transaction(function () use ($attributes) {

				$article = $this->importArticle($attributes);

				$contents = $this->importContent($article, $attributes);
				
				$categories = $this->importCategories($article, $attributes);
				
				$medias = $this->importMedia($article, $attributes);
			});
		}
	}

	protected function importArticle(array $attributes)
	{
		return Article::create([
			'uuid' => $attributes['id'],
			'title' => $attributes['title'],
			'slug' => $attributes['slug'],
		]);
	}

	protected function importContent(Article $article, array $attributes)
	{
		$contents = new Collection;

		foreach ($attributes['content'] as $_content) {
			$content = ArticleContent::createForArticle($article, [
				'type' => ($_content['type'] ?? null),
				'body' => $_content['content'],
			]);

			$contents->push($content);
		}

		return $contents;
	}

	protected function importCategories(Article $article, array $attributes)
	{
		$categories = new Collection;

		if (isset($attributes['categories']['primary'])) {
			$category = $this->importCategory($article, $attributes['categories']['primary'], true);
			$categories->push($category);
		}

		foreach ($attributes['categories']['additional'] as $_category) {
			$category = $this->importCategory($article, $_category);
			$categories->push($category);
		}

		return $categories->unique('id');
	}

	protected function importCategory(Article $article, string $id, bool $primary = false)
	{
		$category = ArticleCategory::search($id);
		
		$article->attachCategory($category, compact('primary'));

		return $category;
	}

	protected function importMedia(Article $article, array $attributes)
	{
		$medias = new Collection;

		foreach ($attributes['media'] as $_media) {
			$media = ArticleMedia::search([
				'uuid' => $_media['media']['id'],
				'created_at' => $_media['media']['properties']['modified'],
				'updated_at' => $_media['media']['properties']['modified'],
				'published_at' => $_media['media']['properties']['published'],
		        'file' => $_media['media']['type'],
		        'slug' => $_media['media']['slug'],
		        'link' => $_media['media']['@link'],
		        'source' => $_media['media']['source'],
		        'copyright' => $_media['media']['attributes']['copyright'],
		        'caption' => $_media['media']['attributes']['caption'],
		        'credit' => $_media['media']['attributes']['credit'],
		        'width' => $_media['media']['attributes']['width'],
		        'height' => $_media['media']['attributes']['height'],
			]);

			$type = $_media['type'];
		
			$article->attachMedia($media, compact('type'));
		}

		return $medias;
	}
}