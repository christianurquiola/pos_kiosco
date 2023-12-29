<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'created_by', 'order_number','status','total_price'
    ];

    const UPLOADS = 'uploads/orders';
    /*public static function booted()
    {
        static::creating(function(Order $order){
            $order->order_number = Order::getNextOrderNumber();
        });
    }
    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $latestNumber = Order::code('created_at',$year)->max('order_number');
        if($latestNumber){
            return $latestNumber+1;
        }
        return $year . '001';
    }*/

    public function orderProducts()
    {
        return $this->belongsToMany(OrderProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class ,'order_products')
            ->withPivot('quantity', 'product_image', 'product_price')
            ->withTimestamps();
    }
}
