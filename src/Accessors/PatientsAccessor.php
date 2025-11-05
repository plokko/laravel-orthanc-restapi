<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class PatientsAccessor extends BaseEntityAccessor
{
    public function __construct(OrthancApiAccessor $accessor)
    {
        parent::__construct($accessor, 'patients');
    }
}
