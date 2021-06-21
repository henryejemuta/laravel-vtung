<?php
/**
 * Created By: Henry Ejemuta
 * PC: Enrico Systems
 * Project: laravel-vtung
 * Company: Stimolive Technologies Limited
 * Class Name: VtuDotNGResponse.php
 * Date Created: 9/27/20
 * Time Created: 6:00 PM
 */

namespace HenryEjemuta\LaravelVtuDotNG\Classes;


use HenryEjemuta\LaravelVtuDotNG\Exceptions\VtuDotNGErrorException;

class VtuDotNGResponse
{
    private $message;

    /**
     * @var bool
     */
    private $hasError;

    /**
     * @var string
     */
    private $code;

    /**
     * Response Body from
     * @var object|null $body
     */
    private $body;


    /**
     * VtuDotNGResponse constructor.
     * @param string $code
     * @param string $message
     * @param object|array|null $responseBody
     * @throws VtuDotNGErrorException
     */
    public function __construct(string $code = 'failed', $message = 'Unable to reach VTU.ng Server', $responseBody = null)
    {
        if($message == 'Your account is not activated for API access. Kindly upgrade to a Reseller Account to access our API'){
            $code = "upgrade";
        }
        $this->body = $responseBody;
        $this->code = strtolower("$code");
        $this->message = $message;
        $this->hasError = !in_array($this->code, ["success", "failure"]);

        if ($this->hasError) {
            $statusCode = (($this->code == "failed") ? 503 : (($this->code == "upgrade") ? 401 : 422));
            throw new VtuDotNGErrorException($message, $statusCode);
        }

    }

    /**
     * Determine if this ise a success response object
     * @return bool
     */
    public function successful(): bool
    {
        return !($this->hasError);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return object|array|null
     */
    public function getBody()
    {
        return $this->body;
    }

    public function __toString()
    {
        return json_encode($this->body);
    }

}
