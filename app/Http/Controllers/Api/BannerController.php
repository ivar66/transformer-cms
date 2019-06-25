<?php

namespace App\Http\Controllers\Api;

use App\Models\BannerModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    //
    public function bannerList(){
        $arrBanner = BannerModel::query()->where('status',BannerModel::STATUS_PUBLISH)->orderBy('sort','desc')->get();
        return api_response($arrBanner);
    }
}
