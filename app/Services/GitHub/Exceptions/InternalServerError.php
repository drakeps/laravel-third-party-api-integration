<?php

namespace App\Services\GitHub\Exceptions;

/**
 * Технические неполадки на стороне api. Результат обработки запроса неизвестен.
 */
class InternalServerError extends GitHubApiException
{
    public const HTTP_CODE = 500;

    protected $responseBody;

    public function __construct($responseBody = null)
    {
        $message   = 'InternalServerError';

        parent::__construct($message, self::HTTP_CODE);
    }
}