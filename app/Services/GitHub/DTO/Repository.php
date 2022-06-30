<?php

declare(strict_types=1);

namespace App\Services\GitHub\DTO;

use Carbon\Carbon;

class Repository
{
    /**
     * @param int $id
     * @param string $name
     * @param string $language
     * @param bool $private
     * @param bool $fork
     * @param bool $archived
     * @param string $uri
     * @param Owner $organisation
     * @param Carbon $created
     * @param string|null $description
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $language,
        public readonly bool $private,
        public readonly bool $fork,
        public readonly bool $archived,
        public readonly string $uri,
        public readonly Owner $organisation,
        public readonly Carbon $created,
        public readonly null|string $description = null,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'language' => $this->language,
            'private' => $this->private,
            'fork' => $this->fork,
            'archived' => $this->archived,
            'uri' => $this->uri,
            'organisation' => $this->organisation->toArray(),
            'created' => $this->created->toDateString(),
        ];
    }
}
