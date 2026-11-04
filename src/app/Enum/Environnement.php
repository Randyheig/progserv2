<?php

declare(strict_types=1);

namespace App\Enum;

enum Environnement: string
{
    case Outdoor = 'outdoor';
    case Indoor = 'indoor';

    public function label(): string
    {
        return match ($this) {
            self::Outdoor => 'Outdoor',
            self::Indoor => 'Indoor',
        };
    }
}
