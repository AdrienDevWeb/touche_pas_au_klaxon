/**
 * Affiche la liste des trajets filtrés et triés selon le brief. [cite: 36, 59]
 * @var array $trajets Liste des trajets récupérés depuis le Model.
 */
?>
<main class="container py-5">
    <h2 class="text-info fw-bold mb-4">Trajets planifiés</h2>

    <div class="row g-4">
        <?php foreach ($trajets as $t): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-success"><?= $t['places_disponibles'] ?> places libres</span>
                            <small class="text-muted">ID: #<?= $t['id_trajet'] ?></small>
                        </div>
                        <h5 class="fw-bold text-info"><?= htmlspecialchars($t['ville_dep']) ?> → <?= htmlspecialchars($t['ville_arr']) ?></h5>
                        <p class="mb-1"><strong>Départ :</strong> <?= date('d/m/Y H:i', strtotime($t['gdh_depart'])) ?></p>
                        <p class="mb-3"><strong>Arrivée :</strong> <?= date('d/m/Y H:i', strtotime($t['gdh_arrivee'])) ?></p>

                        <?php if (isset($_SESSION['user'])): ?>
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#details<?= $t['id_trajet'] ?>">Plus de détails</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>