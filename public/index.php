<?php
// 1. Démarrage de la session pour garder l'utilisateur connecté
session_start();

// 2. Configuration des chemins
define('ROOT', dirname(__DIR__));

// 3. Connexion à la base de données (via le fichier config créé précédemment)
require_once ROOT . '/config/db.php';

// 4. Récupération de la page demandée (par défaut 'home')
$page = $_GET['page'] ?? 'home';

// 5. LOGIQUE DE CONNEXION : Si on soumet le formulaire de login
if ($page === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // On prépare la requête pour trouver l'employé par son email
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // On vérifie si l'utilisateur existe et si le mot de passe est correct
    // (Note : on utilise le mot de passe "1234" que tu as mis dans HeidiSQL)
    if ($user && $password === $user['password']) {
        $_SESSION['user'] = [
            'id' => $user['id_employe'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'role' => $user['role']
        ];
        // Redirection vers l'accueil après connexion réussie
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

// 7. AFFICHAGE DES VUES (Le squelette HTML)
require_once ROOT . '/src/Views/header.php';

// Le Switcher de contenu
switch ($page) {
    case 'home':
        echo "<main class='container mt-5'>
                <div class='p-5 mb-4 bg-light rounded-3'>
                    <div class='container-fluid py-5'>
                        <h1 class='display-5 fw-bold'>Bienvenue chez Touche pas au klaxon !</h1>";
        
        if (isset($_SESSION['user'])) {
            echo "<p class='col-md-8 fs-4 text-success'>Ravi de vous revoir, " . $_SESSION['user']['prenom'] . " !</p>";
        } else {
            echo "<p class='col-md-8 fs-4'>Trouvez votre trajet en un clic ou proposez le vôtre.</p>";
        }
        
        echo "      </div>
                </div>
              </main>";
        break;

    case 'login':
        require_once ROOT . '/src/Views/login.php';
        break;

    default:
        echo "<div class='container mt-5'><h1>404 - Page non trouvée</h1></div>";
        break;
}

require_once ROOT . '/src/Views/footer.php';