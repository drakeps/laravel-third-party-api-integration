<?php

declare(strict_types=1);

namespace App\Services\GitHub\DTO;

use Carbon\Carbon;

class Release
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $tag,
        public readonly string $url,
        public readonly string $description,
        public readonly bool $draft,
        public readonly Owner $author,
        public readonly Carbon $created,
    ) {}

    public function toArray(): array
    {
        return [];
    }
}
