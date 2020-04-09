<?php

use Illuminate\Support\Facades\DB;

if (! function_exists('validate')) {
	function validate(array $attributes, array $rules) {
		return validator($attributes, $rules)->validate();
	}
}

if (! function_exists('transaction')) {
	function transaction(Closure $callback, int $attempts = 1) {
		if (DB::transactionLevel() > 0) return $callback();
		DB::transaction($callback, $attempts);
	}
}