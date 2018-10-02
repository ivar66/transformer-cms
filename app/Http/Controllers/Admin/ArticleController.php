<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ArticleController extends BaseController
{
    protected $validateRules = [
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:25|max:16777215',
        'summary' => 'required|min:5',
        'category_id' => 'sometimes|numeric'
    ];

    /**
     * 文章管理-列表页
     * @param Request $request
     *
     * @return $this
     */
    public function index(Request $request)
    {
        $filter = $request->all();

        $query = ArticleModel::query();

        $filter['category_id'] = $request->input('category_id', -1);


        /*提问人过滤*/
        if (isset($filter['user_id']) && $filter['user_id'] > 0) {
            $query->where('user_id', '=', $filter['user_id']);
        }

        /*问题标题过滤*/
        if (isset($filter['word']) && $filter['word']) {
            $query->where('title', 'like', '%' . $filter['word'] . '%');
        }

        /*提问时间过滤*/
        if (isset($filter['date_range']) && $filter['date_range']) {
            $query->whereBetween('created_at', explode(" - ", $filter['date_range']));
        }

        /*问题状态过滤*/
        if (isset($filter['status']) && $filter['status'] > -1) {
            $query->where('status', '=', $filter['status']);
        }

        /*分类过滤*/
        if ($filter['category_id'] > 0) {
            $query->where('category_id', '=', $filter['category_id']);
        }


        $articles = $query->orderBy('created_at', 'desc')->paginate(20);
        return view("admin.article.index")->with('articles', $articles)->with('filter', $filter);
    }

    /**
     * 文章管理-添加文章
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.article.create');
    }

    /**
     * 文章管理-提交文章
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->flash();
        $this->validate($request, $this->validateRules);
        $currentUser = Auth::user();
        $data = [
            'user_id' => $currentUser->id,
            'category_id' => intval($request->input('category_id', 0)),
            'title' => trim($request->input('title')),
            'content' => ($request->input('content')),
            'summary' => $request->input('summary'),
            'status' => 1,
        ];

        if ($request->hasFile('logo')) {
            $validateRules = [
                'logo' => 'required|image',
            ];
            $this->validate($request, $validateRules);
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filePath = 'articles/' . gmdate("Y") . "/" . gmdate("m") . "/" . uniqid(str_random(8)) . '.' . $extension;
            Storage::disk('local')->put($filePath, File::get($file));
            $data['logo'] = str_replace("/", "-", $filePath);
        }

        $article = ArticleModel::query()->create($data);
        if ($article) {
            $message = '文章发布成功';
            return $this->success(route('admin.article.index'), $message);
        }
        return $this->error("文章发布失败，请稍后再试", route('admin.article.index'));
    }

    /**
     * 文章管理-编辑文章
     * @param Request $request
     * @param $id
     *
     * @return $this
     */
    public function edit(Request $request, $id)
    {
        $article = ArticleModel::find($id);

        if (!$article) {
            abort(404);
        }
        return view("admin.article.edit")->with(compact('article'));
    }

    /**
     * 文章管理-边界文章-提交
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $article_id = $request->input('id');
        $article = ArticleModel::find($article_id);
        if (!$article) {
            abort(404);
        }
        $request->flash();

        $this->validate($request, $this->validateRules);

        $article->title = trim($request->input('title'));
        $article->content = ($request->input('content'));
        $article->summary = $request->input('summary');
        $article->category_id = $request->input('category_id', 0);

        if ($request->hasFile('logo')) {
            $validateRules = [
                'logo' => 'required|image',
            ];
            $this->validate($request, $validateRules);
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filePath = 'articles/' . gmdate("Y") . "/" . gmdate("m") . "/" . uniqid(str_random(8)) . '.' . $extension;
            Storage::disk('local')->put($filePath, File::get($file));
            $article->logo = str_replace("/", "-", $filePath);
        }

        $article->save();

        return $this->success(route('admin.article.index'), "文章编辑成功");
    }

    /**
     * 文章管理-审核文章
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verify(Request $request)
    {
        $articleIds = $request->input('ids', []);
        if (empty($articleIds)) {
            return $this->error("文章审核失败，请稍后再试", route('admin.article.index'));
        }
        ArticleModel::query()->whereIn('id', $articleIds)->update(['status' => 1]);
        return $this->success(route('admin.article.index') . '?status=0', '文章审核成功');
    }

    /**
     * 文章管理-删除文章
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            $this->error("文章删除失败，请稍后再试", route('admin.article.index'));
        }
        ArticleModel::destroy($ids);
        Artisan::call('cache:clear');
        return $this->success(route('admin.article.index'), '文章删除成功');
    }

    /**
     * 文章管理-修改分类
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeCategories(Request $request)
    {
        $ids = $request->input('ids', '');
        $categoryId = $request->input('category_id', 0);
        if ($ids) {
            ArticleModel::whereIn('id', explode(",", $ids))->update(['category_id' => $categoryId]);
        }
        return $this->success(route('admin.article.index'), '分类修改成功');
    }
}
