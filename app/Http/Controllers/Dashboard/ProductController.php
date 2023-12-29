<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\traits\UploadFile;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use UploadFile;

    public function __construct()
    {
        $this->middleware('permission:products_read')->only('index');
        $this->middleware('permission:products_create')->only('create');
        $this->middleware('permission:products_update')->only(['edit','update']);
        $this->middleware('permission:products_delete')->only('destroy');
    }

    public function index()
    {
        $categories = Category::select('id','name')->get();
        $products = Product::search(\request()->query())->with('category')->paginate();
        return view('dashboard.products.index',compact('products','categories'));
    }


    public function create()
    {
        $categories = Category::select('id','name')->get();
        return view('dashboard.products.create',compact('categories'));
    }


    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        if($request->hasFile('image'))
            $data['image'] = $this->uploadFile(Product::UPLOADS,$request->file('image'));

        Product::create($data);
        return redirect()->route('dashboard.products.index')->with('success',__('site.added_successfully'));
    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        $categories = Category::select('id','name')->get();
        return view('dashboard.products.edit',compact('categories','product'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $date = $request->validated();
        if($request->hasFile('image')){
            if($product->image != 'default.png') {
                $date['image'] = $this->uploadFile(Product::UPLOADS,$request->file('image'),$product->image);
            }else{
                $date['image'] = $this->uploadFile(Product::UPLOADS,$request->file('image'));
            }
        }
        $product->update($date);
        return to_route('dashboard.products.index')->with('success', __('site.updated_successfully'));
    }

    public function destroy(Product $product)
    {
        if($product->image != 'default.png')
            $this->removeFile(Product::UPLOADS, $product->image);
        $product->delete();
        return to_route('dashboard.products.index')->with('success', __('site.deleted_successfully'));
    }
}
