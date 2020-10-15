<?php

namespace HenryEjemuta\LaravelVtuDotNG\Facades;

use HenryEjemuta\LaravelVtuDotNG\Classes\VtuDotNGResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static VtuDotNGResponse getWalletBalance()
 * @method static VtuDotNGResponse purchaseAirtime(string $network, int $amount, $phoneNumber)
 * @method static VtuDotNGResponse purchaseDataBundle(string $network, string $plan, string $phone)
 * @method static VtuDotNGResponse verifyCableSmartCardNumber(string $cableTvType, string $smartCardNumber)
 * @method static VtuDotNGResponse purchaseCableTvPlan(string $cableTvType, string $smartCardNumber, string $plan, string $customerPhoneNumber)
 * @method static VtuDotNGResponse verifyMeterNumber(string $disco, string $meterNumber, string $meterType)
 * @method static VtuDotNGResponse purchaseElectricity(string $disco, string $meterNumber, string $meterType, $amount, string $customerPhoneNumber)
 *
 * For respective method implementation:
 * @see \HenryEjemuta\LaravelVtuDotNG\VtuDotNG
 */
class VtuDotNG extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'vtung';
    }
}
