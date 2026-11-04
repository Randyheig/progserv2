<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\EtatValidation;
use App\Enum\Environnement;
use App\Enum\Taille;

final class Skatepark
{
    /** @var Module[] */
    private array $modules = [];

    /** @var Photo[] */
    private array $photos = [];

    public function __construct(
        public readonly int $id,
        public readonly int $idCreateur,
        public readonly ?int $idAdminValidateur,
        public readonly string $nom,
        public readonly ?string $instaSiteWeb,
        public readonly Environnement $environnement,
        public readonly Taille $taille,
        public readonly string $adresse,
        public readonly ?string $informationsSupplementaires,
        public readonly EtatValidation $etatValidation,
        public readonly ?float $latitude,
        public readonly ?float $longitude,
        public readonly string $dateAjout,
        public readonly ?string $photoPrincipale = null,
        public readonly ?float $distanceKm = null,
    ) {
    }

    public static function fromRow(array $row): self
    {
        return new self(
            (int) $row['id'],
            (int) $row['id_createur'],
            $row['id_admin_validateur'] !== null ? (int) $row['id_admin_validateur'] : null,
            $row['nom'],
            $row['insta_site_web'],
            Environnement::from($row['outdoor_indoor']),
            Taille::from($row['taille']),
            $row['adresse'],
            $row['informations_supplementaires'],
            EtatValidation::from($row['etat_validation']),
            $row['latitude'] !== null ? (float) $row['latitude'] : null,
            $row['longitude'] !== null ? (float) $row['longitude'] : null,
            $row['date_ajout'],
            $row['photo_principale'] ?? null,
            isset($row['distance_km']) ? (float) $row['distance_km'] : null,
        );
    }

    /** @return Module[] */
    public function getModules(): array
    {
        return $this->modules;
    }

    /** @param Module[] $modules */
    public function setModules(array $modules): void
    {
        $this->modules = $modules;
    }

    /** @return Photo[] */
    public function getPhotos(): array
    {
        return $this->photos;
    }

    /** @param Photo[] $photos */
    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

    public function isValidee(): bool
    {
        return $this->etatValidation === EtatValidation::Validee;
    }

    public function hasCoordinates(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    /** URL du site web si le champ en contient une, sinon null. */
    public function siteWebUrl(): ?string
    {
        $value = $this->instaSiteWeb;
        if ($value !== null && preg_match('#^https?://#i', $value) === 1) {
            return $value;
        }
        return null;
    }

    /** Compte Instagram (sans @) si le champ ne contient pas une URL. */
    public function instagram(): ?string
    {
        $value = $this->instaSiteWeb;
        if ($value === null || $value === '' || $this->siteWebUrl() !== null) {
            return null;
        }
        return ltrim($value, '@');
    }
}
