<?php

namespace App\Services\GitHub\Exceptions;

/**
 * Неправильный запрос.
 */
class BadApiRequestException extends GitHubApiException
{
    public const HTTP_CODE = 400;

    protected $responseBody;

    public function __construct($responseBody = null)
    {
        $message = 'Неправильный запрос к API. ';

        parent::__construct($message, self::HTTP_CODE, $responseBody);
    }
}