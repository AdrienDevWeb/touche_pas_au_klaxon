<?php
// 1. Démarrage de la session
session_start();

// 2. Définition de la racine du projet
define('ROOT', dirname(__DIR__));

// 3. Connexion à la base de données
require_once ROOT . '/config/db.php';

// 4. Récupération de la page demandée
$page = $_GET['page'] ?? 'home';

// 5. LOGIQUE DE CONNEXION
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM employes WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        $_SESSION['user'] = [
            'id' => $user['id_employe'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom']
        ];
        header('Location: index.php?page=home');
        exit;
    }
}

// 6. LOGIQUE D'ENREGISTREMENT D'UN TRAJET
if ($page === 'save_trajet' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // On vérifie que l'utilisateur est bien connecté
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    // Récupération des données du formulaire proposer.php
    $id_dep = $_POST['id_agence_depart'];
    $id_arr = $_POST['id_agence_arrivee'];
    $gdh_dep = $_POST['gdh_depart'];
    $places = $_POST['places_totales'];
    $id_cond = $_SESSION['user']['id'];

    // Insertion dans la base avec les bons noms de colonnes
    $sql = "INSERT INTO trajets (id_agence_depart, id_agence_arrivee, gdh_depart, gdh_arrivee, places_totales, places_disponibles, id_conducteur) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    // On met gdh_depart aussi pour gdh_arrivee pour l'instant, et on met les places dispo = places totales
    $stmt->execute([$id_dep, $id_arr, $gdh_dep, $gdh_dep, $places, $places, $id_cond]);

    header('Location: index.php?page=trajets');
    exit;
}

// 7. LOGIQUE DE DÉCONNEXION
if ($page === 'logout') {
    session_destroy();
    header('Location: index.php?page=home');
    exit;
}

// 8. AFFICHAGE DES VUES
require_once ROOT . '/src/Views/header.php';

switch ($page) {
    case 'home':
        ?>
        <main class='container mt-5'>
            <div class='p-5 mb-4 bg-light rounded-3 shadow-sm'>
                <div class='container-fluid py-5 text-center'>
                    <h1 class='display-5 fw-bold'>Touche pas au klaxon !</h1>
                    <?php if (isset($_SESSION['user'])): ?>
                        <p class='fs-4 text-success'>Ravi de vous revoir, <?= htmlspecialchars($_SESSION['user']['prenom']) ?> !</p>
                        <a href='index.php?page=proposer' class='btn btn-success btn-lg'>Proposer un trajet</a>
                        <a href='index.php?page=trajets' class='btn btn-primary btn-lg'>Voir les trajets</a>
                    <?php else: ?>
                        <p class='fs-4'>La plateforme de covoiturage interne pour nos agences.</p>
                        <a href='index.php?page=login' class='btn btn-primary btn-lg'>Connexion Employé</a>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        <?php
        break;

    case 'login':
        require_once ROOT . '/src/Views/login.php';
        break;

    case 'trajets':
        require_once ROOT . '/src/Views/trajets.php';
        break;

    case 'proposer':
        // Sécurité : seul un connecté peut proposer un trajet
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        require_once ROOT . '/src/Views/proposer.php';
        break;

    default:
        echo "<div class='container mt-5'><h1>404 - Page non trouvée</h1></div>";
        break;
}

require_once ROOT . '/src/Views/footer.php';