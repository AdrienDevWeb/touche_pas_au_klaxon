<?php include 'header.php'; ?>

<div class="container mt-5">
    <?php if (isset($_GET['reserved'])): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">✅ Réservation confirmée !</div>
    <?php endif; ?>

    <div class="text-center mb-5">
        <h2 class="fw-bold" style="color: var(--klaxon-dark);">Trajets à la une</h2>
        <div class="title-underline mx-auto"></div>
    </div>

    <div class="row justify-content-center">
        <?php foreach ($trajets as $trajet): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3" style="color: var(--klaxon-blue);">
                            <?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?>
                        </h5>
                        <p class="mb-2"><strong><?= date('d/m/Y à H:i', strtotime($trajet['gdh_depart'])) ?></strong></p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <span class="badge px-3 py-2" style="background-color: <?= $trajet['places_disponibles'] > 0 ? 'var(--klaxon-green)' : '#6c757d' ?>;">
                                <?= $trajet['places_disponibles'] ?> places libres
                            </span>
                            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $trajet['id_trajet'] ?>">Détails</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal<?= $trajet['id_trajet'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Détails du trajet</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <p><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['prenom_conducteur']) ?></p>
                            <p><strong>Places totales :</strong> <?= $trajet['places_totales'] ?></p>
                            <p><strong>État :</strong> <?= $trajet['places_disponibles'] > 0 ? 'Disponible' : 'Complet' ?></p>
                        </div>
                        <div class="modal-footer">
                            <?php if ($trajet['places_disponibles'] > 0): ?>
                                <a href="index.php?page=reserver&id=<?= $trajet['id_trajet'] ?>" class="btn btn-primary">Réserver ma place</a>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Complet</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'footer.php'; ?>