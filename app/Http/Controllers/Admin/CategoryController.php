<?php

namespace App\Http\Controllers\Admin;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CategoryController extends BaseController
{
    /*权限验证规则*/
    protected $validateRules = [
        'category_name' => 'required|max:255',
        'slug' => 'required|max:255|unique:categories',
    ];

    //
    public function index()
    {
        $categories = CategoryModel::orderBy('sort', 'asc')->orderBy('created_at', 'asc')->paginate(10);
        return view("admin.category.index")->with(compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * 保存相关信息
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->flash();
//        $this->validate($request,$this->validateRules);
        $formData = $request->all();
        CategoryModel::query()->create($formData);
        Artisan::call('cache:clear');
        return $this->success(route('admin.category.index'), '分类添加成功');
    }

    /**
     * edit get category information
     * GET /admin/category/edit?id={id}
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function edit(Request $request)
    {
        $category = CategoryModel::find($request->id);

        if (!$category) {
            return $this->error(route('admin.category.index'), '分类不存在，请核实');
        }
        return view('admin.category.edit')->with(compact('category'));

    }

    public function update(Request $request){

        $category = CategoryModel::find($request->id);
        if(!$category){
            return $this->error(route('admin.category.index'),'分类不存在，请核实');
        }

        $this->validateRules['slug'] = "required|max:255|unique:categories,slug,".$category->id;

        $this->validate($request,$this->validateRules);
        $category->category_name = $request->input('category_name');
        $category->slug = $request->input('slug');
        $category->sort = $request->input('sort');
        $category->status = $request->input('status');
        $category->save();
        Artisan::call('cache:clear');
        return $this->success(route('admin.category.index'),'分类更新成功');
    }

    /**
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        CategoryModel::destroy($request->input('ids'));
        Artisan::call('cache:clear');
        return $this->success(route('admin.category.index'), '分类删除成功');
    }
}
