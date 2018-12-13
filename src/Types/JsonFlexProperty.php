<?php

namespace tkivelip\LaravelFlexProperties\Types;

use tkivelip\LaravelFlexProperties\FlexProperty;

class JsonFlexProperty extends FlexProperty
{
    protected $table = 'text_flex_properties';

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? json_encode($value) : $value;
    }
}
