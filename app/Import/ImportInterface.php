<?php

namespace App\Import;

use Illuminate\Support\Arr;

interface ImportInterface
{
	public function start(array $attributes);
}