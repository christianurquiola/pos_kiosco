<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\traits\UploadFile;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use UploadFile;
    public function index()
    {
        $orders = Order::with('products')->whereHas('client',function ($query){
            $query->where('name','like','%'.\request()->query('name').'%');
        })->paginate();
        return view('dashboard.orders.index',compact('orders'));
    }
    public function showProduct(Order $order )
    {  // ajax
        $products = $order->products;
        return view('dashboard.orders._products', compact('order','products'));
    }// end of showProduct

    public function destroy(Order $order)
    {
        collect($order->products)->each(function ($product) {
           // dump($product->pivot->quantity  , (Order::UPLOADS.'/'.$product->pivot->product_image));
            if( $product->pivot->product_image && $product->pivot->product_image != 'default.png')
                $this->removeFile(Order::UPLOADS,$product->pivot->product_image);

            $product->increment('stock',$product->pivot->quantity);
        });
        $order->delete();
        return redirect()->back()->with('success',__('site.deleted_successfully'));

    }

}
