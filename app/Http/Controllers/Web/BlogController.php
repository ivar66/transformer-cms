<?php

namespace App\Http\Controllers\Web;

use App\Models\ArticleModel;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    //
    public function index($categorySlug='all'){
        $currentCategoryId = 0;
        $articleQuery = ArticleModel::query();
        if( $categorySlug != 'all' ){
            $category = CategoryModel::where("slug","=",$categorySlug)->first();
            if(!$category){
                abort(404);
            }
            $currentCategoryId = $category->id;
            $articleQuery->where('category_id',$currentCategoryId);
        }
        $categories = CategoryModel::query()->get();
        $articles = $articleQuery->paginate(10);
        return view('web.blog.index')->with(compact('categories','currentCategoryId','articles'));
    }
}
