<?php

Route::get('/', function () {
    return redirect('/articles');
});

/**
 * 文章相关模块
 */
Route::Group([ 'namespace' => 'Web'], function () {
    /*文章列表页*/
    Route::match('get', 'articles/{category_name?}', ['as' => 'web.blog.index', 'uses' => 'BlogController@index']);

    /*文章详情页*/
    Route::get('/article/{article_id}', ['as' => 'web.blog.detail', 'uses' => 'BlogController@detail']);


    Route::get('/sitemap',['as'=>'web.sitemap','uses'=>'SiteMapController@index']);
});