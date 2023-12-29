<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone',
        'email', 'address'
    ];

    protected $casts = [
      'phone' => 'array',
    ];

    public static $rules = [
        'name' => 'required|string',
        'phone' => 'required|array',
        'phone.*' => 'nullable|string',
        'email' => 'required|email',
        'address' => 'required|string',
    ];

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
