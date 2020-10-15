<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-vtung
 * Company: Stimolive Technologies Limited
 * Class Name: VtuDotNGErrorException.php
 * Date Created: 9/27/20
 * Time Created: 7:24 PM
 */

namespace HenryEjemuta\LaravelVtuDotNG\Exceptions;


class VtuDotNGErrorException extends \Exception
{
    /**
     * VtuDotNGErrorException constructor.
     * @param string $message
     * @param $code
     */
    public function __construct(string $message, $code)
    {
        parent::__construct($message, $code);
    }
}
