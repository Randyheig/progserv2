<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Database;
use App\Repository\ModuleRepository;
use App\Repository\SkateparkFilter;
use App\Repository\SkateparkRepository;

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
    }

    /** Carte interactive et liste, avec recherche et filtres. */
    public function index(): void
    {
        $filter = SkateparkFilter::fromQuery($_GET);
        $parks = $this->skateparks->search($filter);

        $markers = [];
        foreach ($parks as $park) {
            if ($park->hasCoordinates()) {
                $markers[] = [
                    'nom' => $park->nom,
                    'lat' => $park->latitude,
                    'lng' => $park->longitude,
                    'url' => url('skatepark', ['id' => $park->id]),
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
}
