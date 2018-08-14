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
*/

Route::get('/', function () {
    return view('welcome');
});

Route::Group(['prefix' => 'admin', 'namespace' => 'admin',], function () {
    /*用户登陆*/
    Route::match(['get', 'post'], 'login', ['as' => 'admin.account.login', 'uses' => 'AccountController@login']);

    /*首页*/
    Route::match('get', 'index', ['as' => 'admin.index.index', 'uses' => 'IndexController@index']);

    /*内容*/
    Route::get('article', ['as' => 'admin.article.index', 'uses' => 'IndexController@index']);
    Route::get('tag', ['as' => 'admin.tag.index', 'uses' => 'IndexController@index']);
    Route::get('category', ['as' => 'admin.category.index', 'uses' => 'IndexController@index']);
});


Route::get('image/avatar/{avatar_name}', ['as' => 'website.image.avatar', 'uses' => 'ImageController@avatar'])->where(['avatar_name' => '[0-9]+_(small|middle|big|origin).jpg']);
Route::get('image/show/{image_name}', ['as' => 'website.image.show', 'uses' => 'ImageController@show']);