<?php namespace Lahaxearnaud\U2f;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use \Config as Config;

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
        $router->get('auth/u2f/register', ['uses' => '\Lahaxearnaud\U2f\Http\Controllers\U2fController@registerData', 'as' => 'otp.register.data']);
        $router->post('auth/u2f/register', ['uses' => '\Lahaxearnaud\U2f\Http\Controllers\U2fController@register', 'as' => 'otp.register']);

        $router->get('auth/u2f/auth', ['uses' => '\Lahaxearnaud\U2f\Http\Controllers\U2fController@authData', 'as' => 'otp.auth.data']);
        $router->post('auth/u2f/auth', ['uses' => '\Lahaxearnaud\U2f\Http\Controllers\U2fController@auth', 'as' => 'otp.auth']);

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
