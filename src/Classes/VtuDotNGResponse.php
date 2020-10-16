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

    const STATUS_CODE = [
        "success" => 200,
        "201" => '201 Created',
        "203" => '203 Non-Authoritative Information',
        "204" => '204 No Content',
        "301" => '301 Moved Permanently',
        "307" => '307 Temporary Redirect',
        "308" => '308 Permanent Redirect',
        "400" => '400 Bad Request',
        "401" => '401 Unauthorized',
        "402" => '402 Payment Required',
        "403" => '403 Forbidden',
        "404" => '404 Not Found',
        "408" => '408 Request Timeout',
        "413" => '413 Payload Too Large',
        "414" => '414 URI Too Long',
        "422" => '422 Unprocessable Entity',
        "500" => '500 Internal Server Error',
        "502" => '502 Bad Gateway',
        "503" => '503 Service Unavailable',
        "504" => '504 Gateway Timeout',
        "505" => '505 HTTP Version Not Supported',
    ];


    /**
     * VtuDotNGResponse constructor.
     * @param string $code
     * @param string $message
     * @param object|array|null $responseBody
     * @throws VtuDotNGErrorException
     */
    public function __construct(string $code = 'failure', $message = 'Unable to reach VTU.ng Server', $responseBody = null)
    {
        $this->body = $responseBody;
        $this->code = strtolower("$code");
        $this->message = $message;
        $this->hasError = ($this->code != "success");

        if ($this->hasError)
            throw new VtuDotNGErrorException($message, ($this->code == "success") ? 200 : 422);

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
