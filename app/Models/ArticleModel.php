<?php

namespace App\Models;

use App\Models\Traits\MorphManyTagsTrait;
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
    public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
