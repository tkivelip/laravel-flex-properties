<?php

namespace tkivelip\LaravelFlexProperties\Types;

use tkivelip\LaravelFlexProperties\Exceptions\InvalidFlexPropertyValueException;
use tkivelip\LaravelFlexProperties\FlexProperty;

class StringFlexProperty extends FlexProperty
{
    const MAX_LENGTH = 100;

    public function setValueAttribute($value)
    {
        if (!is_string($value)) {
            throw new InvalidFlexPropertyValueException('$value must be a string');
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw new InvalidFlexPropertyValueException('$value must be less than ' . self::MAX_LENGTH . ' charachters');
        }

        $this->attributes['value'] = $value;
    }
}