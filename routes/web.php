<?php

Route::get('import/create', 'ImportController@create')->name('import.create');
Route::post('import', 'ImportController@store')->name('import.store');
