<?php

namespace App\Providers;

use App\Dev\Foo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class FooServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('Foo',function(){
            return new Foo();
        });
    }
}
