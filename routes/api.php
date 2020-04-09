<?php

Route::get('/articles', 'ArticleController@index')->name('api.artcles');
Route::get('/articles/{article:slug}', 'ArticleController@show')->name('api.artcles.show');

Route::get('/article-categories', 'ArticleCategoriesController@index')->name('api.article-categories');
