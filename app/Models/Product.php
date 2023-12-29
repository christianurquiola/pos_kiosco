<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name', 'description', 'purchase_price','code',
        'sale_price', 'stock', 'image', 'category_id',
    ];

    public static $rules = [
        'name' => 'nullable',
        'description' => 'nullable',
        'description_en' => 'required|string',
        'description_ar' => 'required|string',
        'purchase_price' => 'required|numeric|min:1',
        'sale_price' => 'required|numeric|min:1',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:8048',
        'category_id' => 'required|exists:categories,id',
    ];

    public function scopeSearch(Builder $builder , $filters)
    {
        $options = array_merge([
            'category_id' => null,
            'name' => null,
        ],$filters);

        $builder->when($options['name'],function($builder,$value){
            $builder->where('name->en','LIKE','%'.$value.'%')
                ->orWhere('name->ar','LIKE','%'.$value.'%');
        });
        $builder->when($options['category_id'],function($builder,$value){
           $builder->where('category_id',$value);
        });


    }

    public static function booted()
    {
        static::creating(function(Product $product){
            $product->code = Product::getNextProductCode();
        });
    }
    public static function getNextProductCode()
    {
        $year = Carbon::now()->year;
        $latest_code = Product::whereYear('created_at',$year)->max('code');
        if($latest_code){
            return  ($latest_code + 1) ;
        }
        return 'pr'.$year.'0001';
    }
    const UPLOADS = 'uploads/products';

    protected $appends = [
      'image_path','profit_percent',
    ];
    public function getImagePathAttribute()
    {
        return asset(self::UPLOADS.'/'.$this->image);
    }
    public function getProfitPercentAttribute()
    {
       $profit = $this->sale_price - $this->purchase_price;
       $percent  = ($profit * 100) / $this->purchase_price;
       return number_format($percent , 2);
    }



    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class , 'order_products')
            ->withPivot('quantity', 'product_image', 'product_price')
            ->withTimestamps();
    }

}
