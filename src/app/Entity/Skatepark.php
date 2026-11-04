<?php

declare(strict_types=1);

namespace App\Entity;

<<<<<<< HEAD
use InvalidArgumentException;


class Skatepark {
    public const TAILLES = ['S', 'M', 'L', 'XL'];
    public const ENVIRONNEMENTS = ['outdoor', 'indoor'];
    public const ETATS = ['en_attente', 'validee', 'refusee'];

    private int $id;
    private int $idCreateur;
    private ?int $idAdminValidateur = null;
    private string $nom;
    private ?string $instaSiteWeb = null;
    private string $environnement;
    private string $taille;
    private string $adresse;
    private ?string $informationsSupplementaires = null;
    private string $etatValidation;
    private ?Coordonnees $coordonnees = null;
    private string $dateAjout;
    private ?string $photoPrincipale = null;
    private ?float $distanceKm = null;

=======
use App\Enum\EtatValidation;
use App\Enum\Environnement;
use App\Enum\Taille;

final class Skatepark
{
>>>>>>> origin/main
    /** @var Module[] */
    private array $modules = [];

    /** @var Photo[] */
    private array $photos = [];

<<<<<<< HEAD
    // ----- Getters -----

    public function getId(): int {
        return $this->id;
    }

    public function getIdCreateur(): int {
        return $this->idCreateur;
    }

    public function getIdAdminValidateur(): ?int {
        return $this->idAdminValidateur;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getInstaSiteWeb(): ?string {
        return $this->instaSiteWeb;
    }

    public function getEnvironnement(): string {
        return $this->environnement;
    }

    public function getTaille(): string {
        return $this->taille;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function getInformationsSupplementaires(): ?string {
        return $this->informationsSupplementaires;
    }

    public function getEtatValidation(): string {
        return $this->etatValidation;
    }

    public function getCoordonnees(): ?Coordonnees {
        return $this->coordonnees;
    }

    public function getDateAjout(): string {
        return $this->dateAjout;
    }

    public function getPhotoPrincipale(): ?string {
        return $this->photoPrincipale;
    }

    public function getDistanceKm(): ?float {
        return $this->distanceKm;
    }

    /** @return Module[] */
    public function getModules(): array {
        return $this->modules;
    }

    /** @return Photo[] */
    public function getPhotos(): array {
        return $this->photos;
    }

    // ----- Setters -----

    public function setId(int $id): void {
        if ($id <= 0) {
            throw new InvalidArgumentException('Id invalide.');
        }

        $this->id = $id;
    }

    public function setIdCreateur(int $idCreateur): void {
        if ($idCreateur <= 0) {
            throw new InvalidArgumentException('Créateur invalide.');
        }

        $this->idCreateur = $idCreateur;
    }

    public function setIdAdminValidateur(?int $idAdminValidateur): void {
        if ($idAdminValidateur !== null && $idAdminValidateur <= 0) {
            throw new InvalidArgumentException('Admin invalide.');
        }

        $this->idAdminValidateur = $idAdminValidateur;
    }

    public function setNom(string $nom): void {
        $nom = trim($nom);
        if ($nom === '' || mb_strlen($nom) > 150) {
            throw new InvalidArgumentException('Le nom est obligatoire (150 caractères maximum).');
        }

        $this->nom = $nom;
    }

    public function setInstaSiteWeb(?string $instaSiteWeb): void {
        if ($instaSiteWeb !== null) {
            $instaSiteWeb = trim($instaSiteWeb);
            if ($instaSiteWeb === '') {
                $instaSiteWeb = null;
            } elseif (mb_strlen($instaSiteWeb) > 255) {
                throw new InvalidArgumentException('Le site ou compte Instagram est trop long (255 caractères maximum).');
            }
        }

        $this->instaSiteWeb = $instaSiteWeb;
    }

    public function setEnvironnement(string $environnement): void {
        if (!in_array($environnement, self::ENVIRONNEMENTS, true)) {
            throw new InvalidArgumentException('Environnement invalide (outdoor ou indoor).');
        }

        $this->environnement = $environnement;
    }

    public function setTaille(string $taille): void {
        if (!in_array($taille, self::TAILLES, true)) {
            throw new InvalidArgumentException('Taille invalide (S, M, L ou XL).');
        }

        $this->taille = $taille;
    }

    public function setAdresse(string $adresse): void {
        $adresse = trim($adresse);
        if ($adresse === '' || mb_strlen($adresse) > 255) {
            throw new InvalidArgumentException('L\'adresse est obligatoire (255 caractères maximum).');
        }

        $this->adresse = $adresse;
    }

    public function setInformationsSupplementaires(?string $informationsSupplementaires): void {
        if ($informationsSupplementaires !== null) {
            $informationsSupplementaires = trim($informationsSupplementaires);
            if ($informationsSupplementaires === '') {
                $informationsSupplementaires = null;
            } elseif (mb_strlen($informationsSupplementaires) > 2000) {
                throw new InvalidArgumentException('Les informations sont trop longues (2000 caractères maximum).');
            }
        }

        $this->informationsSupplementaires = $informationsSupplementaires;
    }

    public function setEtatValidation(string $etatValidation): void {
        if (!in_array($etatValidation, self::ETATS, true)) {
            throw new InvalidArgumentException('État de validation invalide.');
        }

        $this->etatValidation = $etatValidation;
    }

    public function setCoordonnees(?Coordonnees $coordonnees): void {
        $this->coordonnees = $coordonnees;
    }

    public function setDateAjout(string $dateAjout): void {
        $this->dateAjout = $dateAjout;
    }

    public function setPhotoPrincipale(?string $photoPrincipale): void {
        $this->photoPrincipale = $photoPrincipale;
    }

    public function setDistanceKm(?float $distanceKm): void {
        if ($distanceKm !== null && $distanceKm < 0) {
            throw new InvalidArgumentException('Distance invalide.');
        }

        $this->distanceKm = $distanceKm;
    }

    /** @param Module[] $modules */
    public function setModules(array $modules): void {
        $this->modules = $modules;
    }

    /** @param Photo[] $photos */
    public function setPhotos(array $photos): void {
        $this->photos = $photos;
    }

    // ----- Méthodes métier -----

    public function isValidee(): bool {
        return $this->etatValidation === 'validee';
    }

    public function hasCoordinates(): bool {
        return $this->coordonnees !== null;
    }

    /** URL du site web si le champ en contient une, sinon null. */
    public function siteWebUrl(): ?string {
        if ($this->instaSiteWeb === null) {
            return null;
        }
        if (str_starts_with($this->instaSiteWeb, 'http://') || str_starts_with($this->instaSiteWeb, 'https://')) {
            return $this->instaSiteWeb;
=======
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
>>>>>>> origin/main
        }
        return null;
    }

    /** Compte Instagram (sans @) si le champ ne contient pas une URL. */
<<<<<<< HEAD
    public function instagram(): ?string {
        if ($this->instaSiteWeb === null || $this->instaSiteWeb === '' || $this->siteWebUrl() !== null) {
            return null;
        }
        return ltrim($this->instaSiteWeb, '@');
=======
    public function instagram(): ?string
    {
        $value = $this->instaSiteWeb;
        if ($value === null || $value === '' || $this->siteWebUrl() !== null) {
            return null;
        }
        return ltrim($value, '@');
>>>>>>> origin/main
    }
}
