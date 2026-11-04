<?php

declare(strict_types=1);

namespace App\Entity;

final class Photo
{
    public function __construct(
        public readonly int $id,
        public readonly int $idSkatepark,
        public readonly string $chemin,
    ) {
    }

    public static function fromRow(array $row): self
    {
        return new self((int) $row['id'], (int) $row['id_skatepark'], $row['chemin']);
    }
}
