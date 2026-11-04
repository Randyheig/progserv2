<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

/** Base des repositories : chacun regroupe les requêtes SQL d'une entité. */
abstract class Repository
{
    public function __construct(protected readonly PDO $pdo)
    {
    }
}
