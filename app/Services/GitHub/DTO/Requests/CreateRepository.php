<?php

declare(strict_types=1);

namespace App\Services\GitHub\DTO\Requests;

final class CreateRepository
{
    public function __construct(
        public readonly string $name,
        public readonly bool $private = false,
    ) {}

    /**
     * Устанавливает значения свойств текущего объекта из массива
     */
    public static function fromArray(array $sourceArray): self
    {
        return new self($sourceArray);
    }

    /**
     * Сериализует объект запроса к API для дальнейшей его отправки
     * Или Формирует ассоциативный массив данных из объекта запроса отправляемый в дальнейшем в API
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
