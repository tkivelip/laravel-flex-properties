<?php

namespace tkivelip\LaravelFlexProperties\Types;

use tkivelip\LaravelFlexProperties\Exceptions\InvalidFlexPropertyValueException;
use tkivelip\LaravelFlexProperties\FlexProperty;

class TextFlexProperty extends FlexProperty
{
    public function setValueAttribute($value)
    {
        if (!is_string($value)) {
            throw new InvalidFlexPropertyValueException('$value must be a string');
        }

        $this->attributes['value'] = $value;
    }
}
