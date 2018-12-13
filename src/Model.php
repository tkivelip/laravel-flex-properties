<?php

namespace tkivelip\LaravelFlexProperties;

use Illuminate\Database\Eloquent\Model as BaseModel;
use mindtwo\LaravelDynamicModelMutators\DynamicModelMutator;
use tkivelip\LaravelFlexProperties\Interfaces\FlexProperties;
use tkivelip\LaravelFlexProperties\Traits\HasFlexProperties;

class Model extends BaseModel implements FlexProperties
{
    use DynamicModelMutator,
        HasFlexProperties;
}