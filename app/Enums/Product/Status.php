<?php

namespace App\Enums\Product;

enum Status: string
{
    case DRAFT = 'draft';
    case TRASH = 'trash';
    case PUBLISHED = 'published';

    public static function getAvailableStatus(): array
    {
        return collect(self::cases())
        ->map(
            fn(object $case) => $case->value
        )->toArray();
    }
}