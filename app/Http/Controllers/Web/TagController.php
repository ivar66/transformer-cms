<?php

namespace App\Http\Controllers\Web;

use App\Models\ArticleModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    //
    public function index( $categorySlug='all')
    {

        $currentCategoryId = 0;
        if( $categorySlug != 'all' ){
            $category = CategoryModel::where("slug","=",$categorySlug)->first();
            if(!$category){
                abort(404);
            }
            $currentCategoryId = $category->id;
        }

        $categories = load_categories('tags');

        $topics = TagModel::query()->orderBy('created_at','DESC')->paginate(20);
        return view('web.topic.index')->with(compact('topics','categories','currentCategoryId','categorySlug'));
    }

    /**
     * 话题主页
     * GET /topic/{topic_id}/{source_type?}
     * @param $topic_id
     * @param string $source_type
     * @return $this
     */
    public function detail($topic_id,$source_type='articles'){
        $tag = TagModel::findOrFail($topic_id);
        $sources = [];
        if($source_type=='questions'){
            $sources = $tag->questions()->orderBy('created_at','desc')->paginate(15);
        }else if($source_type=='articles'){
            $sources = $tag->articles()->where('status',ArticleModel::PASS_STATUS)->orderBy('created_at','desc')->paginate(15);
        }else{
            abort(404);
        }
        return view('web.topic.detail')->with('tag',$tag)
            ->with('sources',$sources)
            ->with('source_type',$source_type);
    }
}
