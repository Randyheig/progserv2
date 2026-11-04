<?php

declare(strict_types=1);

namespace App\Entity;

final class Module
{
    public function __construct(
        public readonly int $id,
        public readonly string $nom,
    ) {
    }

    public static function fromRow(array $row): self
    {
        return new self((int) $row['id'], $row['nom']);
    }

    /** Nom affiché (première lettre en majuscule). */
    public function libelle(): string
    {
        return mb_strtoupper(mb_substr($this->nom, 0, 1)) . mb_substr($this->nom, 1);
    }
}
