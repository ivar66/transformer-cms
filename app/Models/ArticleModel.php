<?php

namespace App\Models;

use App\Models\Traits\MorphManyTagsTrait;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleModel extends BaseModel
{
    //
    use MorphManyTagsTrait;
    use SoftDeletes;
    protected $table = 'articles';
    protected $primaryKey = 'id';

    //待审核
    const JUDEGE_STATUS = 0;
    //审核通过
    const PASS_STATUS = 1;


    protected $fillable = [
      'user_id','category_id','title','content','status','summary','logo'
    ];

    protected $appends = [
        'user_name','category_name'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel');
    }

    /**
     * @return mixed
     */
    public function getCategoryNameAttribute(){
        return CategoryModel::query()->where('id',$this->category_id)->value('category_name');
    }
    /**
     * 获取作者姓名
     * @return mixed
     */
    public function getUserNameAttribute(){
        return User::query()->where('id',$this->user_id)->value('name');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*获取相关文章*/
    public static function correlations($tagIds,$article_id,$size=6)
    {
        $relationArticles = self::whereHas('tags', function($query) use ($tagIds) {
            $query->whereIn('tag_id', $tagIds);
        })->where('status',self::PASS_STATUS)->where('id','<>',$article_id)->orderBy('created_at','DESC')->take($size)->get();
        return $relationArticles;
    }
}
