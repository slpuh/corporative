<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;


class RouteServiceProvider extends ServiceProvider
{
    
    protected $namespace = 'Corp\Http\Controllers';

    
    public function boot()
    {
        Route::pattern('alias','[\w-]+');

        parent::boot();
        
        Route::bind('alias',function($value){
            return \Corp\Article::where('alias',$value)->first();
        });
        
//        $router->bind('menus', function($value) {
//           return Menu::where('id',$value)->first(); 
//        });
//
//        $router->bind('users', function($value) {
//            return User::find($value);
//        });
    }

    
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
