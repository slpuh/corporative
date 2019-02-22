<?php

namespace Corp\Providers;

use Corp\Article;
use Corp\Policies\ArticlePolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function($user) {
            return $user->canDo('VIEW_ADMIN',false);
        });
        
        Gate::define('VIEW_ADMIN_ARTICLES', function($user) {
            return $user->canDo('VIEW_ADMIN_ARTICLES',false);
        });
    }

}
