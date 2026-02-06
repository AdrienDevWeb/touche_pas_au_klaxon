-- Insertion des agences
INSERT INTO agences (nom_ville) VALUES ('Paris'), ('Lyon'), ('Marseille'), ('Bordeaux');

-- Insertion des comptes de test 
-- Note : Les mots de passe sont ici en clair pour tes tests de login
INSERT INTO employes (nom, prenom, email, password, telephone, role) VALUES 
('Admin', 'Global', 'admin@klaxon.fr', 'admin123', '0102030405', 'admin'),
('Professeur', 'Test', 'prof@test.fr', 'admin123', '0607080910', 'employe');

-- Insertion de trajets (Doivent être futurs pour apparaître) [cite: 11, 60]
INSERT INTO trajets (id_agence_dep, id_agence_arr, gdh_depart, gdh_arrivee, places_totales, places_disponibles, id_auteur) VALUES 
(1, 2, '2026-05-10 08:00:00', '2026-05-10 12:00:00', 4, 3, 2), -- Trajet avec 3 places [cite: 66]
(3, 1, '2026-06-15 14:00:00', '2026-06-15 19:00:00', 3, 1, 2);