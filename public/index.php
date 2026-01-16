<?php
// 1. Démarrage de la session pour la gestion de l'utilisateur connecté
session_start();

// 2. Définition de la racine du projet pour faciliter les inclusions
define('ROOT', dirname(__DIR__));

// 3. Connexion à la base de données
require_once ROOT . '/config/db.php';

// 4. Récupération de la page demandée (par défaut 'home')
$page = $_GET['page'] ?? 'home';

// 5. LOGIQUE DE CONNEXION (Traitement du formulaire)
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Recherche de l'employé dans la base
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe (en texte clair pour l'instant comme dans HeidiSQL)
    if ($user && $password === $user['password']) {
        $_SESSION['user'] = [
            'id' => $user['id_employe'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'role' => $user['role']
        ];
        header('Location: index.php?page=home');
        exit;
    } else {
        $error = "Identifiants incorrects !";
    }
}

// 6. LOGIQUE DE DÉCONNEXION
if ($page === 'logout') {
    session_destroy();
    header('Location: index.php?page=home');
    exit;
}

// 7. STRUCTURE D'AFFICHAGE (Vue)
require_once ROOT . '/src/Views/header.php';

// Aiguillage vers le contenu de la page demandée
switch ($page) {
    case 'home':
        echo "<main class='container mt-5'>
                <div class='p-5 mb-4 bg-light rounded-3 shadow-sm'>
                    <div class='container-fluid py-5'>
                        <h1 class='display-5 fw-bold text-dark'>Bienvenue chez Touche pas au klaxon !</h1>";
        
        if (isset($_SESSION['user'])) {
            // Message personnalisé si connecté
            echo "<p class='col-md-8 fs-4 text-success'>Ravi de vous revoir, " . htmlspecialchars($_SESSION['user']['prenom']) . " !</p>";
            echo "<a href='index.php?page=trajets' class='btn btn-primary btn-lg'>Voir les trajets</a>";
        } else {
            // Message standard
            echo "<p class='col-md-8 fs-4'>Simplifiez vos déplacements professionnels entre agences.</p>";
            echo "<a href='index.php?page=login' class='btn btn-primary btn-lg'>Espace Employé</a>";
        }
        
        echo "      </div>
                </div>
              </main>";
        break;

    case 'login':
        // Charge le formulaire de connexion
        require_once ROOT . '/src/Views/login.php';
        break;

    case 'trajets':
        // Charge la nouvelle page de liste des trajets
        require_once ROOT . '/src/Views/trajets.php';
        break;

    default:
        // Page d'erreur si l'URL est inconnue
        echo "<div class='container mt-5'><h1>404 - Page non trouvée</h1></div>";
        break;
}

require_once ROOT . '/src/Views/footer.php';