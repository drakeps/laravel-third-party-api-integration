<?php

declare(strict_types=1);

namespace App\Services\GitHub\Exceptions;

class GitHubApiException extends \Exception
{
    /**
     * @var mixed
     */
    protected $responseBody;

    /**
     * @param string $message Error message
     * @param int $code HTTP status code
     * @param mixed $responseBody HTTP body
     */
    public function __construct($message = "", $code = 0, $responseBody = null)
    {
        parent::__construct($message, $code);

        $this->responseBody = $responseBody;
    }

    /**
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }
}
