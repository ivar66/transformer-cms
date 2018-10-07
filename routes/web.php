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

    /*话题页面*/
    Route::match('get','topics',['as'=>'web.topic.index','uses'=>'TagController@index']);

    /*话题详情页*/
    Route::get('/topic/{topic_id}/{source_type?}',['as'=>'web.topic.detail','uses'=>'TagController@detail']);

    /*关于我*/
    Route::get('/member',['as'=>'web.member.index','uses'=>'TagController@detail']);

    //sitemap
    Route::get('/sitemap',['as'=>'web.sitemap','uses'=>'SiteMapController@index']);
});