<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Module;

class ModuleRepository extends Repository
{
    /** @return Module[] */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM module ORDER BY id');
        $stmt->execute();
        $rows = $stmt->fetchAll();

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
    }
}
