<?php

namespace App\Http\Controllers\Admin;

use App\Models\BannerModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannerController extends BaseController
{
    protected $validateRules = [
        'banner_name' => 'required|min:5|max:20',
        'banner_url' => 'required|min:5|max:255',
//        'banner_pic_url' => 'sometimes|max:255',
    ];

    //
    public function index(Request $request)
    {
        $banners = BannerModel::query()->orderBy('created_at', 'asc')->paginate(10);
        return view('admin.banner.index')->with(compact('banners'));
    }

    public function create(Request $request)
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        $request->flash();
        $this->validate($request, $this->validateRules);
        $currentUser = Auth::user();
        $data = [
            'creator_uid' => $currentUser->id,
            'creator_name' => $currentUser->name,
            'banner_name' => trim($request->input('banner_name')),
            'banner_url' => ($request->input('banner_url')),
            'sort' => $request->input('sort',0),
            'status' => 2,
        ];

        if ($request->hasFile('banner_pic_url')) {
            $validateRules = [
                'banner_pic_url' => 'required|image',
            ];
            $this->validate($request, $validateRules);
            $file = $request->file('banner_pic_url');
            $extension = $file->getClientOriginalExtension();
            $filePath = 'banners/' . gmdate("Y") . "/" . gmdate("m") . "/" . uniqid(str_random(8)) . '.' . $extension;
            Storage::disk('local')->put($filePath, File::get($file));
            $data['logo'] = $filePath;///str_replace("/", "-", $filePath);
        }
        dd($data);
        $article = BannerModel::query()->create($data);
        if ($article) {
            $message = 'banner发布成功';
            return $this->success(route('admin.banner.index'), $message);
        }
        return $this->error("banner创建失败，请稍后再试", route('admin.banner.index'));

    }

    public function edit(Request $request)
    {

    }

    public function update(Request $request)
    {

    }
}
