<?php

declare(strict_types=1);

namespace App\Entity;

<<<<<<< HEAD
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
=======
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
>>>>>>> origin/main
    }
}
