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
        $articles = ArticleModel::query()->orderBy('id', 'desc')->limit($number)->get();

        if (count($articles)) {
            foreach ($articles as $article) {
                $item[] = [
                    'id' => $article->id,
                    'user_id' => $article->user_id,
                    'user_name' => $article->user->name,
                    'category_name' => $article->category->category_name,
                    'title' => $article->title,
                    'summary' => $article->summary,
                    'created_at' => $article->created_at->toDateTimeString()
                ];
            }
            $articles = $item;
        }

        return api_response($articles);
    }
}
