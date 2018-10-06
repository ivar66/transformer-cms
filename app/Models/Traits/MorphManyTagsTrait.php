<?php

namespace App\Models\Traits;


trait MorphManyTagsTrait
{
    public function tags(){
        return $this->morphToMany('App\Models\TagModel','taggable','taggables','taggable_id','tag_id');
    }
}

