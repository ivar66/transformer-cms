<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleModel extends BaseModel
{
    //
    protected $table = 'articles';
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
