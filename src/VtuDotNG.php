<?php

namespace HenryEjemuta\LaravelVtuDotNG;

use HenryEjemuta\LaravelVtuDotNG\Classes\VtuDotNGResponse;
use HenryEjemuta\LaravelVtuDotNG\Exceptions\VtuDotNGErrorException;
use Illuminate\Support\Facades\Http;

class VtuDotNG
{
    /**
     * base url
     *
     * @var string
     */
    private $baseUrl;

    /**
     * the cart session key
     *
     * @var string
     */
    protected $instanceName;

    /**
     * Flexible handle to the VTPass Configuration
     *
     * @var
     */
    protected $config;

    public function __construct($baseUrl, $instanceName, $config)
    {
        $this->baseUrl = $baseUrl;
        $this->instanceName = $instanceName;
        $this->config = $config;
    }

    /**
     * get instance name of the cart
     *
     * @return string
     */
    public function getInstanceName()
    {
        return $this->instanceName;
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    private function withAuth(string $endpoint, array $params = []): VtuDotNGResponse
    {
        $params['username'] = $this->config['username'];
        $params['password'] = urldecode($this->config['password']);
        $response = Http::get("{$this->baseUrl}$endpoint", $params);

        $responseObject = json_decode($response->body());
        if (isset($responseObject->code) && isset($responseObject->message))
            return new VtuDotNGResponse($responseObject->code, $responseObject->message, isset($responseObject->data) ? $responseObject->data : null);
        return new VtuDotNGResponse();
    }

    /**
     * Get Your wallet available balance, Wallet is identified by username set in vtung config or environmental variable
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function getWalletBalance(): VtuDotNGResponse
    {
        return $this->withAuth('balance');
    }

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
    {
        return $this->withAuth('airtime', [
            'network_id' => $network,
            'amount' => $amount,
            'phone_number' => $phoneNumber
        ]);
    }


    /**
     * Purchase Data Bundle
     * @param string $network The network_id is used to make each network unique. They include mtn, glo, airtel and etisalat. Notice that they are all in small letters.
     * @param string $plan The variation ID of the data plan you want to purchase.
     * @param string $phone The phone number that will receive the data
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    public function purchaseDataBundle(string $network, string $plan, string $phone): VtuDotNGResponse
    {
        return $this->withAuth('data', [
            'network_id' => $network,
            'variation_id' => $plan,
            'phone' => $phone
        ]);
    }


    /**
     * We advise that you always verify the customer’s details before submitting requests to purchase the service (cable TV or electricity). The VTU.ng customer verification endpoint allows you to get the customer’s full name.
     * @param string $customerId This is either the customer’s smartcard number or the meter number
     * @param string $serviceId The service_id is unique for all cable TV and electricity services. They include dstv, gotv, startimes, abuja-electric, eko-electric, ibadan-electric, ikeja-electric, jos-electric, kaduna-electric, kano-electric and portharcout-electric. Notice that they are all in small letters.
     * @param string|null $variationId The meter type of the electricity company. This is only required for verifying the electricity customers and not required for cable TV customer verification.
     * @return VtuDotNGResponse
     * @throws VtuDotNGErrorException
     */
    private function verifyCustomer(string $customerId, string $serviceId, string $variationId = null): VtuDotNGResponse
    {
        $params = [
            'customer_id' => $customerId,
            'service_id' => $serviceId,
        ];
        if (!is_null($variationId))
            $params['variation_id'] = $variationId;
        return $this->withAuth('verify-customer', $params);
    }


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
    {
        return $this->verifyCustomer($smartCardNumber, $cableTvType);
    }

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
    {
        return $this->withAuth('tv', [
            "service_id" => $cableTvType,
            "smartcard_number" => $smartCardNumber,
            "variation_id" => $plan,
            "phone" => $customerPhoneNumber,
        ]);
    }

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
    {
        return $this->verifyCustomer($meterNumber, $disco, $meterType);
    }

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
    {
        return $this->withAuth('electricity', [
            "service_id" => $disco,
            "meter_number" => $meterNumber,
            "variation_id" => $meterType,
            "amount" => $amount,
            "phone" => $customerPhoneNumber,
        ]);
    }
}
