<?php

declare(strict_types=1);

namespace App\Services\GitHub\Resources;

use App\Services\GitHub\DTO\Repository;
use App\Services\GitHub\Exceptions\GitHubRequestException;
use App\Services\GitHub\Factories\RepositoryFactory;
use App\Services\GitHub\GitHubService;
use App\Services\GitHub\Requests\CreateRepository;
use Illuminate\Support\Collection;

class RepositoryResource
{
    public function __construct(
        private readonly GitHubService $service,
    ) {}

    public function service(): GitHubService
    {
        return $this->service;
    }

    /**
     * @return Collection[Repository]
     * @throws GitHubRequestException
     */
    public function organisation(string $organisation): Collection
    {
        $request = $this->service->makeRequest();

        $response = $request->get(
            url: "/orgs/{$organisation}/repos"
        );

        if ($response->failed()) {
            throw new GitHubRequestException(
                response: $response,
            );
        }

        return $response->collect()->map(fn(array $repo) => RepositoryFactory::make(
            attributes: $repo,
        ));
    }

    /**
     * @return Repository
     * @throws GitHubRequestException
     */
    public function user(string $owner, string $repository): Repository
    {
        $request = $this->service->makeRequest();

        $response = $request->get(
            url: "/repos/{$owner}/{$repository}"
        );

        if ($response->failed()) {
            throw new GitHubRequestException(
                response: $response,
            );
        }

        return RepositoryFactory::make(
            attributes: $response->json(),
        );
    }

    /**
     * @return Repository
     * @throws GitHubRequestException
     */
    public function create(string $owner,  CreateRepository $requestBody, bool $organisation = false, ): Repository
    {
        $request = $this->service()->makeRequest();

        $response = $request->post(
            url: $organisation ? "/orgs/{$owner}/repos" : "/user/repos",
            data: $requestBody->toRequest(),
        );

        if ($response->failed()) {
            throw new GitHubRequestException(
                response: $response,
            );
        }

        return RepositoryFactory::make(
            attributes: (array) $response->json(),
        );
    }
}
