<?php

namespace tkivelip\LaravelFlexProperties\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use tkivelip\LaravelFlexProperties\Flex;
use tkivelip\LaravelFlexProperties\Tests\TestCase;
use tkivelip\LaravelFlexProperties\Types\JsonFlexProperty;
use tkivelip\LaravelFlexProperties\Types\StringFlexProperty;
use tkivelip\LaravelFlexProperties\Types\TextFlexProperty;

class FlexTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('flex-properties.types', [
            'string' => StringFlexProperty::class,
            'text'   => TextFlexProperty::class,
            'json'   => JsonFlexProperty::class,
        ]);
    }

    /**
     * Get flex property types test.
     *
     * @test
     */
    public function testGetFlexPropertyTypes()
    {
        $types = Flex::types();

        $this->assertArrayHasKey('string', $types);
        $this->assertArrayHasKey('text', $types);
        $this->assertArrayHasKey('json', $types);
        $this->assertContains(StringFlexProperty::class, $types);
        $this->assertContains(TextFlexProperty::class, $types);
        $this->assertContains(JsonFlexProperty::class, $types);
    }

    /**
     * Flex property type exists test.
     *
     * @test
     */
    public function testFlexPropertyTypeExists()
    {
        $this->assertTrue(Flex::typeExists('string'));
        $this->assertTrue(Flex::typeExists('text'));
        $this->assertTrue(Flex::typeExists('json'));
        $this->assertFalse(Flex::typeExists('unkown'));
    }

    /**
     * Flex property factory test.
     *
     * @test
     */
    public function testFlexPropertyFactory()
    {
        $string = Flex::factory('string', ['name'=>'string_property', 'locale'=>'de']);
        $text = Flex::factory('text', ['name'=>'text_property', 'locale'=>'de']);

        $this->assertInstanceOf(StringFlexProperty::class, $string);
        $this->assertEquals('string_property', $string->name);
        $this->assertEquals('de', $string->locale);

        $this->assertInstanceOf(TextFlexProperty::class, $text);
        $this->assertEquals('text_property', $text->name);
        $this->assertEquals('de', $text->locale);
    }
}