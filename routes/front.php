<?php
use Illuminate\Support\Facades\Route;
 

Route::get('/', 'PostController@index')->name('home');  //トップ(localhost:8888)にアクセスすると、「PostController」の「index」が表示される
Route::resource('posts', 'PostController')->only(['index', 'show']);  //postsで「PostController」にアクセスされるようにする、onlyで指定する