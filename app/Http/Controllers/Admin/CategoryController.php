<?php

namespace App\Http\Controllers\Admin;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $categories = CategoryModel::orderBy('sort', 'asc')->orderBy('created_at', 'asc')->paginate(10);
        return view("admin.category.index")->with(compact('categories'));
    }
}
