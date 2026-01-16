<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon - Covoiturage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background-color: #f1f8fc;">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #384050;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                🎺 Touche pas au klaxon
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item ms-lg-3">
                            <span class="nav-link text-info">
                                👋 Bonjour, <strong><?= htmlspecialchars($_SESSION['user']['prenom']) ?></strong>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger btn-sm ms-lg-2" href="index.php?page=logout">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-primary btn-sm" href="index.php?page=login">Espace Employé</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">