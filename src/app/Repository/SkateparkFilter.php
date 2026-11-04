<?php

declare(strict_types=1);

namespace App\Repository;

use App\Enum\Environnement;
use App\Enum\Taille;

/** Critères de recherche d'un skatepark (barre de recherche et bouton « Filtres »). */
final class SkateparkFilter
{
    /** @param int[] $moduleIds */
    public function __construct(
        public readonly ?string $q = null,
        public readonly ?Taille $taille = null,
        public readonly ?Environnement $environnement = null,
        public readonly array $moduleIds = [],
    ) {
    }

    /** Construit le filtre à partir de $_GET en ignorant les valeurs invalides. */
    public static function fromQuery(array $query): self
    {
        $q = is_string($query['q'] ?? null) ? trim($query['q']) : '';
        $taille = is_string($query['taille'] ?? null) ? Taille::tryFrom($query['taille']) : null;
        $env = is_string($query['env'] ?? null) ? Environnement::tryFrom($query['env']) : null;

        $moduleIds = array_map('intval', array_filter((array) ($query['modules'] ?? []), 'is_scalar'));
        $moduleIds = array_values(array_unique(array_filter($moduleIds, fn (int $id) => $id > 0)));

        return new self($q !== '' ? mb_substr($q, 0, 100) : null, $taille, $env, $moduleIds);
    }
}
