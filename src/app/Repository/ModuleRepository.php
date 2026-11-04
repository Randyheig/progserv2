<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Module;

<<<<<<< HEAD
class ModuleRepository extends Repository
=======
final class ModuleRepository extends Repository
>>>>>>> origin/main
{
    /** @return Module[] */
    public function findAll(): array
    {
        $rows = $this->pdo->query('SELECT * FROM module ORDER BY id')->fetchAll();
<<<<<<< HEAD

        $modules = [];
        foreach ($rows as $row) {
            $modules[] = $this->creerModule($row);
        }
        return $modules;
    }

    private function creerModule(array $row): Module
    {
        $module = new Module();
        $module->setId((int) $row['id']);
        $module->setNom($row['nom']);
        return $module;
=======
        return array_map(fn (array $row) => Module::fromRow($row), $rows);
>>>>>>> origin/main
    }
}
