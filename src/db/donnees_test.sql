-- Données de test pour la version simple du site (sans comptes).
-- À importer APRÈS script.sql. Les noms, adresses et coordonnées sont fictifs
-- (positions approximatives des villes), à remplacer par les vrais skateparks.

-- Un compte "technique" est nécessaire car skatepark.id_createur est obligatoire.
INSERT INTO utilisateur (nom, prenom, mail_telephone, npa, mot_de_passe, role)
VALUES ('Skatearth', 'Equipe', 'equipe@skatearth.ch', '1800', 'pas-de-connexion-possible', 'admin');

INSERT INTO skatepark
    (id_createur, id_admin_validateur, nom, insta_site_web, outdoor_indoor, taille, adresse,
     informations_supplementaires, etat_validation, latitude, longitude)
VALUES
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
