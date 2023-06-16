<?php

namespace App\Providers;

//call paginator 
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\User;

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

         view()->composer('*', function ($view) {
            
       $myFunction = User::first();
       // dd($myFunction);
        $view->with('myFunction',$myFunction);

        });

        //
		//fix for pagination making weird oversize by using bootstraps paginator
        Paginator::useBootstrap();
    }
}
