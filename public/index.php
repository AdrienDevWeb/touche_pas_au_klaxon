<?php
session_start();
$root = dirname(__DIR__);
require_once $root . '/config/db.php';

$page = $_GET['page'] ?? 'trajets';

switch ($page) {
    case 'trajets':
        $sql = "SELECT t.*, ad.nom_ville as ville_depart, aa.nom_ville as ville_arrivee, e.prenom as prenom_conducteur 
                FROM trajets t
                JOIN agences ad ON t.id_agence_depart = ad.id_agence
                JOIN agences aa ON t.id_agence_arrivee = aa.id_agence
                JOIN employes e ON t.id_conducteur = e.id_employe
                ORDER BY t.gdh_depart ASC";
        $trajets = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        include $root . '/src/Views/trajets.php';
        break;

    case 'proposer':
        if (!isset($_SESSION['user'])) { header('Location: index.php?page=login'); exit; }
        $agences = $pdo->query("SELECT * FROM agences ORDER BY nom_ville")->fetchAll(PDO::FETCH_ASSOC);
        include $root . '/src/Views/proposer.php';
        break;

    case 'save_trajet':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $stmt = $pdo->prepare("INSERT INTO trajets (id_agence_depart, id_agence_arrivee, gdh_depart, places_totales, places_disponibles, id_conducteur) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['id_dep'], $_POST['id_arr'], $_POST['date'], $_POST['places'], $_POST['places'], $_SESSION['user']['id']]);
            header('Location: index.php?page=trajets');
        }
        break;

    case 'reserver':
        if (isset($_SESSION['user']) && isset($_GET['id'])) {
            $pdo->prepare("UPDATE trajets SET places_disponibles = places_disponibles - 1 WHERE id_trajet = ? AND places_disponibles > 0")->execute([$_GET['id']]);
        }
        header('Location: index.php?page=trajets');
        break;

    case 'login':
        include $root . '/src/Views/login.php';
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php');
        break;
}