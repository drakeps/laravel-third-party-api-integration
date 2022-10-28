<?php

namespace App\Services\GitHub\Exceptions;

/**
 * Ошибка авторизации
 */
class UnauthorizedException extends GitHubApiException
{
    public const HTTP_CODE = 401;

    protected $responseBody;

    public function __construct($responseBody = null)
    {
        $message   = 'UnauthorizedException';

        parent::__construct($message, self::HTTP_CODE);
    }
}