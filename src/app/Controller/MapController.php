<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Database;
use App\Entity\Skatepark;
use App\Repository\ModuleRepository;
use App\Repository\SkateparkFilter;
use App\Repository\SkateparkRepository;

class MapController extends Controller
{
    private SkateparkRepository $skateparks;
    private ModuleRepository $modules;

    public function __construct()
    {
        $this->skateparks = new SkateparkRepository(Database::getConnection());
        $this->modules = new ModuleRepository(Database::getConnection());
    }

    /** Carte interactive et liste, avec recherche et filtres. */
    public function index(): void
    {
        $filter = $this->creerFiltre();
        $parks = $this->skateparks->search($filter);

        $markers = [];
        foreach ($parks as $park) {
            if ($park->hasCoordinates()) {
                $coordonnees = $park->getCoordonnees();
                $markers[] = [
                    'nom' => $park->getNom(),
                    'lat' => $coordonnees->getLatitude(),
                    'lng' => $coordonnees->getLongitude(),
                    'url' => url('skatepark', ['id' => $park->getId()]),
                ];
            }
        }

        $this->render('map', [
            'title' => 'Map',
            'withMap' => true,
            'parks' => $parks,
            'markers' => $markers,
            'filter' => $filter,
            'allModules' => $this->modules->findAll(),
        ]);
    }

    /** Construit le filtre à partir de l'URL (?q=...&taille=...&env=...&modules[]=...) en ignorant les valeurs invalides. */
    private function creerFiltre(): SkateparkFilter
    {
        $filter = new SkateparkFilter();

        $q = trim($this->query('q') ?? '');
        if ($q !== '') {
            $filter->setQ(mb_substr($q, 0, 100));
        }

        $taille = $this->query('taille');
        if (in_array($taille, Skatepark::TAILLES, true)) {
            $filter->setTaille($taille);
        }

        $env = $this->query('env');
        if (in_array($env, Skatepark::ENVIRONNEMENTS, true)) {
            $filter->setEnvironnement($env);
        }

        $moduleIds = [];
        foreach ((array) ($_GET['modules'] ?? []) as $id) {
            if (is_scalar($id) && (int) $id > 0) {
                $moduleIds[] = (int) $id;
            }
        }
        $filter->setModuleIds($moduleIds);

        return $filter;
    }
}
