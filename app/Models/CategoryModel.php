<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends BaseModel
{
    //
    use SoftDeletes;
    protected $table = 'categories';

    protected $fillable = ['category_name','slug','status','sort'];

}
