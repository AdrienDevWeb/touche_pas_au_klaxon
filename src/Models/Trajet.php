<?php include 'header.php'; ?>
<div class="container mt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Trajets disponibles</h2>
        <div class="title-underline mx-auto"></div>
    </div>
    <div class="row">
        <?php foreach ($trajets as $t): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold text-primary"><?= $t['ville_depart'] ?> → <?= $t['ville_arrivee'] ?></h5>
                    <p class="small text-muted"><?= date('d/m/Y H:i', strtotime($t['gdh_depart'])) ?></p>
                    <p>Conducteur : <strong><?= $t['prenom_conducteur'] ?></strong></p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-success"><?= $t['places_disponibles'] ?> places</span>
                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#m<?= $t['id_trajet'] ?>">Détails</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="m<?= $t['id_trajet'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white"><h5>Confirmer la réservation</h5></div>
                    <div class="modal-body text-center py-4">
                        <p>Voulez-vous réserver une place pour <strong><?= $t['ville_depart'] ?></strong> ?</p>
                        <a href="index.php?page=reserver&id=<?= $t['id_trajet'] ?>" class="btn btn-success w-100">Réserver maintenant</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>