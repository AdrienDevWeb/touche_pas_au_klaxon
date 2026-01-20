<?php
// On récupère les agences pour remplir les menus déroulants
$agences = $pdo->query("SELECT * FROM agences ORDER BY nom_ville ASC")->fetchAll();
?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Proposer un nouveau trajet</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?page=save_trajet" method="POST">
                        
                        <div class="mb-3">
                            <label class="form-label">Agence de départ</label>
                            <select name="id_agence_depart" class="form-select" required>
                                <option value="">Choisir une ville...</option>
                                <?php foreach($agences as $a): ?>
                                    <option value="<?= $a['id_agence'] ?>"><?= $a['nom_ville'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agence d'arrivée</label>
                            <select name="id_agence_arrivee" class="form-select" required>
                                <option value="">Choisir une ville...</option>
                                <?php foreach($agences as $a): ?>
                                    <option value="<?= $a['id_agence'] ?>"><?= $a['nom_ville'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date et heure de départ</label>
                                <input type="datetime-local" name="gdh_depart" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre de places totales</label>
                                <input type="number" name="places_totales" class="form-control" min="1" max="8" value="4" required>
                            </div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-success w-100">Publier le trajet sur Klaxon</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>