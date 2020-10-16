<?php

namespace HenryEjemuta\LaravelVtuDotNG\Tests;

use HenryEjemuta\LaravelVtuDotNG\VtuDotNGServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [VtuDotNGServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
