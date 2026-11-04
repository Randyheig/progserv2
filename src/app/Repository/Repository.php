<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/** Base des repositories : chacun regroupe les requêtes SQL d'une entité. */
abstract class Repository
{
<<<<<<< HEAD
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
=======
    public function __construct(protected readonly PDO $pdo)
    {
>>>>>>> origin/main
    }
}
