<?php

namespace tkivelip\LaravelFlexProperties;

use Illuminate\Database\Eloquent\Model;
use tkivelip\LaravelFlexProperties\Exceptions\FlexPropertyException;
use tkivelip\LaravelFlexProperties\Types\ArrayFlexProperty;
use tkivelip\LaravelFlexProperties\Types\JsonFlexProperty;
use tkivelip\LaravelFlexProperties\Types\StringFlexProperty;
use tkivelip\LaravelFlexProperties\Types\TextFlexProperty;

class FlexProperty extends Model
{
    protected static $types = [
        'string' => StringFlexProperty::class,
        'text'   => TextFlexProperty::class,
        'json'   => JsonFlexProperty::class,
        'array'  => ArrayFlexProperty::class,
    ];

    protected $fillable = [
        'name',
        'locale',
        'value',
    ];

    public function linkable()
    {
        return $this->morphTo();
    }

    /**
     * Compose FlexProperty class name by type.
     *
     * @param string $type
     *
     * @return string
     * @throws FlexPropertyException
     */
    public static function getClass(string $type): string
    {
        $type = static::typeOrFail($type);

        return self::$types[$type];
    }

    /**
     * Determinate if type exists.
     *
     * @param string $type
     *
     * @return bool
     */
    public static function typeExists(string $type): bool
    {
        return array_key_exists($type, self::$types);
    }

    /**
     * Determinate if type exists and throw an exception if not.
     *
     * @param string $type
     *
     * @throws FlexPropertyException
     *
     * @return string
     */
    public static function typeOrFail(string $type): string
    {
        if (!self::typeExists($type)) {
            throw new FlexPropertyException('Flex property type "' . $type . '" is invalid');
        }
        return $type;
    }

    public static function make(array $attributes=[], string $type=null)
    {
        $class = static::getClass($type);

        return new $class($attributes);
    }
}