<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Module;
use App\Entity\Skatepark;
use App\Enum\EtatValidation;
use PDOStatement;

final class SkateparkRepository extends Repository
{
    private const SELECT = <<<'SQL'
        SELECT s.*,
               (SELECT p.chemin FROM photo p WHERE p.id_skatepark = s.id ORDER BY p.id LIMIT 1) AS photo_principale
        FROM skatepark s
        SQL;

    public function findById(int $id): ?Skatepark
    {
        $stmt = $this->pdo->prepare(self::SELECT . ' WHERE s.id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Skatepark::fromRow($row) : null;
    }

    /** @return Module[] */
    public function findModules(int $idSkatepark): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT m.* FROM module m
             JOIN posseder po ON po.id_module = m.id
             WHERE po.id_skatepark = :id
             ORDER BY m.id'
        );
        $stmt->execute(['id' => $idSkatepark]);
        return array_map(fn (array $row) => Module::fromRow($row), $stmt->fetchAll());
    }

    /**
     * Recherche avec filtres, triée par nom.
     *
     * @param EtatValidation|null $etat null pour ne pas filtrer sur l'état
     * @return Skatepark[]
     */
    public function search(SkateparkFilter $filter, ?EtatValidation $etat = EtatValidation::Validee, int $limit = 100): array
    {
        $where = [];
        $params = [];

        if ($etat !== null) {
            $where[] = 's.etat_validation = :etat';
            $params['etat'] = $etat->value;
        }
        if ($filter->q !== null) {
            $where[] = '(s.nom LIKE :q1 OR s.adresse LIKE :q2)';
            $like = '%' . addcslashes($filter->q, '%_\\') . '%';
            $params['q1'] = $like;
            $params['q2'] = $like;
        }
        if ($filter->taille !== null) {
            $where[] = 's.taille = :taille';
            $params['taille'] = $filter->taille->value;
        }
        if ($filter->environnement !== null) {
            $where[] = 's.outdoor_indoor = :env';
            $params['env'] = $filter->environnement->value;
        }
        foreach ($filter->moduleIds as $i => $moduleId) {
            $where[] = "EXISTS (SELECT 1 FROM posseder po WHERE po.id_skatepark = s.id AND po.id_module = :m$i)";
            $params["m$i"] = $moduleId;
        }

        $sql = self::SELECT
            . ($where !== [] ? ' WHERE ' . implode(' AND ', $where) : '')
            . ' ORDER BY s.nom LIMIT ' . max(1, $limit);

        return $this->fetchAll($sql, $params);
    }

    /** @return Skatepark[] */
    public function findLatestValidated(int $limit = 5): array
    {
        $sql = self::SELECT . ' WHERE s.etat_validation = :etat ORDER BY s.date_ajout DESC, s.id DESC LIMIT ' . max(1, $limit);
        return $this->fetchAll($sql, ['etat' => EtatValidation::Validee->value]);
    }

    /**
     * Skateparks validés les plus proches d'une position (distance calculée en SQL, formule de haversine).
     *
     * @return Skatepark[]
     */
    public function findNearest(float $latitude, float $longitude, int $limit = 5): array
    {
        $sql = <<<'SQL'
            SELECT s.*,
                   (SELECT p.chemin FROM photo p WHERE p.id_skatepark = s.id ORDER BY p.id LIMIT 1) AS photo_principale,
                   (6371 * ACOS(LEAST(1,
                       COS(RADIANS(:lat1)) * COS(RADIANS(s.latitude)) * COS(RADIANS(s.longitude) - RADIANS(:lng))
                       + SIN(RADIANS(:lat2)) * SIN(RADIANS(s.latitude))
                   ))) AS distance_km
            FROM skatepark s
            WHERE s.etat_validation = :etat
              AND s.latitude IS NOT NULL
              AND s.longitude IS NOT NULL
            ORDER BY distance_km
            SQL . ' LIMIT ' . max(1, $limit);

        return $this->fetchAll($sql, [
            'lat1' => $latitude,
            'lat2' => $latitude,
            'lng' => $longitude,
            'etat' => EtatValidation::Validee->value,
        ]);
    }

    /** @return Skatepark[] */
    private function fetchAll(string $sql, array $params): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $this->hydrate($stmt);
    }

    /** @return Skatepark[] */
    private function hydrate(PDOStatement $stmt): array
    {
        return array_map(fn (array $row) => Skatepark::fromRow($row), $stmt->fetchAll());
    }
}
