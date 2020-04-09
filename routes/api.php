<?php

Route::get('/articles', 'ArticleController@index')->name('api.artcles');
Route::get('/articles/{article:slug}', 'ArticleController@show')->name('api.artcles.show');
