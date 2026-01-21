<?php
// 1. VERROU DE SÉCURITÉ : On vérifie si l'utilisateur est connecté
// Si la session n'existe pas, on redirige immédiatement vers la page de connexion
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// 2. RÉCUPÉRATION DES DONNÉES : On va chercher les agences pour remplir le formulaire
try {
    $agences = $pdo->query("SELECT * FROM agences ORDER BY nom_ville ASC")->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des agences : " . $e->getMessage());
}
?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white py-3">
                    <h3 class="mb-0 text-center">Proposer un nouveau trajet</h3>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">
                        Remplissez les informations ci-dessous pour partager votre trajet avec vos collègues.
                    </p>

                    <form action="index.php?page=save_trajet" method="POST">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ville de départ</label>
                                <select name="id_agence_depart" class="form-select" required>
                                    <option value="" disabled selected>Choisir une ville...</option>
                                    <?php foreach($agences as $a): ?>
                                        <option value="<?= $a['id_agence'] ?>"><?= htmlspecialchars($a['nom_ville']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ville d'arrivée</label>
                                <select name="id_agence_arrivee" class="form-select" required>
                                    <option value="" disabled selected>Choisir une ville...</option>
                                    <?php foreach($agences as $a): ?>
                                        <option value="<?= $a['id_agence'] ?>"><?= htmlspecialchars($a['nom_ville']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Date et heure de départ</label>
                                <input type="datetime-local" name="gdh_depart" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Places disponibles</label>
                                <input type="number" name="places_totales" class="form-control" min="1" max="8" value="4" required>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 small">
                            <strong>Note :</strong> En publiant ce trajet, vous apparaissez comme le conducteur référent (<?= htmlspecialchars($_SESSION['user']['prenom']) ?>).
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Publier l'annonce</button>
                            <a href="index.php?page=trajets" class="btn btn-link text-secondary">Annuler et revenir à la liste</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>