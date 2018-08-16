<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class CategoryModel extends BaseModel
{

    use SoftDeletes;
    protected $table = 'categories';

    protected $fillable = ['category_name', 'slug', 'status', 'sort'];

    /**
     * 获取当前已审核的分类种类
     * @return mixed
     */
    public static function loadFromCache()
    {
        $globalCategories = Cache::rememberForever('global_categories', function () {
            return self::where('status', '=', 1)->orderBy('sort', 'asc')->orderBy('created_at', 'asc')->get();
        });
        return $globalCategories;
    }
}
