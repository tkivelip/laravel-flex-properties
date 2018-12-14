<?php

namespace LaravelFlexProperties;

use mindtwo\LaravelDynamicModelMutators\DynamicModelMutator;
use LaravelFlexProperties\Interfaces\FlexProperties;
use LaravelFlexProperties\Traits\HasFlexProperties;

class Model extends \Illuminate\Database\Eloquent\Model implements FlexProperties
{
    use DynamicModelMutator,
        HasFlexProperties;
}