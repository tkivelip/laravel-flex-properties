<?php

namespace tkivelip\LaravelFlexProperties\Types;

class ArrayFlexProperty extends JsonFlexProperty
{
    protected $table = 'text_flex_properties';

    /**
     * Get value.
     *
     * @param string $value
     *
     * @return array
     */
    public function getValueAttribute($value)
    {
        return json_decode($value);
    }
}
