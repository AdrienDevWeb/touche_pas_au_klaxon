<?php
// 1. DÉMARRAGE DE LA SESSION
session_start();

// 2. CONFIGURATION ET CONNEXION
define('ROOT', dirname(__DIR__));
require_once ROOT . '/config/db.php';

// 3. RÉCUPÉRATION DE LA PAGE
$page = $_GET['page'] ?? 'home';

// ---------------------------------------------------------
// 4. LOGIQUE DE TRAITEMENT (CONTROLEUR)
// ---------------------------------------------------------

// --- CONNEXION ---
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

// --- ENREGISTREMENT D'UN TRAJET ---
if ($page === 'save_trajet' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $id_dep = $_POST['id_agence_depart'];
    $id_arr = $_POST['id_agence_arrivee'];
    $gdh_dep = $_POST['gdh_depart'];
    $places = $_POST['places_totales'];
    $id_cond = $_SESSION['user']['id'];

    if ($id_dep === $id_arr) {
        die("Erreur : La ville de départ doit être différente de l'arrivée.");
    }

    $sql = "INSERT INTO trajets (id_agence_depart, id_agence_arrivee, gdh_depart, gdh_arrivee, places_totales, places_disponibles, id_conducteur) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_dep, $id_arr, $gdh_dep, $gdh_dep, $places, $places, $id_cond]);

    header('Location: index.php?page=trajets');
    exit;
}

// --- LOGIQUE DE RÉSERVATION ---
if ($page === 'reserver' && isset($_GET['id'])) {
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $id_trajet = $_GET['id'];
    
    // On retire 1 place uniquement s'il en reste (sécurité SQL)
    $sql = "UPDATE trajets SET places_disponibles = places_disponibles - 1 
            WHERE id_trajet = ? AND places_disponibles > 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_trajet]);

    header('Location: index.php?page=trajets');
    exit;
}

// --- DÉCONNEXION ---
if ($page === 'logout') {
    session_destroy();
    header('Location: index.php?page=home');
    exit;
}

// ---------------------------------------------------------
// 5. AFFICHAGE DES VUES
// ---------------------------------------------------------
require_once ROOT . '/src/Views/header.php';

switch ($page) {
    case 'home':
        ?>
        <main class='container mt-5 text-center'>
            <div class='p-5 mb-4 bg-light rounded-3 shadow-sm border'>
                <h1 class='display-5 fw-bold'>Touche pas au klaxon !</h1>
                <?php if (isset($_SESSION['user'])): ?>
                    <p class='fs-4 text-success'>Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) ?> !</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href='index.php?page=trajets' class='btn btn-primary btn-lg'>Voir les trajets</a>
                        <a href='index.php?page=proposer' class='btn btn-success btn-lg'>Proposer un trajet</a>
                    </div>
                <?php else: ?>
                    <p class='fs-4'>Le covoiturage simple pour les agences Klaxon.</p>
                    <a href='index.php?page=login' class='btn btn-primary btn-lg'>Connexion</a>
                <?php endif; ?>
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
        require_once ROOT . '/src/Views/proposer.php';
        break;

    case 'reserver':
        // La logique est traitée en haut, on redirige juste si besoin
        header('Location: index.php?page=trajets');
        break;

    default:
        echo "<div class='container mt-5'><h1>404 - Page non trouvée</h1></div>";
        break;
}

require_once ROOT . '/src/Views/footer.php';