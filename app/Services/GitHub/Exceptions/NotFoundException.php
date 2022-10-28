<?php

namespace App\Services\GitHub\Exceptions;

/**
 * Не найдено.
 */
class NotFoundException extends GitHubApiException
{
    public const HTTP_CODE = 404;

    protected $responseBody;

    public function __construct($responseBody = null)
    {
        $message   = 'NotFoundException';

        parent::__construct($message, self::HTTP_CODE);
    }
}