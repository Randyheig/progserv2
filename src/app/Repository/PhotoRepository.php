<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Photo;

final class PhotoRepository extends Repository
{
    /** @return Photo[] */
    public function findBySkatepark(int $idSkatepark): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM photo WHERE id_skatepark = :id ORDER BY id');
        $stmt->execute(['id' => $idSkatepark]);
        return array_map(fn (array $row) => Photo::fromRow($row), $stmt->fetchAll());
    }

    public function add(int $idSkatepark, string $chemin): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO photo (id_skatepark, chemin) VALUES (:id, :chemin)');
        $stmt->execute(['id' => $idSkatepark, 'chemin' => $chemin]);
    }
}
