<?php

declare(strict_types=1);

namespace App\Entity;

use InvalidArgumentException;

/** Position GPS d'un lieu : une latitude et une longitude toujours valides ensemble. */
class Coordonnees
{
    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new InvalidArgumentException('Latitude invalide (entre -90 et 90).');
        }
        if ($longitude < -180 || $longitude > 180) {
            throw new InvalidArgumentException('Longitude invalide (entre -180 et 180).');
        }

        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
