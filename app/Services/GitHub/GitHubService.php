<?php

declare(strict_types=1);

namespace App\Services\GitHub;

use App\Services\Concerns\CanBeFaked;
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
}
