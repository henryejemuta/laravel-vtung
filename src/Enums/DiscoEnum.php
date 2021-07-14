<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-clubkonnect
 * Company: Stimolive Technologies Limited
 * Class Name: NetworkEnum.php
 * Date Created: 5/14/21
 * Time Created: 10:47 AM
 */

namespace HenryEjemuta\LaravelVtuDotNG\Enums;


use HenryEjemuta\LaravelVtuDotNG\Exceptions\VtuDotNGErrorException;

/**
 * Class DiscoEnum
 * The discos unique service_id is used to make each electricity company unique. They are as follows:
 * Ikaja Electricity = <strong>ikeja-electric</strong>
 * Eko Electricity = <strong>eko-electric</strong>
 * Kano Electricity = <strong>kano-electric</strong>
 * Kaduna Electricity = <strong>Kaduna-electric</strong>
 * Port Harcourt Electricity = <strong>phed</strong>
 * Jos Electricity = <strong>jos-electric</strong>
 * Abuja Electricity = <strong>abuja-electric</strong>
 * Ibadan Electricity = <strong>ibadan-electric</strong>
 * @package HenryEjemuta\LaravelVtuDotNG\Enums
 */
class DiscoEnum
{
    private static $cache = [];
    private static $discos = [
        'ekedc' => ['code' => 'eko-electric', 'name' => 'Eko Electric - EKEDC'],
        'ikedc' => ['code' => 'ikeja-electric', 'name' => 'Ikeja Electric - IKEDC'],
        'aedc' => ['code' => 'abuja-electric', 'name' => 'Abuja Electric - AEDC'],
        'kedco' => ['code' => 'kano-electric', 'name' => 'Kano Electric - KEDCO'],
        'phed' => ['code' => 'portharcout-electric', 'name' => 'Porthacourt Electric - PHED'],
        'jed' => ['code' => 'jos-electric', 'name' => 'Jos Electric - JED'],
        'ibedc' => ['code' => 'ibadan-electric', 'name' => 'Ibadan Electric - IBEDC'],
        'kaedco' => ['code' => 'kaduna-electric', 'name' => 'Kaduna Elecdtric - KAEDCO'],
    ];

    private $disco;
    private $uid;

    private function __construct(string $uid, array $disco)
    {
        $this->uid = $uid;
        $this->disco = (object)$disco;
    }

    public function getUID(): string
    {
        return $this->disco->uid;
    }

    public function getCode(): string
    {
        return $this->disco->code;
    }

    public function getName(): string
    {
        return $this->disco->name;
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->getUID(),
            'code' => $this->getCode(),
            'name' => $this->getName()
        ];
    }

    /**
     * @param $uid
     * @return DiscoEnum|null
     * @throws VtuDotNGErrorException
     */
    public static function getByUID($uid): ?DiscoEnum
    {
        $uid = trim("$uid");
        if (!key_exists($uid, self::$discos))
            throw new VtuDotNGErrorException("Not a valid VTU.NG Disco", 999);
        if (!key_exists($uid, self::$cache))
            self::$cache[$uid] = new DiscoEnum($uid, self::$discos[$uid]);
        return self::$cache[$uid];
    }

    /**
     * @param $code
     * @return DiscoEnum|null
     * @throws VtuDotNGErrorException
     */
    public static function getByCode($code): ?DiscoEnum
    {
        $code = trim($code);
        if (!key_exists($code, self::$cache)) {
            $found = false;
            foreach (self::$discos as $idx => $disco) {
                if ($disco['code'] == $code) {
                    self::$cache[$code] = new DiscoEnum($idx, $disco);
                    $found = true;
                }
            }
            if (!$found) {
                throw new VtuDotNGErrorException("Not a valid VTU.NG Disco", 999);
            }
        }
        return self::$cache[$code];
    }

    public function __toString(): string
    {
        return print_r($this->toArray(), true);
    }
}
