<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Controller;
use App\Core\Database;
use App\Repository\SkateparkRepository;

final class HomeController extends Controller
{
    private readonly SkateparkRepository $skateparks;

    public function __construct(
        ?SkateparkRepository $skateparks = null,
    ) {
        $this->skateparks = $skateparks ?? new SkateparkRepository(Database::getConnection());
    }

    /** Accueil : les 5 skateparks les plus proches si la position est connue, sinon les derniers ajoutés. */
    public function index(): void
    {
        $latitude = $this->coordinate('lat', -90, 90);
        $longitude = $this->coordinate('lng', -180, 180);
        $nearby = $latitude !== null && $longitude !== null;

        $parks = $nearby
            ? $this->skateparks->findNearest($latitude, $longitude, 5)
            : $this->skateparks->findLatestValidated(5);

        $this->render('home', [
            'title' => 'Accueil',
            'hero' => true,
            'parks' => $parks,
            'nearby' => $nearby,
        ]);
    }

    private function coordinate(string $key, float $min, float $max): ?float
    {
        $value = $this->query($key);
        if ($value === null || !is_numeric($value)) {
            return null;
        }
        $number = (float) $value;
        return ($number >= $min && $number <= $max) ? $number : null;
    }
}
