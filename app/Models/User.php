<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements LaratrustUser
{
    use HasApiTokens, HasFactory, Notifiable , HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone' ,
        'email',
        'password' ,
        'image'
    ];

    const UPLOADS = 'uploads/users';

    protected $appends = ['image_path'];
    
    public function getImagePathAttribute()
    {
        return asset('uploads/users/'.$this->image);
    }

    public static $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'image' => 'nullable|mimes:jpeg,png,jpg,gif',
        'permissions' => 'required|array|min:1',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function scopeSearch(Builder $builder,$filter)
    {
        $builder->when($filter)
            ->where('first_name','LIKE','%'.$filter.'%')
             ->orWhere('last_name','LIKE','%'.$filter.'%');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'created_by');
    }
}
