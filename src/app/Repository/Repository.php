<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/** Base des repositories : chacun regroupe les requêtes SQL d'une entité. */
abstract class Repository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
