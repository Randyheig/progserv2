<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Module;

final class ModuleRepository extends Repository
{
    /** @return Module[] */
    public function findAll(): array
    {
        $rows = $this->pdo->query('SELECT * FROM module ORDER BY id')->fetchAll();
        return array_map(fn (array $row) => Module::fromRow($row), $rows);
    }
}
