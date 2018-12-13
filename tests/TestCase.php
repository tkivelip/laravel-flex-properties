<?php

namespace tkivelip\LaravelFlexProperties\Tests;

use tkivelip\LaravelFlexProperties\Providers\FlexPropertyServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [FlexPropertyServiceProvider::class];
    }
}