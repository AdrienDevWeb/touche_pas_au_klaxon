<?php
// On démarre la session pour savoir si l'employé est connecté
session_start();

// Configuration des chemins (pour simplifier les inclusions)
define('ROOT', dirname(__DIR__));

// Le "Routeur" très simple
// On récupère la page demandée dans l'URL (ex: index.php?page=login)
$page = $_GET['page'] ?? 'home';

// On inclut le Header (le menu)
require_once ROOT . '/src/Views/header.php';

// On affiche le contenu selon la page
switch ($page) {
    case 'home':
        echo "<main class='container mt-5'><h1>Bienvenue chez Touche pas au klaxon !</h1><p>Trouvez votre trajet en un clic.</p></main>";
        break;
    case 'login':
        require_once ROOT . '/src/Views/login.php';
        break;
    default:
        echo "<h1>Page non trouvée</h1>";
        break;
}

// On inclut le Footer
require_once ROOT . '/src/Views/footer.php';