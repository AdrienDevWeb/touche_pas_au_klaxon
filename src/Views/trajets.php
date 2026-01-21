<?php
// On récupère les trajets avec les noms des villes ET le prénom du conducteur
// On fait 2 JOIN sur 'agences' (un pour le départ, un pour l'arrivée)
// ET 1 JOIN sur 'employes' pour le conducteur
$sql = "SELECT t.*, 
               dep.nom_ville AS ville_dep, 
               arr.nom_ville AS ville_arr,
               emp.prenom AS conducteur
        FROM trajets t
        JOIN agences dep ON t.id_agence_depart = dep.id_agence
        JOIN agences arr ON t.id_agence_arrivee = arr.id_agence
        JOIN employes emp ON t.id_conducteur = emp.id_employe
        ORDER BY t.gdh_depart ASC";

$stmt = $pdo->query($sql);
$trajets = $stmt->fetchAll();
?>

<main class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Trajets disponibles</h1>
        <a href="index.php?page=proposer" class="btn btn-success">Proposer un trajet</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover shadow-sm bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Date / Heure</th>
                    <th>Conducteur</th>
                    <th>Places</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($trajets) > 0): ?>
                    <?php foreach ($trajets as $t): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?= htmlspecialchars($t['ville_dep']) ?></td>
                            <td class="fw-bold text-success"><?= htmlspecialchars($t['ville_arr']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($t['gdh_depart'])) ?></td>
                            <td>
                                <span class="badge bg-secondary">
                                    👤 <?= htmlspecialchars($t['conducteur']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($t['places_disponibles'] > 0): ?>
                                    <span class="text-success fw-bold"><?= $t['places_disponibles'] ?></span> / <?= $t['places_totales'] ?>
                                <?php else: ?>
                                    <span class="text-danger fw-bold">COMPLET</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($t['places_disponibles'] > 0 && isset($_SESSION['user']) && $_SESSION['user']['id'] !== $t['id_conducteur']): ?>
                                    <a href="index.php?page=reserver&id=<?= $t['id_trajet'] ?>" class="btn btn-sm btn-outline-primary">Réserver</a>
                                <?php elseif (isset($_SESSION['user']) && $_SESSION['user']['id'] === $t['id_conducteur']): ?>
                                    <span class="badge bg-info text-dark">Mon trajet</span>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" disabled>Indisponible</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Aucun trajet n'est disponible pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>