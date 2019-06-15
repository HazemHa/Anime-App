<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // Custom Polymorphic Types
         // do not forget to uncomment use ....
        
        Relation::morphMap([
       //     'episodes' => 'App\Episode',
        //    'groups' => 'App\Group',
         //   'user' => 'App\User',

        ]);
        

        Resource::withoutWrapping();

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
