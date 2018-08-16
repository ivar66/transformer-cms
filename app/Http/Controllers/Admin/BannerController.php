<?php

namespace App\Http\Controllers\Admin;

use App\Models\BannerModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends BaseController
{
    //
    public function index(Request $request)
    {
        $banners = BannerModel::query()->orderBy('created_at', 'asc')->paginate(10);
        return view('admin.banner.index')->with(compact('banners'));
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {

    }
}
