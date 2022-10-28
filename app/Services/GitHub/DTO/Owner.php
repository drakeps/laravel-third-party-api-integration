<?php

declare(strict_types=1);

namespace App\Services\GitHub\DTO;

class Owner
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        public readonly string $type,
        public readonly string $avatar,
        public readonly string $uri,
    ) {}

    /**
     * Устанавливает значения свойств текущего объекта из массива
     * @param array Ассоциативный массив
     */
    public static function fromArray($sourceArray): self
    {
        return new self(
            id:     intval(data_get($sourceArray, 'id')),
            login:  strval(data_get($sourceArray, 'login')),
            type:   strval(data_get($sourceArray, 'type')),
            avatar: strval(data_get($sourceArray, 'avatar_url')),
            uri:    strval(data_get($sourceArray, 'html_url')),
        );
    }

    /**
     * Возвращает ассоциативный массив со свойствами текущего объекта
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'type' => $this->type,
            'avatar' => $this->avatar,
            'uri' => $this->uri,
        ];
    }
}
