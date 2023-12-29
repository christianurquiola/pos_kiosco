<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{

    public function create(Client $client)
    {
        $categories = Category::with('products')->select('id','name')->get();
        $orders = $client->orders()->with('products')->paginate();
        return view('dashboard.clients.orders.create',compact('client','categories' , 'orders'));
    }

    public function store(OrderCreateRequest $request , Client $client)
    {

        try {
            DB::beginTransaction();
            //create new order ;
            $order = $client->orders()->create(['created_by' => auth()->user()->id]);
            // attach items to order ;
            foreach($request->products as $id => $quantity){
                $product = Product::findOrFail($id);

                // Check if the stock is sufficient
                if ($product->stock < $quantity['quantity']) {
                    return redirect()->back()->withErrors(['error'=>'Insufficient stock for product ' . $product->name]);
                }

                // Copy image of product to orders folder
                $productImage = ($product->image == 'default.png') ? $product->image : $order->id . '_' . $product->image;
                $this->copyImage($product->image,$productImage);

                // attach product to order in order_products table
                $order->products()->attach($product, [
                    'quantity'      => $quantity['quantity'],
                    'product_image' => $productImage,
                    'product_price' => $product->sale_price,
                ]);

                /*$total_price += $product->sale_price * $quantity['quantity'];*/

                // decrees amount of product in stock
                $product->decrement('stock',$quantity['quantity']);
            }
                // calculate total price to store it in orders table of this list order
            $total_price = $this->calculateTotalPrice($order);
                // update total price to current order
            $order->update([
                'total_price' => $total_price,
            ]);

            DB::commit();
            return redirect()->route('dashboard.orders.index')->with('success',__('site.added_successfully'));
        }catch(\Exception $e){
            return redirect()->back()->withErrors('error',$e->getMessage());
        }

    }

    private function copyImage($oldImage ,$newImage )
    {
        if($oldImage != 'default.png'){
            File::copy(
                public_path(Product::UPLOADS."/{$oldImage}"),
                public_path(Order::UPLOADS."/{$newImage}")
            );
        }
    }
    private function calculateTotalPrice($order)
    {
        return $order->products->sum(function ($product) {
            return ($product->pivot->product_price * $product->pivot->quantity);
        });
    }


    public function edit(Client $client,Order $order )
    {
        $categories = Category::with('products')->select('id','name')->get();
        $orders = $client->orders()->with('products')->paginate();
        //$order_products = $orders->products->pluck('id')->toArray();
        return view('dashboard.clients.orders.edit',compact('client','categories' , 'orders','order'));
    }

    public function update(Request $request, Order $order ,Client $client)
    {
        //
    }

}
