<?php

declare(strict_types=1);

namespace App\Entity;

use InvalidArgumentException;

class Photo
{
    private int $id;
    private int $idSkatepark;
    private string $chemin;

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

    public function getIdSkatepark(): int
    {
        return $this->idSkatepark;
    }

    public function setIdSkatepark(int $idSkatepark): void
    {
        if ($idSkatepark <= 0) {
            throw new InvalidArgumentException('Skatepark invalide.');
        }

        $this->idSkatepark = $idSkatepark;
    }

    public function getChemin(): string
    {
        return $this->chemin;
    }

    public function setChemin(string $chemin): void
    {
        if ($chemin === '' || mb_strlen($chemin) > 255) {
            throw new InvalidArgumentException('Chemin de photo invalide.');
        }

        $this->chemin = $chemin;
    }
}
