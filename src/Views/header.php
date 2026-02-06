<?php
/**
 * Header global de l'application.
 * Contient la navigation et la charte graphique Klaxon.
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klaxon - Covoiturage d'entreprise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --klaxon-blue: #0074c7;      
            --klaxon-dark: #00497c;      
            --klaxon-gray: #384050;      
            --klaxon-green: #82b864;     
            --klaxon-bg: #f1f8fc;        
        }

        body { 
            background-color: var(--klaxon-bg); 
            color: var(--klaxon-gray);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar { 
            background-color: var(--klaxon-dark) !important; 
        }

        .btn-primary { 
            background-color: var(--klaxon-blue) !important; 
            border: none; 
        }

        .btn-success, .bg-success { 
            background-color: var(--klaxon-green) !important; 
            border: none; 
        }

        /* Style pour le titre et le trait bleu */
        .text-info { color: var(--klaxon-dark) !important; }
        .title-underline {
            width: 60px;
            height: 4px;
            background-color: var(--klaxon-blue);
            border-radius: 2px;
            margin: 0 auto 30px;
        }

        footer {
            background-color: var(--klaxon-gray) !important;
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">KLAXON</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto">
                <?php 
                
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 'trajets'; 
                ?>
                
                <a class="nav-link <?= ($currentPage == 'trajets') ? 'active' : '' ?>" href="index.php?page=trajets">Trajets</a>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <a class="nav-link <?= ($currentPage == 'proposer') ? 'active' : '' ?>" href="index.php?page=proposer">Proposer</a>
                    <a class="nav-link btn btn-outline-light btn-sm ms-lg-3" href="index.php?page=logout">Déconnexion</a>
                <?php else: ?>
                    <a class="nav-link <?= ($currentPage == 'login') ? 'active' : '' ?>" href="index.php?page=login">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>