<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:categories_read')->only('index');
        $this->middleware('permission:categories_create')->only('create');
        $this->middleware('permission:categories_update')->only(['edit','update']);
        $this->middleware('permission:categories_delete')->only('destroy');
    }

    public function index()
    {
        $categories = Category::search(request()->query('name'))->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }// end of index
    public function create()
    {
        return view('dashboard.categories.create');
    }// end of create
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->safe()->only('name'));
        return to_route('dashboard.categories.index')->with('success', __('site.added_successfully'));
    }// end of store
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }// end of edit
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->safe()->only('name'));
        return to_route('dashboard.categories.index')->with('success', __('site.updated_successfully'));
    }// end of update
    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('dashboard.categories.index')->with('success', __('site.deleted_successfully'));
    }// end of destroy
}
