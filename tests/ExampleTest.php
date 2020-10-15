<?php

namespace Henryejemuta\LaravelVtung\Tests;

use Orchestra\Testbench\TestCase;
use Henryejemuta\LaravelVtung\LaravelVtungServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelVtungServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
