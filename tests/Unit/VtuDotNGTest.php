<?php

namespace HenryEjemuta\LaravelVtuDotNG\Tests\Unit;

use HenryEjemuta\LaravelVtuDotNG\Classes\VtuDotNGResponse;
use HenryEjemuta\LaravelVtuDotNG\Facades\VtuDotNG;
use HenryEjemuta\LaravelVtuDotNG\VtuDotNGServiceProvider;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Http;

class VtuDotNGTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [VtuDotNGServiceProvider::class];
    }

    /** @test */
    public function it_can_purchase_airtime()
    {
        Http::fake([
            '*' => Http::response([
                'code' => 'success',
                'message' => 'Airtime successful',
                'data' => []
            ], 200),
        ]);

        $response = VtuDotNG::purchaseAirtime('mtn', 100, '08134567890');

        $this->assertInstanceOf(VtuDotNGResponse::class, $response);
        $this->assertTrue($response->successful());
    }
}
