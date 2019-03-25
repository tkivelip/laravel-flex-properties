<?php

namespace LaravelFlexProperties;

use LaravelFlexProperties\Interfaces\FlexProperties;
use LaravelFlexProperties\Traits\HasFlexProperties;
use Mindtwo\DynamicMutators\Traits\HasDynamicMutators;

class Model extends \Illuminate\Database\Eloquent\Model implements FlexProperties
{
    use HasDynamicMutators,
        HasFlexProperties;
}
