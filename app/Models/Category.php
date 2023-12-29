<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['name'];

    public $fillable = ['name'];

    public function scopeSearch(Builder $builder , $filter = null)
    {
        /*$builder->when($filter)
            ->where('name->en','LIKE','%'.$filter.'%')
            ->orWhere('name->ar','LIKE','%'.$filter.'%');*/
        $builder->when($filter,function($builder,$value){
            $builder->where('name->en','LIKE','%'.$value.'%')
                ->orWhere('name->ar','LIKE','%'.$value.'%');
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }



}
