<?php

namespace tkivelip\LaravelFlexProperties\Traits;

use tkivelip\LaravelFlexProperties\Exceptions\FlexPropertyException;
use tkivelip\LaravelFlexProperties\FlexProperty;

trait HasFlexProperties
{
    /**
     * Locale settings
     *
     * @see bootHasFlexProperties()
     *
     * @var array
     */
    protected static $locale = [
        'current'  => 'en',
        'default'  => 'en',
        'fallback' => 'en'
    ];

    /**
     * Flex property objects.
     *
     * @var array
     */
    protected $flex_objects = [];

    /**
     * Boot trait.
     */
    public static function bootHasFlexProperties()
    {
        // Register mutators
        static::registerSetMutator('flex_properties', 'setFlexPropertyValue');
        static::registerGetMutator('flex_properties', 'getFlexPropertyValue');

        // Locale settings
        static::$locale = [
            'current'  => config('app.locale'),
            'default'  => config('app.locale'),
            'fallback' => config('app.fallback_locale')
        ];

        // Register event to store flex properties
        static::saved(function($model) {
            $model->storeFlexProperties();
        });
    }

    /**
     * Determine if a FlexProperty is defined
     *
     * @param string $name
     *
     * @return bool
     */
    protected function hasFlexProperty(string $name): bool
    {
        return array_key_exists($name, $this->flex_properties);
    }

    /**
     * Determine if a FlexProperty is defined and throw an exception if not
     *
     * @param string $name
     *
     * @throws FlexPropertyException
     *
     * @return bool
     */
    protected function hasFlexPropertyOrFail(string $name): bool
    {
        if (!$this->hasFlexProperty($name)) {
            throw new FlexPropertyException(sprintf('FlexProperty "%s" is not defined', $name));
        }

        return true;
    }

    /**
     * Get FlexProperty type.
     *
     * @param string $name
     *
     * @throws FlexPropertyException
     *
     * @return string
     */
    protected function getFlexPropertyType(string $name): string
    {
        $this->hasFlexPropertyOrFail($name);

        return FlexProperty::typeOrFail($this->flex_properties[$name]);
    }

    /**
     * Return a reference to a flex property object
     *
     * @param string $name
     * @param string|null $locale
     *
     * @return mixed
     */
    protected function &getFlexProperty(string $name, string $locale=null)
    {
        return $this->flex_objects[$locale ?? $this->currentLocale()][$name];
    }

    /**
     * Get FlexProperty value.
     *
     * @param string $name
     *
     * @throws FlexPropertyException
     *
     * @return mixed
     */
    public function getFlexPropertyValue(string $name, $type)
    {
        $this->hasFlexPropertyOrFail($name);

        if (! $this->getFlexProperty($name) && $property = $this->getFlexPropertyFromDb($name)) {
            $this->flex_objects[$this->currentLocale()][$name] = $property;
        }

        return optional($this->getFlexProperty($name))->value;
    }

    /**
     * Get flex property value from database
     * @param string $name
     * @param string|null $locale
     *
     * @throws FlexPropertyException
     *
     * @return FlexProperty
     */
    protected function getFlexPropertyFromDb(string $name, string $locale=null)
    {
        return FlexProperty::make([], $this->getFlexPropertyType($name))
            ->where('linkable_type', static::class)
            ->where('linkable_id', $this->{'id'})
            ->where('name', $name)
            ->where('locale', $locale ?? $this->currentLocale())
            ->first();
    }

    /**
     * Set FlexProperty value.
     *
     * @param string $name
     * @param $value
     *
     * @throws FlexPropertyException
     *
     * @return HasFlexProperties
     */
    public function setFlexPropertyValue(string $name, $values=null): self
    {
        $this->hasFlexPropertyOrFail($name);

        if ($this->currentLocale()) {
            $values = [$this->currentLocale() => $values];
        }

        foreach ($values as $locale=>$value) {
            if (! $this->getFlexProperty($name, $locale)) {
                $this->flex_objects[$locale][$name] = $this->makeFlexProperty($name, $locale);
            }
            $this->getFlexProperty($name, $locale)->value = $value;
        }

        return $this;
    }

    /**
     * Make flex property object
     *
     * @param null $name
     * @param null $locale
     * @param array $attributes
     *
     * @throws FlexPropertyException
     *
     * @return FlexProperty
     */
    protected function makeFlexProperty($name=null, $locale=null, $attributes=[])
    {
        $attributes = array_merge(
            $attributes,
            ['name' => $name, 'locale' => $locale ? $locale : $this->currentLocale()]
        );

        return FlexProperty::make($attributes, $this->getFlexPropertyType($name));
    }

    /**
     * Set the current locale
     *
     * @param string|null $locale
     *
     * @return $this
     */
    public function locale(string $locale=null): self
    {
        static::$current_locale = $locale;

        return $this;
    }

    /**
     * Return the current flex property locale
     *
     * @return string
     */
    protected function currentLocale(): ?string
    {
        return static::$locale['current'];
    }

    /**
     * Store all flex property values.
     *
     * @see bootHasFlexProperties
     *
     * @return $this
     */
    public function storeFlexProperties(): self
    {
        collect($this->flex_objects)->flatten()->each(function($property) {
            $property->forceFill([
                'linkable_type' => static::class,
                'linkable_id'   => $this->{'id'},
            ])->save();
        });

        return $this;
    }

    /**
     * Load all FlexProperty values from persistence.
     *
     * @see bootHasFlexProperties
     *
     * @return $this
     */
    public function loadFlexProperties()
    {
        collect($this->flex_properties)->flip()->map(function ($value, $type) {
                return FlexProperty::make([], $type)
                    ->where('linkable_id', $this->{'id'})
                    ->where('linkable_type', static::class)
                    ->get();
            })
            ->filter()
            ->flatten()
            ->each(function ($property) {
                $this->flex_objects[$property->locale][$property->name] = $property;
            });

        return $this;
    }
}