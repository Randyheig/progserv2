<?php

declare(strict_types=1);

namespace App\Repository;

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
    }
}
