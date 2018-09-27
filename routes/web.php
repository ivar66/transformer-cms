<?php

Route::get('/', function () {
    return redirect('/blog');
});

/**
 * 文章相关模块
 */
Route::Group([ 'namespace' => 'web'], function () {
    /*文章列表页*/
    Route::match('get', 'articles/{category_name?}', ['as' => 'web.blog.index', 'uses' => 'BlogController@index']);

    /*文章详情页*/
    Route::get('/article/{article_id}', ['as' => 'admin.blog.detail', 'uses' => 'BlogController@detail']);
});