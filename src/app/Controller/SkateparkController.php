<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Database;
use App\Repository\PhotoRepository;
use App\Repository\SkateparkRepository;

<<<<<<< HEAD
class SkateparkController extends Controller
{
    private SkateparkRepository $skateparks;
    private PhotoRepository $photos;

    public function __construct()
    {
        $this->skateparks = new SkateparkRepository(Database::getConnection());
        $this->photos = new PhotoRepository(Database::getConnection());
=======
final class SkateparkController extends Controller
{
    private readonly SkateparkRepository $skateparks;
    private readonly PhotoRepository $photos;

    public function __construct(
        ?SkateparkRepository $skateparks = null,
        ?PhotoRepository $photos = null,
    ) {
        $this->skateparks = $skateparks ?? new SkateparkRepository(Database::getConnection());
        $this->photos = $photos ?? new PhotoRepository(Database::getConnection());
>>>>>>> origin/main
    }

    /** Fiche d'un skatepark validé. */
    public function show(): void
    {
        $park = $this->skateparks->findById((int) ($this->query('id') ?? 0));

        if ($park === null || !$park->isValidee()) {
            $this->render('404', ['title' => 'Skatepark introuvable'], 404);
            return;
        }

<<<<<<< HEAD
        $park->setModules($this->skateparks->findModules($park->getId()));
        $park->setPhotos($this->photos->findBySkatepark($park->getId()));

        $this->render('skatepark', [
            'title' => $park->getNom(),
=======
        $park->setModules($this->skateparks->findModules($park->id));
        $park->setPhotos($this->photos->findBySkatepark($park->id));

        $this->render('skatepark', [
            'title' => $park->nom,
>>>>>>> origin/main
            'hero' => true,
            'withMap' => $park->hasCoordinates(),
            'park' => $park,
        ]);
    }
}
