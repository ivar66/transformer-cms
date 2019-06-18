<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::Group(['prefix' => 'article', 'namespace' => 'Api',], function () {
    //最新的N条新闻
    Route::get('/new_articles', 'ArticleController@newArticle');
    // 获取文章详情
    Route::get('/{id}/detail', 'ArticleController@articleDetail');
});


Route::get('ajax/loadTags',['as'=>'web.ajax.loadTags','uses'=>'AjaxController@loadTags']);
