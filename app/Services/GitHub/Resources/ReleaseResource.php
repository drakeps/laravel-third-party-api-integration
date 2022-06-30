<?php

declare(strict_types=1);

namespace App\Services\GitHub\Resources;

use App\Services\GitHub\DTO\Release;
use App\Services\GitHub\Exceptions\GitHubRequestException;
use App\Services\GitHub\Factories\ReleaseFactory;
use App\Services\GitHub\GitHubService;
use Illuminate\Support\Collection;

class ReleaseResource
{
    public function __construct(
        private readonly GitHubService $service,
    ) {}

    public function service(): GitHubService
    {
        return $this->service;
    }

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
            throw new GitHubRequestException(
                response: $response,
            );
        }

        return $response->collect()->map(fn(array $repo) => ReleaseFactory::make(
            attributes: $repo,
        ));
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
            throw new GitHubRequestException(
                response: $response,
            );
        }

        return ReleaseFactory::make(
            attributes: $response->json(),
        );
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
            throw new GitHubRequestException(
                response: $response,
            );
        }

        return ReleaseFactory::make(
            attributes: $response->json(),
        );
    }
}
