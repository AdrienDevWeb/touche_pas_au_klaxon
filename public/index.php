<?php
session_start();
define('ROOT', dirname(__DIR__));
require_once ROOT . '/config/db.php';

$page = $_GET['page'] ?? 'home';

// --- LOGIQUE : CONNEXION ---
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch();

    if ($user && $_POST['password'] === $user['password']) {
        $_SESSION['user'] = ['id' => $user['id_employe'], 'nom' => $user['nom'], 'prenom' => $user['prenom']];
        header('Location: index.php?page=home');
        exit;
    }
}

// --- LOGIQUE : ENREGISTRER UN TRAJET ---
if ($page === 'save_trajet' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    if ($_POST['id_agence_depart'] === $_POST['id_agence_arrivee']) {
        die("Erreur : Départ et arrivée identiques.");
    }
    $sql = "INSERT INTO trajets (id_agence_depart, id_agence_arrivee, gdh_depart, gdh_arrivee, places_totales, places_disponibles, id_conducteur) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$_POST['id_agence_depart'], $_POST['id_agence_arrivee'], $_POST['gdh_depart'], $_POST['gdh_depart'], $_POST['places_totales'], $_POST['places_totales'], $_SESSION['user']['id']]);
    header('Location: index.php?page=trajets');
    exit;
}

// --- LOGIQUE : RÉSERVER ---
if ($page === 'reserver' && isset($_GET['id']) && isset($_SESSION['user'])) {
    $sql = "UPDATE trajets SET places_disponibles = places_disponibles - 1 WHERE id_trajet = ? AND places_disponibles > 0";
    $pdo->prepare($sql)->execute([$_GET['id']]);
    header('Location: index.php?page=trajets');
    exit;
}

// --- LOGIQUE : SUPPRIMER (CRUD - Delete) ---
if ($page === 'delete_trajet' && isset($_GET['id']) && isset($_SESSION['user'])) {
    // Sécurité : on vérifie que c'est bien le trajet de l'utilisateur
    $sql = "DELETE FROM trajets WHERE id_trajet = ? AND id_conducteur = ?";
    $pdo->prepare($sql)->execute([$_GET['id'], $_SESSION['user']['id']]);
    header('Location: index.php?page=trajets');
    exit;
}

// --- LOGIQUE : DÉCONNEXION ---
if ($page === 'logout') {
    session_destroy();
    header('Location: index.php?page=home');
    exit;
}

// --- AFFICHAGE ---
require_once ROOT . '/src/Views/header.php';
switch ($page) {
    case 'home':
        echo "<main class='container mt-5 text-center'><div class='p-5 bg-white shadow rounded'><h1>Touche pas au klaxon !</h1>";
        if(isset($_SESSION['user'])) {
            echo "<p class='text-success'>Bonjour {$_SESSION['user']['prenom']}</p><a href='index.php?page=trajets' class='btn btn-primary'>Voir les trajets</a>";
        } else {
            echo "<a href='index.php?page=login' class='btn btn-primary'>Connexion</a>";
        }
        echo "</div></main>";
        break;
    case 'login': require_once ROOT . '/src/Views/login.php'; break;
    case 'trajets': require_once ROOT . '/src/Views/trajets.php'; break;
    case 'proposer': require_once ROOT . '/src/Views/proposer.php'; break;
    default: echo "404 Not Found"; break;
}
require_once ROOT . '/src/Views/footer.php';