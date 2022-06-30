<?php

declare(strict_types=1);

namespace App\Services\GitHub\Requests;

final class CreateRepository
{
    public function __construct(
        public readonly string $name,
        public readonly bool $private = false,
    ) {}

    /**
     * Сериализует объект запроса к API для дальнейшей его отправки
     *
     * @return array Массив с информацией, отправляемый в дальнейшем в API
     */
    public function toRequest(): array
    {
        return [
            'name' => $this->name,
            'private' => $this->private,
        ];
    }
}
