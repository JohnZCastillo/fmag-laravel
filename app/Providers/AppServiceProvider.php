<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Pagination\Paginator;
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

        Paginator::useBootstrapFive();

        $services = Service::select(['id','acronym','title'])
            ->get();

        $settings = GeneralSetting::findOrFail(1);

        $products = Product::select(['id','name'])
            ->where('archived',false)
            ->take(5)
            ->get();

        view()->share([
            'services' => $services,
            'settings' => $settings,
            'topProducts' => $products,
        ]);
    }
}
