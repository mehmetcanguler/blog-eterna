<?php

namespace App\Dtos;

abstract class BaseDTO
{
    public int $per_page;
    public ?string $search;
    abstract public static function fromRequest(array $data): static;
    abstract public function toArray(): array;

    protected function searchStrReplace(string $search): string
    {
        $search = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $search);

        return $search;
    }
}
