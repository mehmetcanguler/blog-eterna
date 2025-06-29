<?php

namespace App\Dtos;

abstract class BaseDTO
{
    public function __construct(protected array $attributes = []) {}

    public function get(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    public function set(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    abstract public static function fromRequest(array $data): static;

    abstract public function toArray(): array;
}
