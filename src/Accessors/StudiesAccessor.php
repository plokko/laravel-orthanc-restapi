<?php

namespace Plokko\LaravelOrthancRestApi\Accessors;

use Plokko\LaravelOrthancRestApi\OrthancApiAccessor;

class StudiesAccessor extends BaseEntityAccessor
{
    public function __construct(OrthancApiAccessor $accessor)
    {
        parent::__construct($accessor, 'studies');
    }
}
