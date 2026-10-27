-- MPD : site des skateparks vaudois (MariaDB)
-- Correspond au MLD (src/db/MLDSiteSkate.png)



-- Suppression des tables existantes (ordre inverse des dépendances)
DROP TABLE IF EXISTS photo;
DROP TABLE IF EXISTS liker;
DROP TABLE IF EXISTS posseder;
DROP TABLE IF EXISTS skatepark;
DROP TABLE IF EXISTS module;
DROP TABLE IF EXISTS utilisateur;

CREATE TABLE utilisateur (
    id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom              VARCHAR(100) NOT NULL,
    prenom           VARCHAR(100) NOT NULL,
    mail_telephone   VARCHAR(255) NOT NULL,
    npa              VARCHAR(10)  NOT NULL,
    mot_de_passe     VARCHAR(255) NOT NULL,
    photo_profil     VARCHAR(255) NULL,
    role             VARCHAR(20)  NOT NULL DEFAULT 'user',
    PRIMARY KEY (id),
    UNIQUE KEY uq_utilisateur_mail_telephone (mail_telephone),
    CONSTRAINT chk_utilisateur_role
        CHECK (role IN ('user', 'admin'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE skatepark (
    id                             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_createur                    INT UNSIGNED NOT NULL,
    id_admin_validateur            INT UNSIGNED NULL,
    nom                            VARCHAR(150) NOT NULL,
    insta_site_web                 VARCHAR(255) NULL,
    outdoor_indoor                 VARCHAR(10)  NOT NULL,
    taille                         VARCHAR(2)   NOT NULL,
    adresse                        VARCHAR(255) NOT NULL,
    informations_supplementaires   TEXT NULL,
    etat_validation                VARCHAR(20)  NOT NULL DEFAULT 'en_attente',
    latitude                       DECIMAL(9,6) NULL,
    longitude                      DECIMAL(9,6) NULL,
    date_ajout                     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_skatepark_createur
        FOREIGN KEY (id_createur) REFERENCES utilisateur (id)
        ON DELETE RESTRICT,
    CONSTRAINT fk_skatepark_admin_validateur
        FOREIGN KEY (id_admin_validateur) REFERENCES utilisateur (id)
        ON DELETE SET NULL,
    CONSTRAINT chk_skatepark_outdoor_indoor
        CHECK (outdoor_indoor IN ('outdoor', 'indoor')),
    CONSTRAINT chk_skatepark_taille
        CHECK (taille IN ('S', 'M', 'L', 'XL')),
    CONSTRAINT chk_skatepark_etat_validation
        CHECK (etat_validation IN ('en_attente', 'validee', 'refusee'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE module (
    id    INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom   VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_module_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE posseder (
    id_skatepark   INT UNSIGNED NOT NULL,
    id_module      INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_skatepark, id_module),
    CONSTRAINT fk_posseder_skatepark
        FOREIGN KEY (id_skatepark) REFERENCES skatepark (id)
        ON DELETE CASCADE,
    CONSTRAINT fk_posseder_module
        FOREIGN KEY (id_module) REFERENCES module (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE liker (
    id_utilisateur   INT UNSIGNED NOT NULL,
    id_skatepark     INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_utilisateur, id_skatepark),
    CONSTRAINT fk_liker_utilisateur
        FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)
        ON DELETE CASCADE,
    CONSTRAINT fk_liker_skatepark
        FOREIGN KEY (id_skatepark) REFERENCES skatepark (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE photo (
    id             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_skatepark   INT UNSIGNED NOT NULL,
    chemin         VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_photo_skatepark
        FOREIGN KEY (id_skatepark) REFERENCES skatepark (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Données de référence
INSERT INTO module (nom) VALUES
    ('rampe'), ('box'), ('flat'), ('quarter'),
    ('rail'), ('curb'), ('bowl'), ('autre');
