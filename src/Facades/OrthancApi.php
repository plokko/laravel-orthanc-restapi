<?php

namespace Plokko\LaravelOrthancRestApi\Facades;

use Illuminate\Support\Facades\Facade;
use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class OrthancApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OrthancApiAccessor::class;
    }
}
