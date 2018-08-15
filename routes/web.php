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

Route::Group(['prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['auth.admin']], function () {
    /*用户登陆*/
    Route::match(['get', 'post'], 'login', ['as' => 'admin.account.login', 'uses' => 'AccountController@login']);
    /*用户退出登录*/
    Route::get('logout', ['as' => 'admin.account.logout', 'uses' => 'AccountController@logout']);


    /*首页*/
    Route::match('get', 'index', ['as' => 'admin.index.index', 'uses' => 'IndexController@index']);

    /*内容*/

    /*文章管理*/
    Route::Group(['prefix' => 'article'], function () {
        Route::get('', ['as' => 'admin.article.index', 'uses' => 'ArticleController@index']);
        /*文章创建页面*/
        Route::get('/create', ['as' => 'admin.article.create', 'uses' => 'ArticleController@create']);
        /*文章提交页面*/
        Route::post('/store', ['as' => 'admin.article.store', 'uses' => 'ArticleController@store']);
        /*文章审核*/
        Route::post('/verify', ['as' => 'admin.article.verify', 'uses' => 'ArticleController@verify']);
        /*文章删除*/
        Route::post('/destroy', ['as' => 'admin.article.destroy', 'uses' => 'ArticleController@destroy']);

        /*修改分类核*/
        Route::post('/changeCategories', ['as' => 'admin.article.changeCategories', 'uses' => 'ArticleController@changeCategories']);

    });

    Route::get('tag', ['as' => 'admin.tag.index', 'uses' => 'IndexController@index']);
    /*分类管理*/
    Route::Group(['prefix' => 'category'], function () {
        Route::get('', ['as' => 'admin.category.index', 'uses' => 'CategoryController@index']);
        Route::get('create', ['as' => 'admin.category.create', 'uses' => 'CategoryController@create']);
        Route::post('store', ['as' => 'admin.category.store', 'uses' => 'CategoryController@store']);
        Route::delete('destroy', ['as' => 'admin.category.destroy', 'uses' => 'CategoryController@destroy']);
        Route::get('edit', ['as' => 'admin.category.edit', 'uses' => 'CategoryController@edit']);
        Route::put('update', ['as' => 'admin.category.update', 'uses' => 'CategoryController@update']);
    });

});


Route::get('image/avatar/{avatar_name}', ['as' => 'website.image.avatar', 'uses' => 'ImageController@avatar'])->where(['avatar_name' => '[0-9]+_(small|middle|big|origin).jpg']);
Route::get('image/show/{image_name}', ['as' => 'website.image.show', 'uses' => 'ImageController@show']);

Route::Group(['middleware' => 'auth.admin'], function () {
    Route::post('image/upload', ['as' => 'website.image.upload', 'uses' => 'ImageController@upload']);
});