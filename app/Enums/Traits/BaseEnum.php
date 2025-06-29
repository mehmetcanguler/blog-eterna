<?php

namespace App\Enums\Traits;

trait BaseEnum
{
    public static function labels(): array
    {
        return array_combine(
            array_map(fn($case) => $case->value, self::cases()),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }

    public static function toArray(): array
    {
        return array_map(fn($case) => [
            'name' => $case->name,
            'value' => $case->value,
            'label' => $case->label(),
        ], self::cases());
    }

    public static function fromLabel(string $label): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->label() === $label) {
                return $case;
            }
        }

        return null;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }

    abstract public function label(): string;
}
