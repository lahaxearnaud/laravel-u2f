# laravel-u2f
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lahaxearnaud/laravel-u2f/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lahaxearnaud/laravel-u2f/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c85fa3f1-7854-4eec-932d-8ac625c1318c/mini.png)](https://insight.sensiolabs.com/projects/c85fa3f1-7854-4eec-932d-8ac625c1318c)

This PSR4 package provide u2f protocol integration in laravel 5 framework.


## Requirements
- A top level domain
- HTTPS
- PHP 7.* (If you want to use this package en php 5 you need to use the version v1.1.0)

## Install

Via Composer

``` bash
$ composer require lahaxearnaud/laravel-u2f
```

### Provider

In the config/app.php file:
``` php
[
    //...
    Lahaxearnaud\U2f\U2fServiceProvider::class,
]
```

### Alias

In the config/app.php file:
``` php
[
    //...
    'U2f' => Lahaxearnaud\U2f\U2fFacade::class,
]
```

### Configs

``` bash
$ php artisan vendor:publish --provider="Lahaxearnaud\U2f\U2fServiceProvider" --tag=config
```

### Migrations

``` bash
$ php artisan vendor:publish --provider="Lahaxearnaud\U2f\U2fServiceProvider" --tag=migrations
$ php artisan migrate
```

### Middleware

In the app/Http/Kernel.php file

``` php
protected $routeMiddleware = [
    // ...
    \Lahaxearnaud\U2f\Http\Middleware\U2f::class,
];
```

## Usage

### Middleware

In the route.php file add the u2f middleware on your routes or groups:
``` php
    Route::get('admin/profile', ['middleware' => ['auth', 'u2f'], function () {
        //
    }]);
```
### Configuration

### Events

// to do

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email lahaxe[dot]arnaud[at]gmail[dot]com instead of using the issue tracker.

## Credits

- [Arnaud LAHAXE](https://github.com/lahaxearnaud)
- [Mike Robinson](https://github.com/multiwebinc)
- [Chakphanu Komasathit](https://github.com/chakphanu)
- [Anne Jan Brouwer](https://github.com/annejan)
- [Alexis Saettler](https://github.com/asbiin)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## After coding

What better way to relax, after spending hours coding, than a good [cocktail](https://cocktailand.fr) on the terrace?
