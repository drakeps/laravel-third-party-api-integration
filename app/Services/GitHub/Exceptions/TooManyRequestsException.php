<?php

namespace App\Services\GitHub\Exceptions;

/**
 * Превышен лимит запросов.
 */
class TooManyRequestsException extends GitHubApiException
{
    public const HTTP_CODE = 429;

    protected $responseBody;

    public function __construct($responseBody = null)
    {
        $message   = 'TooManyRequestsException';

        parent::__construct($message, self::HTTP_CODE);
    }
}