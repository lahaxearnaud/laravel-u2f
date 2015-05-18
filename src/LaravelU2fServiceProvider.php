<?php namespace Lahaxearnaud\U2f;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class LaravelU2fServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {

        $routeConfig = [
            'namespace' => '\Lahaxearnaud\U2f\Http\Controllers',
            'prefix' => '/u2f/',
        ];

        $this->app['router']->group($routeConfig, function(Router $router) {
            $router->get('register', [
                'uses' => 'U2fController@registerData',
                'as' => 'u2f.register.data'
            ]);
            $router->post('register', [
                'uses' => 'U2fController@register',
                'as' => 'u2f.register'
            ]);

            $router->get('auth', [
                'uses' => 'U2fController@authData',
                'as' => 'u2f.auth.data'
            ]);
            $router->post('auth', [
                'uses' => 'U2fController@auth',
                'as' => 'u2f.auth'
            ]);

            $router->get('assets/javascript', [
                'uses' => 'AssetController@js',
                'as' => 'u2f.assets.js',
            ]);
        });


        $this->publishes([
            __DIR__ . '/../database/migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->loadViewsFrom(__DIR__ . '/../views/', 'u2f');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('laravelu2f', function () {

            return new LaravelU2f();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelu2f'];
    }

}
