<?php

declare(strict_types=1);

namespace App\Services\GitHub\Resources;

use App\Services\GitHub\DTO\Release;
use App\Services\GitHub\Exceptions\GitHubRequestException;
use App\Services\GitHub\GitHubService;
use Illuminate\Support\Collection;

class ReleaseResource
{
    public function __construct(
        private readonly GitHubService $service,
    ) {}

    /**
     * @return Collection[Release]
     * @throws GitHubRequestException
     */
    public function list(string $owner, string $repo): Release
    {
        $request = $this->service->makeRequest();

        $response = $request->get(
            url: "/repos/{$owner}/{$repo}/releases"
        );

        if ($response->failed()) {
            $this->service->handleError($response);
        }

        return $response->collect()->map(fn(array $repo) => Release::fromArray($repo));
    }

    /**
     * @return Release
     * @throws GitHubRequestException
     */
    public function latest(string $owner, string $repo): Release
    {
        $request = $this->service->makeRequest();

        $response = $request->get(
            url: "/repos/{$owner}/{$repo}/releases/latest"
        );

        if ($response->failed()) {
            $this->service->handleError($response);
        }

        return Release::fromArray($response->json());
    }

    /**
     * @return Release
     * @throws GitHubRequestException
     */
    public function version(string $owner, string $repo, string $version): Release
    {
        $request = $this->service->makeRequest();

        $response = $request->get(
            url: "/repos/{$owner}/{$repo}/releases/tags/{$version}"
        );

        if ($response->failed()) {
            $this->service->handleError($response);
        }

        return Release::fromArray($response->json());
    }
}
