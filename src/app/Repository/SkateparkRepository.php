<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Coordonnees;
use App\Entity\Module;
use App\Entity\Skatepark;

class SkateparkRepository extends Repository
{
    // Requête de base : le skatepark + le chemin de sa première photo
    private const SELECT = 'SELECT s.*,
        (SELECT p.chemin FROM photo p WHERE p.id_skatepark = s.id ORDER BY p.id LIMIT 1) AS photo_principale
        FROM skatepark s';

    public function findById(int $id): ?Skatepark
    {
        $stmt = $this->pdo->prepare(self::SELECT . ' WHERE s.id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->creerSkatepark($row) : null;
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

        $modules = [];
        foreach ($stmt->fetchAll() as $row) {
            $modules[] = $this->creerModule($row);
        }
        return $modules;
    }

    /**
     * Recherche avec filtres, triée par nom.
     *
     * @param string|null $etat null pour ne pas filtrer sur l'état
     * @return Skatepark[]
     */
    public function search(SkateparkFilter $filter, ?string $etat = 'validee', int $limit = 100): array
    {
        $where = [];
        $params = [];

        if ($etat !== null) {
            $where[] = 's.etat_validation = :etat';
            $params['etat'] = $etat;
        }
        if ($filter->getQ() !== null) {
            $where[] = '(s.nom LIKE :q1 OR s.adresse LIKE :q2)';
            $like = '%' . addcslashes($filter->getQ(), '%_\\') . '%';
            $params['q1'] = $like;
            $params['q2'] = $like;
        }
        if ($filter->getTaille() !== null) {
            $where[] = 's.taille = :taille';
            $params['taille'] = $filter->getTaille();
        }
        if ($filter->getEnvironnement() !== null) {
            $where[] = 's.outdoor_indoor = :env';
            $params['env'] = $filter->getEnvironnement();
        }
        foreach ($filter->getModuleIds() as $i => $moduleId) {
            $where[] = "EXISTS (SELECT 1 FROM posseder po WHERE po.id_skatepark = s.id AND po.id_module = :m$i)";
            $params["m$i"] = $moduleId;
        }

        $sql = self::SELECT
            . ($where !== [] ? ' WHERE ' . implode(' AND ', $where) : '')
            . ' ORDER BY s.nom LIMIT ' . $limit;

        return $this->getAll($sql, $params);
    }

    /** @return Skatepark[] */
    public function findLatestValidated(int $limit = 5): array
    {
        $sql = self::SELECT . ' WHERE s.etat_validation = :etat ORDER BY s.date_ajout DESC, s.id DESC LIMIT ' . $limit;
        return $this->getAll($sql, ['etat' => 'validee']);
    }

    /**
     * Skateparks validés les plus proches d'une position (distance calculée en SQL, formule de haversine).
     *
     * @return Skatepark[]
     */
    public function findNearest(Coordonnees $position, int $limit = 5): array
    {
        $sql = 'SELECT s.*,
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
            LIMIT ' . $limit;

        return $this->getAll($sql, [
            'lat1' => $position->getLatitude(),
            'lat2' => $position->getLatitude(),
            'lng' => $position->getLongitude(),
            'etat' => 'validee',
        ]);
    }

    /**
     * Exécute une requête SQL et renvoie un objet Skatepark par ligne trouvée.
     *
     * @return Skatepark[]
     */
    private function getAll(string $sql, array $params): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $parks = [];
        foreach ($stmt->fetchAll() as $row) {
            $parks[] = $this->creerSkatepark($row);
        }
        return $parks;
    }

    /** Transforme une ligne de la table skatepark en objet Skatepark. */
    private function creerSkatepark(array $row): Skatepark
    {
        $park = new Skatepark();
        $park->setId((int) $row['id']);
        $park->setIdCreateur((int) $row['id_createur']);
        $park->setIdAdminValidateur($row['id_admin_validateur'] !== null ? (int) $row['id_admin_validateur'] : null);
        $park->setNom($row['nom']);
        $park->setInstaSiteWeb($row['insta_site_web']);
        $park->setEnvironnement($row['outdoor_indoor']);
        $park->setTaille($row['taille']);
        $park->setAdresse($row['adresse']);
        $park->setInformationsSupplementaires($row['informations_supplementaires']);
        $park->setEtatValidation($row['etat_validation']);
        if ($row['latitude'] !== null && $row['longitude'] !== null) {
            $park->setCoordonnees(new Coordonnees((float) $row['latitude'], (float) $row['longitude']));
        }
        $park->setDateAjout($row['date_ajout']);
        $park->setPhotoPrincipale($row['photo_principale'] ?? null);
        $park->setDistanceKm(isset($row['distance_km']) ? (float) $row['distance_km'] : null);
        return $park;
    }

    /** Transforme une ligne de la table module en objet Module. */
    private function creerModule(array $row): Module
    {
        $module = new Module();
        $module->setId((int) $row['id']);
        $module->setNom($row['nom']);
        return $module;
    }
}
