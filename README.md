# laravel-orthanc-restapi
Laravel integration for the Orthanc DICOM REST API. Provides a configurable HTTP client to call Orthanc endpoints from your application.

## Requirements
- PHP 8.2+
- Laravel 12.x (or later)
- Orthanc server with REST API enabled

## Installation

1. Require the package via Composer:

```
composer require plokko/laravel-orthanc-restapi
```

2. Package discovery should register the service provider automatically. To register manually, add the provider to `config/app.php`:

```php
'providers' => [
    // ...
    Plokko\OrthancRestApi\OrthancRestApiServiceProvider::class,
],
```
