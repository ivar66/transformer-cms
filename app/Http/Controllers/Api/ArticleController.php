<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * 获取最新的N条数据
     * /api/article/new_articles
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function newArticle(Request $request)
    {
        $number = $request->input('number', 10);
        $articles = ArticleModel::query()->where('status',ArticleModel::PASS_STATUS)->orderBy('id', 'desc')->limit($number)->get();
        if (count($articles)) {
            $item = [];
            foreach ($articles as $article) {
                $item[] = [
                    'id' => $article->id,
                    'user_id' => $article->user_id,
                    'user_name' => $article->user->name,
                    'category_name' => $article->category['category_name'],
                    'title' => $article->title,
                    'summary' => $article->summary,
                    'views' => $article->views,
                    'created_at' => $article->created_at->toDateTimeString()
                ];
            }
            $articles = $item;
        }

        return api_response($articles);
    }

    /**
     * 获取文章详情页
     * GET /api/article/{article_id}/detail
     * @param Request $request
     * @param $article_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function articleDetail(Request $request,$article_id){
        if (empty($article_id)){
            return api_response([]);
        }
        $articleDetail = ArticleModel::query()->find(trim($article_id));
        $articleDetail = $this->formatArticleDetail($articleDetail);
        return api_response($articleDetail);
    }

    /**
     * 组装文章详情页数据内容
     * @param $articleDetail
     * @return array
     */
    protected  function formatArticleDetail($articleDetail){
        return empty($articleDetail) ? array():array(
                                                        'article_id' => $articleDetail->id,
                                                        'user_name'  => $articleDetail->user_name,
                                                        'category_name'  => $articleDetail->category_name,
                                                        'summary'  => $articleDetail->summary,
                                                        'title'  => $articleDetail->title,
                                                        'views'  => $articleDetail->views,
                                                        'created_at' => $articleDetail->created_at->toDateTimeString(),
                                                        'content'  => $articleDetail->content,
                                                    );
    }
}
