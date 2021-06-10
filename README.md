# laravel-u2f
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lahaxearnaud/laravel-u2f/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lahaxearnaud/laravel-u2f/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c85fa3f1-7854-4eec-932d-8ac625c1318c/mini.png)](https://insight.sensiolabs.com/projects/c85fa3f1-7854-4eec-932d-8ac625c1318c)

This PSR4 package provide u2f protocol integration in laravel 6 framework.


## Requirements
- A top level domain
- HTTPS
- PHP >= 7.2 (If you want to use this package with php 5 you need to use the version v1.1.0)

## Install

Via Composer

```bash
$ composer require lahaxearnaud/laravel-u2f
```

Laravel 5.5+ uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Configs

```bash
$ php artisan vendor:publish --provider="Lahaxearnaud\U2f\U2fServiceProvider" --tag=u2f-config
```

### Assets

```bash
$ php artisan vendor:publish --provider="Lahaxearnaud\U2f\U2fServiceProvider" --tag=u2f-components
```

### Views

```bash
$ php artisan vendor:publish --provider="Lahaxearnaud\U2f\U2fServiceProvider" --tag=u2f-views
```

Note that default views use Laravel's default Bootstrap 4. If you don't use it, you have to update the views.

### Migrations

```bash
$ php artisan vendor:publish --provider="Lahaxearnaud\U2f\U2fServiceProvider" --tag=u2f-migrations
$ php artisan migrate
```

### Middleware

In the app/Http/Kernel.php file

```php
 protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    // ...
    'u2f' => \Lahaxearnaud\U2f\Http\Middleware\U2f::class,
    ];
```

## Usage

A [example project](https://github.com/lahaxearnaud/laravel-u2f-example) is available to help you with the configuration / usage.

### Middleware

In the route.php file add the u2f middleware on your routes or groups:
```php
Route::get('admin/profile', ['middleware' => ['auth', 'u2f'], function () {
    //
}]);
```

In controller:

```php
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function __construct()
{
    $this->middleware(['auth', 'u2f']);
}
```

### Configuration

### Events

- Name: `u2f.authentication`

  Payload: `[ 'u2fKey' => $key, 'user' => Auth::user() ]`

  Description: An user authenticate himself with a valid u2f key

- Name: `u2f.register`

  Payload `[ 'u2fKey' => $key, 'user' => Auth::user() ]`

  Description: An user register a new u2f key


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email lahaxe[dot]arnaud[at]gmail[dot]com instead of using the issue tracker.

## Credits

- [Arnaud LAHAXE](https://github.com/lahaxearnaud)
- [Mike Robinson](https://github.com/multiwebinc)
- [Chakphanu Komasathit](https://github.com/chakphanu)
- [Anne Jan Brouwer](https://github.com/annejan)
- [Alexis Saettler](https://github.com/asbiin)
- [Thomas Lété](https://github.com/bistory)
- [Luca Bognolo](https://github.com/bogny)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## After coding

What better way to relax, after spending hours coding, than a good [cocktail](https://cocktailand.fr) on the terrace?
