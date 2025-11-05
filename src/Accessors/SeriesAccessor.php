<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class SeriesAccessor extends BaseEntityAccessor
{
    public function __construct(OrthancApiAccessor $accessor)
    {
        parent::__construct($accessor, 'series');
    }
}
