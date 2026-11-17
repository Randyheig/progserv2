<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Database;
use App\Repository\PhotoRepository;
use App\Repository\SkateparkRepository;

class SkateparkController extends Controller
{
    private SkateparkRepository $skateparks;
    private PhotoRepository $photos;

    public function __construct()
    {
        $this->skateparks = new SkateparkRepository(Database::getConnection());
        $this->photos = new PhotoRepository(Database::getConnection());
    }

    /** Fiche d'un skatepark validé. */
    public function show(): void
    {
        $park = $this->skateparks->findById((int) ($this->query('id') ?? 0));

        if ($park === null || !$park->isValidee()) {
            $this->render('404', ['title' => 'Skatepark introuvable'], 404);
            return;
        }

        $park->setModules($this->skateparks->findModules($park->getId()));
        $park->setPhotos($this->photos->findBySkatepark($park->getId()));

        $this->render('skatepark', [
            'title' => $park->getNom(),
            'hero' => true,
            'withMap' => $park->hasCoordinates(),
            'park' => $park,
        ]);
    }
}
