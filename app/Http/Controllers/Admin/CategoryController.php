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

    /**
     * 管理菜单-内容-分类管理-列表
     *
     * @param Request $request
     *
     * @return $this
     */
    public function index(Request $request)
    {
        $categories = CategoryModel::orderBy('sort', 'asc')->orderBy('created_at', 'asc')->paginate(10);
        return view("admin.category.index")->with(compact('categories'));
    }

    /**
     * 管理菜单-内容-分类管理-创建分类页面
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('admin.category.create');
    }

    /**
     * 管理菜单-内容-分类管理-创建分类提交
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->flash();
        $this->validate($request, $this->validateRules);
        $formData = $request->all();
        CategoryModel::query()->create($formData);
        Artisan::call('cache:clear');
        return $this->success(route('admin.category.index'), '分类添加成功');
    }

    /**
     * 管理菜单-内容-分类管理-编辑分类
     *
     * GET /admin/category/edit?id={id}
     *
     * @param Request $request
     *
     * @return $this
     * @internal param $id
     */
    public function edit(Request $request)
    {
        $category = CategoryModel::find($request->id);

        if (!$category) {
            return $this->error(route('admin.category.index'), '分类不存在，请核实');
        }
        return view('admin.category.edit')->with(compact('category'));

    }

    /**
     * 管理菜单-内容-分类管理-编辑分类提交
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {

        $category = CategoryModel::find($request->id);
        if (!$category) {
            return $this->error(route('admin.category.index'), '分类不存在，请核实');
        }

        $this->validateRules['slug'] = "required|max:255|unique:categories,slug," . $category->id;

        $this->validate($request, $this->validateRules);
        $category->category_name = $request->input('category_name');
        $category->slug = $request->input('slug');
        $category->sort = $request->input('sort');
        $category->status = $request->input('status');
        $category->save();
        Artisan::call('cache:clear');
        return $this->success(route('admin.category.index'), '分类更新成功');
    }

    /**
     * 管理菜单-内容-分类管理-删除分类
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
