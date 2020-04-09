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

if (! function_exists('sms_code')) {
	function sms_code(string $message) :? string {
		$message = " {$message} ";
		$match = preg_match('/\b[\d]{4}[\s\n]/', $message, $matches);
		return isset($matches[0]) ? trim($matches[0]) : null;
	}
}