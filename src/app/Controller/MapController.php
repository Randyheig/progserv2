<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Database;
<<<<<<< HEAD
use App\Entity\Skatepark;
=======
>>>>>>> origin/main
use App\Repository\ModuleRepository;
use App\Repository\SkateparkFilter;
use App\Repository\SkateparkRepository;

<<<<<<< HEAD
class MapController extends Controller
{
    private SkateparkRepository $skateparks;
    private ModuleRepository $modules;

    public function __construct()
    {
        $this->skateparks = new SkateparkRepository(Database::getConnection());
        $this->modules = new ModuleRepository(Database::getConnection());
=======
final class MapController extends Controller
{
    private readonly SkateparkRepository $skateparks;
    private readonly ModuleRepository $modules;

    public function __construct(
        ?SkateparkRepository $skateparks = null,
        ?ModuleRepository $modules = null,
    ) {
        $this->skateparks = $skateparks ?? new SkateparkRepository(Database::getConnection());
        $this->modules = $modules ?? new ModuleRepository(Database::getConnection());
>>>>>>> origin/main
    }

    /** Carte interactive et liste, avec recherche et filtres. */
    public function index(): void
    {
<<<<<<< HEAD
        $filter = $this->creerFiltre();
=======
        $filter = SkateparkFilter::fromQuery($_GET);
>>>>>>> origin/main
        $parks = $this->skateparks->search($filter);

        $markers = [];
        foreach ($parks as $park) {
            if ($park->hasCoordinates()) {
<<<<<<< HEAD
                $coordonnees = $park->getCoordonnees();
                $markers[] = [
                    'nom' => $park->getNom(),
                    'lat' => $coordonnees->getLatitude(),
                    'lng' => $coordonnees->getLongitude(),
                    'url' => url('skatepark', ['id' => $park->getId()]),
=======
                $markers[] = [
                    'nom' => $park->nom,
                    'lat' => $park->latitude,
                    'lng' => $park->longitude,
                    'url' => url('skatepark', ['id' => $park->id]),
>>>>>>> origin/main
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
<<<<<<< HEAD

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
=======
>>>>>>> origin/main
}
