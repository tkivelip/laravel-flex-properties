<?php

namespace tkivelip\LaravelFlexProperties;

use Illuminate\Database\Eloquent\Model;
use mindtwo\LaravelDynamicModelMutators\DynamicModelMutator;
use tkivelip\LaravelFlexProperties\Interfaces\FlexProperties;
use tkivelip\LaravelFlexProperties\Traits\HasFlexProperties;

class FlexModel extends Model implements FlexProperties
{
    use DynamicModelMutator,
        HasFlexProperties;
}