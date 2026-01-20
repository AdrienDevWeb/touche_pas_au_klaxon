<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon - Covoiturage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand { font-weight: bold; }
        .nav-link:hover { color: #198754 !important; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php?page=home">
            🎺 Touche pas au klaxon
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=home">Accueil</a>
                </li>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=trajets">Trajets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-info" href="index.php?page=proposer">Proposer un trajet</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <span class="navbar-text me-3">
                            👋 Bonjour, <strong><?= htmlspecialchars($_SESSION['user']['prenom']) ?></strong>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=logout" class="btn btn-sm btn-outline-danger">Déconnexion</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-3">
                        <a href="index.php?page=login" class="btn btn-sm btn-primary">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>