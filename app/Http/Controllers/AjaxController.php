<?php

namespace App\Http\Controllers;

use App\Models\TaggableModel;
use App\Models\TagModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    //
    public function loadTags(Request $request)
    {
        $word = $request->input('word');
        $tags = [];
        if( strlen($word) > 10 ){
            return response()->json($tags);
        }
        $type = $request->input('type','all');
        if(!$word){
            $tags = TaggableModel::hottest($type,10);
        }else{
            $tags = TagModel::where('tag_name','like',$word.'%')->select('id',DB::raw('tag_name as text'))->take(10)->get();
        }
        $tags = array_map(function($tag){
            return ['id'=>$tag['text'],
                'text'=>$tag['text']];
        },$tags->toArray());
        return response()->json($tags);
    }

}
