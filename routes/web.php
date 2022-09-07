<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
//Rutas de usuario
Route::get('/config','UserController@config')->name('config');
Route::post('/user/edit','UserController@update')->name('user-update');
Route::get('/user/avatar/{filename}','UserController@getImage')->name('user-avatar');
Route::get('/profile/{id}','UserController@profile')->name('user-profile');

//Rutas de imagenes
Route::get('/image/create','ImageController@create')->name('image-create');
Route::post('/image/upload','imageController@upload')->name('image-upload');
Route::get('/image/{filename}','ImageController@getImage')->name('image-get');
Route::get('/image/detail/{id}','ImageController@detail')->name('image-detail');
Route::get('/image/edit/{id}','ImageController@edit')->name('image-edit');
Route::post('/image/update','ImageController@update')->name('image-update');
Route::get('/image/delete/{id}','ImageController@delete')->name('image-delete');

//Rutas de comentarios
Route::post('/comment-create','CommentController@save')->name('comment-create');
Route::get('/delete/{id}','CommentController@delete')->name('comment-delete');

//Rutas de likes
Route::get('/like/{id}','LikeController@like')->name('image-like');
Route::get('/dislike/{id}','LikeController@dislike')->name('image-dislike');
Route::get('/likes','LikeController@likes')->name('user-likes');