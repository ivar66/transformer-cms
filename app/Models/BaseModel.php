<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    //
    // 分页默认显示条数
    protected $perPage = 20;
    /**
     * Get a subset of the model's attributes.
     *
     * @param  array|mixed  $attributes
     * @return array
     */
//    public function only($attributes)
//    {
//        $results = [];
//        foreach (is_array($attributes) ? $attributes : func_get_args() as $attribute) {
//            $results[$attribute] = $this->getAttribute($attribute);
//        }
//        return $results;
//    }
}
