<?php

namespace App\Import\Facades;

use Illuminate\Support\Facades\Facade;

class Import extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'import';
	}
}