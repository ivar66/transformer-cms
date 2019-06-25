<?php

namespace App\Models;


class BannerModel extends BaseModel
{
    protected $table = 'banners';
    protected $fillable = ['banner_name', 'banner_url','banner_pic_url','sort','status'];
    protected $hidden = ['created_at','updated_at','status','id'];
    const STATUS_PUBLISH = 1;
}
