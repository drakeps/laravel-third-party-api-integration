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

    /**
     * Устанавливает значения свойств текущего объекта из массива
     * @param array Ассоциативный массив
     */
    public static function fromArray($sourceArray): self
    {
        return new self(
            id:          intval(data_get($sourceArray, 'id')),
            name:        strval(data_get($sourceArray, 'name')),
            tag:         strval(data_get($sourceArray, 'tag_name')),
            url:         strval(data_get($sourceArray, 'html_url')),
            description: strval(data_get($sourceArray, 'body')),
            draft:       boolval(data_get($sourceArray, 'draft')),
            author:      Owner::fromArray((array)data_get($sourceArray, 'author')),
            created:     Carbon::parse(
                time: strval(data_get($sourceArray, 'created_at')),
            ),
        );
    }

    /**
     * Возвращает ассоциативный массив со свойствами текущего объекта
     */
    public function toArray(): array
    {
        return [
            // ...
        ];
    }
}
