<?php

namespace App\Http\Controllers\Web;

use App\Models\ArticleModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * 文章列表页面
     * @param string $categorySlug
     * @return $this
     */
    public function index($categorySlug='all'){
        $currentCategoryId = 0;
        $articleQuery = ArticleModel::query()->where('status',ArticleModel::PASS_STATUS);
        if( $categorySlug != 'all' ){
            $category = CategoryModel::where("slug","=",$categorySlug)->first();
            if(!$category){
                abort(404);
            }
            $currentCategoryId = $category->id;
            $articleQuery->where('category_id',$currentCategoryId);
        }

        $seoTDK = [
            'seo_title'=> '喝醉的清茶-文章-'.(('all'==$categorySlug)?'全部信息':$category->category_name),
            'seo_keyword'=> '喝醉的清茶-文章-'.(('all'==$categorySlug)?'全部信息':$category->category_name),
            'seo_description'=> '喝醉的清茶-文章-'.(('all'==$categorySlug)?'全部类别信息':$category->category_name),
        ];

        $categories = CategoryModel::loadFromCache();
        $articles = $articleQuery->orderBy('created_at','desc')->paginate(10);
        return view('web.blog.index')->with(compact('categories','currentCategoryId','articles','seoTDK'));
    }

    /**
     * 文章详情页面
     * @param Request $request
     * @param $article_id
     * @return $this
     */
    public function detail(Request $request,$article_id){
        $article = ArticleModel::query()->where('id',$article_id)->where('status',ArticleModel::PASS_STATUS)->first();
        if (!$article){
            abort(404);
        }
        $article->increment('views');
        /*相关文章*/
        $relatedArticles = ArticleModel::correlations($article->tags->pluck('id'),$article_id);
        return view('web.blog.detail')->with(compact('article','relatedArticles'));
    }
}
