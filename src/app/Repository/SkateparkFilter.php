<?php

declare(strict_types=1);

namespace App\Repository;

<<<<<<< HEAD
/** Critères de recherche d'un skatepark (barre de recherche et bouton « Filtres »). */
class SkateparkFilter
{
    private ?string $q = null;
    private ?string $taille = null;
    private ?string $environnement = null;

    /** @var int[] */
    private array $moduleIds = [];

    public function getQ(): ?string
    {
        return $this->q;
    }

    public function setQ(?string $q): void
    {
        $this->q = $q;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): void
    {
        $this->taille = $taille;
    }

    public function getEnvironnement(): ?string
    {
        return $this->environnement;
    }

    public function setEnvironnement(?string $environnement): void
    {
        $this->environnement = $environnement;
    }

    /** @return int[] */
    public function getModuleIds(): array
    {
        return $this->moduleIds;
    }

    /** @param int[] $moduleIds */
    public function setModuleIds(array $moduleIds): void
    {
        $this->moduleIds = $moduleIds;
=======
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
>>>>>>> origin/main
    }
}
