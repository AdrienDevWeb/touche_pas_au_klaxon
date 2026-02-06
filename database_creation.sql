-- Création de la table des agences (villes) [cite: 16]
CREATE TABLE IF NOT EXISTS agences (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    nom_ville VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Création de la table des employés (issus du système RH) [cite: 23]
CREATE TABLE IF NOT EXISTS employes (
    id_employe INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    role ENUM('employe', 'admin') DEFAULT 'employe'
) ENGINE=InnoDB;

-- Création de la table des trajets [cite: 17]
CREATE TABLE IF NOT EXISTS trajets (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    id_agence_dep INT NOT NULL,
    id_agence_arr INT NOT NULL,
    gdh_depart DATETIME NOT NULL,
    gdh_arrivee DATETIME NOT NULL,
    places_totales INT NOT NULL,
    places_disponibles INT NOT NULL,
    id_auteur INT NOT NULL,
    FOREIGN KEY (id_agence_dep) REFERENCES agences(id_agence),
    FOREIGN KEY (id_agence_arr) REFERENCES agences(id_agence),
    FOREIGN KEY (id_auteur) REFERENCES employes(id_employe)
) ENGINE=InnoDB;