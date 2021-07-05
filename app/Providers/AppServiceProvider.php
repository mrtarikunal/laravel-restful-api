<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //ResourceResponse::withoutWrapping();
        //resorcela çektiğimiz veri içindeki data değişkenini kaldırmak için
        //ama laravel7 ile dğişmiş böyle çalışmıyor
    }
}
