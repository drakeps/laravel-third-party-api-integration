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
     * Устанавливает значения свойств текущего объекта из массива
     * @param array Ассоциативный массив
     */
    public static function fromArray($sourceArray): self
    {
        return new self(
            id:           intval(data_get($sourceArray, 'id')),
            name:         strval(data_get($sourceArray, 'full_name')),
            language:     strval(data_get($sourceArray, 'language')),
            private:      boolval(data_get($sourceArray, 'private')),
            fork:         boolval(data_get($sourceArray, 'fork')),
            archived:     boolval(data_get($sourceArray, 'archived')),
            uri:          strval(data_get($sourceArray, 'html_url')),
            organisation: Owner::fromArray((array) data_get($sourceArray, 'owner')),
            created:      Carbon::parse(
                time: strval(data_get($sourceArray, 'created_at')),
            ),
            description:  strval(data_get($sourceArray, 'description')),
        );
    }

    /**
     * Возвращает ассоциативный массив со свойствами текущего объекта
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
