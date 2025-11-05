# laravel-orthanc-restapi
Laravel integration for the Orthanc DICOM REST API. Provides a configurable HTTP client to call Orthanc endpoints from your application.

## Requirements
- PHP 8.2+
- Laravel 12.x (or later)
- Orthanc server with REST API enabled

## Installation

### Composer install
Require the package via Composer:

```
composer require plokko/laravel-orthanc-restapi
```

Package discovery should register the service provider automatically. To register manually, add the provider to `config/app.php`:

```php
'providers' => [
    // ...
    Plokko\OrthancRestApi\OrthancRestApiServiceProvider::class,
],
```


### Auth integration

The OrthancApi needs an auth token for access.
To allow seamless integration with multiple systems no token retrival is defined, you should define it in the boot method on your AppServiceProvider:

```php

class AppServiceProvider extends ServiceProvider
{
    //...
    
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /// Register OrthancAPI authenticator ///
        OrthancApiAuthInterface::setHandleTokenGeneration(function (?string $server) => YourImplementationOnHowToGetAnAuthToken());
    }
}
```



## Configuration

You can publish default configuration file with the command:
```bash
php artisan vendor:publish --tag=laravel-orthanc-restapi:config
```

You should now see a *laravel-orthanc-restapi.php* file under your *config* folder.

