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

class CableTvEnum
{
    private static $cache = [];
    private static $tvs = [
        'dstv' => 'DStv',
        'gotv' => 'GOtv',
        'startimes' => 'Startimes',
    ];

    private $code, $name;

    private function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return ucfirst($this->name);
    }

    public function toArray(): array
    {
        return ['code' => $this->getCode(), 'name' => $this->getName()];
    }

    /**
     * @param $code
     * @return CableTvEnum|null
     * @throws VtuDotNGErrorException
     */
    public static function getCableTv($code): ?CableTvEnum
    {
        $cleanedName = strtolower(trim($code));
        if (!key_exists($cleanedName, self::$tvs))
            throw new VtuDotNGErrorException("No Cable TV available with the code '$code'", 404);
        if (!key_exists($cleanedName, self::$cache))
            self::$cache[$cleanedName] = new CableTvEnum($cleanedName, self::$tvs[$cleanedName]);
        return self::$cache[$cleanedName];
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
