# Laravel VTU.ng

[![Build Status](https://travis-ci.org/henryejemuta/laravel-vtung.svg?branch=master)](https://travis-ci.org/henryejemuta/laravel-vtung)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/henryejemuta/laravel-vtung.svg?style=flat-square)](https://packagist.org/packages/henryejemuta/laravel-vtung)
[![Latest Stable Version](https://poser.pugx.org/henryejemuta/laravel-vtung/v/stable)](https://packagist.org/packages/henryejemuta/laravel-vtung)
[![Total Downloads](https://poser.pugx.org/henryejemuta/laravel-vtung/downloads)](https://packagist.org/packages/henryejemuta/laravel-vtung)
[![License](https://poser.pugx.org/henryejemuta/laravel-vtung/license)](https://packagist.org/packages/henryejemuta/laravel-vtung)
[![Quality Score](https://img.shields.io/scrutinizer/g/henryejemuta/laravel-vtung.svg?style=flat-square)](https://scrutinizer-ci.com/g/henryejemuta/laravel-vtung)

## What is VTU.ng
The VTU.ng API is an HTTPs GET API that allows you to integrate all virtual top-up and bills payment services available on our platform with your application (websites, desktop apps & mobile apps). You can also start your own VTU business by integrating our VTU API and resell our services in Nigeria.

## What is Laravel VTU.ng
Laravel VTU.ng is a laravel package to seamlessly integrate VTU.ng api within your laravel application.

Create a VTU.ng Account [Sign Up](http://bit.ly/3nTkLh4).

Look up VTU.ng API Documentation [API Documentation](https://vtu.ng/api/).

## Installation

You can install the package via composer:

```bash
composer require henryejemuta/laravel-vtung
```

Publish VTU.ng configuration file, migrations as well as set default details in .env file:

```bash
php artisan vtung:init
```

## Usage

## Usage

The Laravel VTU.ng Package is quite easy to use via the VtuDontNG facade
``` php
use HenryEjemuta\LaravelVtuDotNG\Facades\VtuDotNG;
use HenryEjemuta\LaravelVtuDotNG\Classes\VtuDotNGResponse;

...
//To buy Airtime
try{
    $response = VtuDotNG::purchaseAirtime('mtn', '1500', '08134567890');
}catch(VtuDotNGErrorException $ex){
    Log::error("Error while purchasing airtime\n\r" . $exception->getCode() . ": " . $exception->getMessage());
}
...

```

Find an overview of all method with comment on what they do and expected arguments
``` php


    /**
     * Get Your wallet available balance, Wallet is identified by username set in vtung config or environmental variable
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function getWalletBalance(): VtuDotNGResponse

    /**
     * Purchase Airtime with py specifying the network (i.e. mtn, glo, airtel, or 9mobile to buy airtime corresponding the provided telco service code)
     * @param string $network The network_id is used to make each network unique. They include mtn, glo, airtel and etisalat. Notice that they are all in small letters.
     * @param int $amount The amount you wish to topup
     * @param string $phoneNumber The phone number that will receive the airtime
     * @return VtuDotNGResponse
     *
     * @throws VtuDotNGErrorException
     */
    public function purchaseAirtime(string $network, int $amount, $phoneNumber): VtuDotNGResponse


    /**
     * Purchase Data Bundle
     * @param string $network The network_id is used to make each network unique. They include mtn, glo, airtel and etisalat. Notice that they are all in small letters.
     * @param string $plan The variation ID of the data plan you want to purchase.
     * @param string $phone The phone number that will receive the data
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function purchaseDataBundle(string $network, string $plan, string $phone): VtuDotNGResponse

    /**
     * Verify Customer Smart Card Number/IUC/Decoder Number verification
     * You need to verify your customer unique number before purchasing.
     *
     * @param string $cableTvType The $cableTvType is used to make each cable TV unique. They include dstv, gotv, and startimes. Notice that they are all in small letters.
     * @param string $smartCardNumber The smartcard/IUC number of the decoder that should be subscribed
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function verifyCableSmartCardNumber(string $cableTvType, string $smartCardNumber): VtuDotNGResponse

    /**
     * Purchase DSTV or GoTv Cable Tv Plan
     *
     *
     * @param string $cableTvType The $cableTvType is used to make each cable TV unique. They include dstv, gotv, and startimes. Notice that they are all in small letters.
     * @param string $smartCardNumber The smartcard/IUC number of the decoder that should be subscribed
     * @param string $plan The $plan ID of the cable TV package/bouquet you want to purchase. They are as follows:
     *
     *    dstv-padi = DStv Padi
     *    dstv-yanga = DStv Yanga
     *    dstv-confam = DStv Confam
     *    dstv6 = DStv Asian
     *    dstv79 = DStv Compact
     *    dstv7 = DStv Compact Plus
     *    dstv3 = DStv Premium
     *    dstv10 = DStv Premium Asia
     *    gotv-smallie = GOtv Smallie
     *    gotv-jinja = GOtv Jinja
     *    gotv-jolli = GOtv Jolli
     *    gotv-max = GOtv Max
     *    nova = Startimes Nova
     *    basic = Startimes Basic
     *    smart = Startimes Smart
     *    classic = Startimes Classic
     *    super = Startimes Super
     *
     * @param string $customerPhoneNumber The phone number that will be stored for reference
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function purchaseCableTvPlan(string $cableTvType, string $smartCardNumber, string $plan, string $customerPhoneNumber): VtuDotNGResponse

    /**
     * We advise that you always verify the customer’s details before submitting requests to purchase the service (cable TV or electricity). The VTU.ng customer verification endpoint allows you to get the customer’s full name.
     *
     * Please note the service_id below:
     * Ikaja Electricity = <strong>ikeja-electric</strong>
     * Eko Electricity = <strong>eko-electric</strong>
     * Kano Electricity = <strong>kano-electric</strong>
     * Kaduna Electricity = <strong>Kaduna-electric</strong>
     * Port Harcourt Electricity = <strong>phed</strong>
     * Jos Electricity = <strong>jos-electric</strong>
     * Abuja Electricity = <strong>abuja-electric</strong>
     * Ibadan Electricity = <strong>ibadan-electric</strong>
     *
     *
     * @param string $disco The service_id is unique for all cable TV and electricity services.
     * @param string $meterNumber Meter Number to verify
     * @param string $meterType Meter type i.e. <strong>prepaid</strong> or <strong>postpaid</strong>
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function verifyMeterNumber(string $disco, string $meterNumber, string $meterType): VtuDotNGResponse

    /**
     * Purchase Electricity
     * You can purchase electricity through our API and get instant token for prepaid meters.
     *
     * @param string $disco Unique code of the Electricity distribution company the meter number is for
     * The discos unique service_id is used to make each electricity company unique. They are as follows:
     * Ikaja Electricity = <strong>ikeja-electric</strong>
     * Eko Electricity = <strong>eko-electric</strong>
     * Kano Electricity = <strong>kano-electric</strong>
     * Kaduna Electricity = <strong>Kaduna-electric</strong>
     * Port Harcourt Electricity = <strong>phed</strong>
     * Jos Electricity = <strong>jos-electric</strong>
     * Abuja Electricity = <strong>abuja-electric</strong>
     * Ibadan Electricity = <strong>ibadan-electric</strong>
     *
     * @param string $meterNumber The meter number you want to purchase electricity for
     * @param string $meterType The meter type of electricity company you want to purchase. It is either prepaid or postpaid
     * @param int $amount The meter type of electricity company you want to purchase. It is either prepaid or postpaid
     * @param string $customerPhoneNumber The phone number that will be stored for reference
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function purchaseElectricity(string $disco, string $meterNumber, string $meterType, $amount, string $customerPhoneNumber): VtuDotNGResponse

```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email henry.ejemuta@gmail.com instead of using the issue tracker.

## Credits

- [Henry Ejemuta](https://github.com/henryejemuta)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
