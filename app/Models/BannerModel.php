<?php

namespace App\Models;


class BannerModel extends BaseModel
{
    protected $table = 'banners';
    protected $fillable = ['banner_name', 'banner_url','banner_pic_url','sort','status'];
}
