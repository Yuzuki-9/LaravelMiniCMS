<?php
use Illuminate\Support\Facades\Route;
 
Route::get('/', 'DashboardController')->name('dashboard');

Route::resource('posts', 'PostController')->except('show');  //exceptで指定するのは、使用しないblade