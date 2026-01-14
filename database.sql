-- Création de la table des agences (villes)
CREATE TABLE agences (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    nom_ville VARCHAR(100) NOT NULL
);

-- Création de la table des employés (données RH)
CREATE TABLE employes (
    id_employe INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20),
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user' -- 'user' ou 'admin' [cite: 16]
);

-- Création de la table des trajets 
CREATE TABLE trajets (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    id_agence_depart INT,
    id_agence_arrivee INT,
    gdh_depart DATETIME NOT NULL,
    gdh_arrivee DATETIME NOT NULL,
    places_totales INT NOT NULL,
    places_disponibles INT NOT NULL,
    id_conducteur INT,
    FOREIGN KEY (id_agence_depart) REFERENCES agences(id_agence),
    FOREIGN KEY (id_agence_arrivee) REFERENCES agences(id_agence),
    FOREIGN KEY (id_conducteur) REFERENCES employes(id_employe)
);

-- Insertion des agences (Annexe agences.txt)
INSERT INTO agences (nom_ville) VALUES 
('Paris'), ('Lyon'), ('Marseille'), ('Toulouse'), ('Nice'), 
('Nantes'), ('Strasbourg'), ('Montpellier'), ('Bordeaux'), 
('Lille'), ('Rennes'), ('Reims');