<<<<<<< HEAD
-- Données de test (sans comptes). Les noms, adresses et coordonnées sont fictifs,
-- à remplacer par les vrais skateparks.
--
-- À importer APRÈS script.sql, DANS la base : cliquer d'abord sur le nom de la
-- base à gauche dans phpMyAdmin, puis onglet Importer.
-- Peut être lancé sur une base qui contient déjà des parks : rien n'est écrasé,
-- les parks sont simplement ajoutés.

-- Compte "technique" (skatepark.id_createur est obligatoire), créé une seule fois.
INSERT INTO utilisateur (nom, prenom, mail_telephone, npa, mot_de_passe, role)
SELECT 'Skatearth', 'Equipe', 'equipe@skatearth.ch', '1800', 'pas-de-connexion-possible', 'admin'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM utilisateur WHERE mail_telephone = 'equipe@skatearth.ch');

SET @u := (SELECT id FROM utilisateur WHERE mail_telephone = 'equipe@skatearth.ch');

-- Lausanne
=======
-- Données de test pour la version simple du site (sans comptes).
-- À importer APRÈS script.sql. Les noms, adresses et coordonnées sont fictifs
-- (positions approximatives des villes), à remplacer par les vrais skateparks.

-- Un compte "technique" est nécessaire car skatepark.id_createur est obligatoire.
INSERT INTO utilisateur (nom, prenom, mail_telephone, npa, mot_de_passe, role)
VALUES ('Skatearth', 'Equipe', 'equipe@skatearth.ch', '1800', 'pas-de-connexion-possible', 'admin');

>>>>>>> origin/main
INSERT INTO skatepark
    (id_createur, id_admin_validateur, nom, insta_site_web, outdoor_indoor, taille, adresse,
     informations_supplementaires, etat_validation, latitude, longitude)
VALUES
<<<<<<< HEAD
    (@u, @u, 'Skatepark de test Lausanne', NULL, 'outdoor', 'L', 'Lausanne',
     'Données de test.', 'validee', 46.519600, 6.632300);
SET @p := LAST_INSERT_ID();
INSERT INTO posseder (id_skatepark, id_module)
SELECT @p, id FROM module WHERE nom IN ('rampe', 'box', 'rail', 'bowl');

-- Yverdon-les-Bains
INSERT INTO skatepark
    (id_createur, id_admin_validateur, nom, insta_site_web, outdoor_indoor, taille, adresse,
     informations_supplementaires, etat_validation, latitude, longitude)
VALUES
    (@u, @u, 'Skatepark de test Yverdon', NULL, 'outdoor', 'M', 'Yverdon-les-Bains',
     'Données de test.', 'validee', 46.778500, 6.641100);
SET @p := LAST_INSERT_ID();
INSERT INTO posseder (id_skatepark, id_module)
SELECT @p, id FROM module WHERE nom IN ('box', 'flat', 'curb');

-- Vevey
INSERT INTO skatepark
    (id_createur, id_admin_validateur, nom, insta_site_web, outdoor_indoor, taille, adresse,
     informations_supplementaires, etat_validation, latitude, longitude)
VALUES
    (@u, @u, 'Skatepark de test Vevey', NULL, 'indoor', 'S', 'Vevey',
     'Données de test.', 'validee', 46.462800, 6.842700);
SET @p := LAST_INSERT_ID();
INSERT INTO posseder (id_skatepark, id_module)
SELECT @p, id FROM module WHERE nom IN ('rampe', 'quarter');
=======
    (1, 1, 'Skatepark de test Lausanne', NULL, 'outdoor', 'L', 'Lausanne',
     'Données de test.', 'validee', 46.519600, 6.632300),
    (1, 1, 'Skatepark de test Yverdon', NULL, 'outdoor', 'M', 'Yverdon-les-Bains',
     'Données de test.', 'validee', 46.778500, 6.641100),
    (1, 1, 'Skatepark de test Vevey', NULL, 'indoor', 'S', 'Vevey',
     'Données de test.', 'validee', 46.462800, 6.842700);

-- Modules : 1 rampe, 2 box, 3 flat, 4 quarter, 5 rail, 6 curb, 7 bowl, 8 autre
INSERT INTO posseder (id_skatepark, id_module) VALUES
    (1, 1), (1, 2), (1, 5), (1, 7),
    (2, 2), (2, 3), (2, 6),
    (3, 1), (3, 4);
>>>>>>> origin/main
