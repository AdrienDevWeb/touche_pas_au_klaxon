-- Script de création de la base de données "Touche pas au Klaxon"
-- Date : 06/02/2026

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS trajets;
DROP TABLE IF EXISTS employes;
DROP TABLE IF EXISTS agences;
SET FOREIGN_KEY_CHECKS = 1;

-- Table des agences
CREATE TABLE agences (
    id_agence INT PRIMARY KEY AUTO_INCREMENT,
    nom_ville VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Table des employés
CREATE TABLE employes (
    id_employe INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'user'
) ENGINE=InnoDB;

-- Table des trajets
CREATE TABLE trajets (
    id_trajet INT PRIMARY KEY AUTO_INCREMENT,
    id_agence_depart INT NOT NULL,
    id_agence_arrivee INT NOT NULL,
    gdh_depart DATETIME NOT NULL,
    places_totales INT NOT NULL,
    places_disponibles INT NOT NULL,
    id_conducteur INT NOT NULL,
    FOREIGN KEY (id_agence_depart) REFERENCES agences(id_agence),
    FOREIGN KEY (id_agence_arrivee) REFERENCES agences(id_agence),
    FOREIGN KEY (id_conducteur) REFERENCES employes(id_employe)
) ENGINE=InnoDB;

-- Données de test obligatoires pour le brief
INSERT INTO agences (nom_ville) VALUES ('Paris'), ('Lyon'), ('Marseille'), ('Bordeaux'), ('Nantes');
INSERT INTO employes (nom, prenom, email, password, role) VALUES ('Test', 'Prof', 'prof@test.fr', 'admin123', 'user');

-- Trajets par défaut pour l'affichage
INSERT INTO trajets (id_agence_depart, id_agence_arrivee, gdh_depart, places_totales, places_disponibles, id_conducteur) 
VALUES 
(1, 2, '2026-02-15 08:30:00', 4, 4, 1),
(2, 3, '2026-02-16 10:00:00', 3, 2, 1),
(4, 1, '2026-02-17 14:00:00', 4, 4, 1);