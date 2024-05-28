<?php

namespace App\Providers;

use App\Models\Products;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        // update a product
        Gate::define('update-product', function(User $user, Products $products){
            return $user->id===$products->user_id;
        });
    }
}
