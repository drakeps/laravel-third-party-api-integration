<?php

declare(strict_types=1);

namespace App\Services\GitHub;

use App\Services\Concerns\CanBeFaked;
use App\Services\GitHub\Exceptions\BadApiRequestException;
use App\Services\GitHub\Exceptions\ConnectionException;
use App\Services\GitHub\Exceptions\GitHubApiException;
use App\Services\GitHub\Exceptions\InternalServerError;
use App\Services\GitHub\Exceptions\NotFoundException;
use App\Services\GitHub\Exceptions\TooManyRequestsException;
use App\Services\GitHub\Exceptions\UnauthorizedException;
use App\Services\GitHub\Resources\ReleaseResource;
use App\Services\GitHub\Resources\RepositoryResource;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class GitHubService
{
    use CanBeFaked;

    public function __construct(
        public readonly string $baseUri,
        public readonly string $key,
        public readonly int $timeout,
        public readonly null|int $retryTimes = null,
        public readonly null|int $retrySleep = null,
    ) {}

    public function makeRequest(): PendingRequest
    {
        $request = Http::baseUrl(
            url: $this->baseUri,
        )->timeout(
            seconds: $this->timeout,
        );

        if (! is_null($this->retryTimes) && ! is_null($this->retrySleep)) {
            $request->retry(
                times: $this->retryTimes,
                sleep: $this->retrySleep,
            );
        }

        return $request;
    }

    public function repositories(): RepositoryResource
    {
        return new RepositoryResource(
            service: $this,
        );
    }

    public function releases(): ReleaseResource
    {
        return new ReleaseResource(
            service: $this,
        );
    }

    /**
     * Выбрасывает исключение по коду ошибки
     *
     * @param $response
     */
    public function handleError(\Illuminate\Http\Client\Response $response)
    {
        switch ($response->status()) {
            case 0:
                throw new ConnectionException($response->error, $response->body());
            case UnauthorizedException::HTTP_CODE:
                throw new UnauthorizedException($response->body());
            case InternalServerError::HTTP_CODE:
                throw new InternalServerError($response->body());
            case BadApiRequestException::HTTP_CODE:
                throw new BadApiRequestException($response->body());
            case NotFoundException::HTTP_CODE:
                throw new NotFoundException($response->body());
            case TooManyRequestsException::HTTP_CODE:
                throw new TooManyRequestsException($response->body());
            default:
                throw new GitHubApiException(
                    'Ошибка обращения к API. Неожиданный код ошибки: ' . $response->status() . '.',
                    $response->status(),
                    $response->body()
                );
        }
    }
}
