<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Paginator::useBootstrap();

        Schema::defaultStringLength(131);

        Blade::if('hasPermission',function(string $permission){
            return (auth()->user()->hasPermission( $permission));
        });

        Builder::macro('filter',function(string $filed ,$search){
            return $search ? $this->where($filed,'like','%'.$search.'%') : $this;
        });
    }
}
