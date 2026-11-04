<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Photo;

<<<<<<< HEAD
class PhotoRepository extends Repository
=======
final class PhotoRepository extends Repository
>>>>>>> origin/main
{
    /** @return Photo[] */
    public function findBySkatepark(int $idSkatepark): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM photo WHERE id_skatepark = :id ORDER BY id');
        $stmt->execute(['id' => $idSkatepark]);
<<<<<<< HEAD

        $photos = [];
        foreach ($stmt->fetchAll() as $row) {
            $photos[] = $this->creerPhoto($row);
        }
        return $photos;
    }

    private function creerPhoto(array $row): Photo
    {
        $photo = new Photo();
        $photo->setId((int) $row['id']);
        $photo->setIdSkatepark((int) $row['id_skatepark']);
        $photo->setChemin($row['chemin']);
        return $photo;
=======
        return array_map(fn (array $row) => Photo::fromRow($row), $stmt->fetchAll());
>>>>>>> origin/main
    }

    public function add(int $idSkatepark, string $chemin): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO photo (id_skatepark, chemin) VALUES (:id, :chemin)');
        $stmt->execute(['id' => $idSkatepark, 'chemin' => $chemin]);
    }
}
