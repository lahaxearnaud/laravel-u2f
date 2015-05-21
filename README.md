# laravel-u2f
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lahaxearnaud/laravel-u2f/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lahaxearnaud/laravel-u2f/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c85fa3f1-7854-4eec-932d-8ac625c1318c/mini.png)](https://insight.sensiolabs.com/projects/c85fa3f1-7854-4eec-932d-8ac625c1318c)

This PSR4 package provide u2f protocol integration in laravel 5 framework.

## Requirements
- A top level domain
- HTTPS

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
    "Lahaxeanaud\U2f\LaravelU2fServiceProvider"
]
```

### Alias

In the config/app.php file:
``` php
[
    //...
    'U2f' => 'Lahaxeanaud\U2f\U2fServiceFacade'
]
```

### Configs

``` bash
$ php artisan vendor:publish --provider="Lahaxeanaud\U2f\U2fServiceProvider" --tag=config
$ php artisan migrate
```

### Migrations

``` bash
$ php artisan vendor:publish --provider="Lahaxeanaud\U2f\U2fServiceProvider" --tag=migrations
$ php artisan migrate
```

### Middleware

In the app/Http/Kernel.php file

``` php
protected $routeMiddleware = [
    // ...
    'u2f' => 'Lahaxeanaud\U2f\Http\Middleware\U2f',
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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
