<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TaggableModel extends BaseModel
{
    //
    protected $table='taggles';
    protected $fillable = ['source_type', 'source_id', 'tag_id'];

    /**
     * 热门的是个标签
     * @param string $type
     * @param int $pageSize
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function hottest($type='all',$pageSize=20)
    {
        $tagIds = TagModel::lists('id');
        $query =  DB::table('taggables')->select('tag_id',DB::raw('COUNT(id) as total_num'))
            ->whereIn('tag_id',$tagIds);
        if($type=='articles'){
            $query->where('taggable_type','=','App\Models\ArticleModel');
        }
        $taggables = $query->groupBy('tag_id')
            ->orderBy('total_num','desc')
            ->paginate($pageSize);
        return $taggables;
    }
}
