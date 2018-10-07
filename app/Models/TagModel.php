<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagModel extends BaseModel
{
    //
    protected $table='tags';
    protected $fillable = ['tag_name','tag_log','summary','description'];

    /**通过字符串添加标签
     * @param $tagString
     * @param $taggable
     * @return array
     */
    public static function multiSave($tagString,$taggable)
    {
        $tags = array_unique(explode(",",$tagString));
        /*删除所有标签关联*/
        if($tags){
            $taggable->tags()->detach();
        }

        foreach($tags as $tag_name){

            if(!trim($tag_name)){
                continue;
            }

            $tag = self::firstOrCreate(['tag_name'=>$tag_name]);
            if(!$taggable->tags->contains($tag->id))
            {
                $taggable->tags()->attach($tag->id);
            }
        }
        return $tags;
    }

    public function articles()
    {
        return $this->morphedByMany('App\Models\ArticleModel', 'taggable','taggables','taggable_id','tag_id');
//                return $this->morphToMany('App\Models\TagModel','taggable','taggables','taggable_id','tag_id');

    }


}
