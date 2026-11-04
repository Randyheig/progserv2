<?php

declare(strict_types=1);

namespace App\Entity;

use InvalidArgumentException;

class Module
{
    private int $id;
    private string $nom;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Id invalide.');
        }

        $this->id = $id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $nom = trim($nom);
        if ($nom === '' || mb_strlen($nom) > 50) {
            throw new InvalidArgumentException('Le nom du module est obligatoire (50 caractères maximum).');
        }

        $this->nom = $nom;
    }

    /** Nom affiché (première lettre en majuscule). */
    public function libelle(): string
    {
        return mb_strtoupper(mb_substr($this->nom, 0, 1)) . mb_substr($this->nom, 1);
    }
}
