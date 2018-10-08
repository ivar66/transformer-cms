<?php

namespace App\Http\Controllers\Web;

use App\Models\ArticleModel;
use App\Models\TagModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SiteMapController extends Controller
{
    public function index(){
        $sitemap = App::make('sitemap');
        $sitemap->setCache('project.sitemap', 30);
        if (!$sitemap->isCached()) {
            /*静态链接*/
            $sitemap->add(URL::to(route('web.blog.index')), null, '1.0', 'daily');
            $sitemap->add(URL::to(route('web.topic.index')), null, '1.0', 'daily');


            $startTime = Carbon::now()->subMonth(12);

            /*文章*/
            $articles = ArticleModel::where("status", ">", 0)->where('created_at', '>', $startTime)->orderBy('created_at', 'desc')->take(1200)->get();
            foreach ($articles as $article) {
                $sitemap->add(URL::to(route('web.blog.detail', ['article_id' => $article->id])), $article->created_at, '0.9', 'daily');
            }

            $tags = TagModel::query()->where('created_at', '>', $startTime)->orderBy('created_at', 'desc')->take(1200)->get();
            foreach ($tags as $tag){
                $sitemap->add(URL::to(route('web.topic.detail', ['topic_id' => $tag->id])), $tag->created_at, '0.9', 'daily');
            }
        }

        return $sitemap->render('xml');
    }
}
