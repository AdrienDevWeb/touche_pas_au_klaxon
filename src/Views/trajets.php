<?php
$sql = "SELECT t.*, dep.nom_ville AS ville_dep, arr.nom_ville AS ville_arr, emp.prenom AS conducteur
        FROM trajets t
        JOIN agences dep ON t.id_agence_depart = dep.id_agence
        JOIN agences arr ON t.id_agence_arrivee = arr.id_agence
        JOIN employes emp ON t.id_conducteur = emp.id_employe
        ORDER BY t.gdh_depart ASC";
$trajets = $pdo->query($sql)->fetchAll();
?>

<main class="container mt-5">
    <div class="d-flex justify-content-between mb-4">
        <h2>Trajets disponibles</h2>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="index.php?page=proposer" class="btn btn-success">Proposer un trajet</a>
        <?php endif; ?>
    </div>

    <table class="table table-striped shadow-sm bg-white">
        <thead class="table-dark">
            <tr>
                <th>Départ -> Arrivée</th>
                <th>Date / Heure</th>
                <th>Conducteur</th>
                <th>Places</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trajets as $t): ?>
                <tr>
                    <td><strong><?= $t['ville_dep'] ?></strong> → <strong><?= $t['ville_arr'] ?></strong></td>
                    <td><?= date('d/m/H:i', strtotime($t['gdh_depart'])) ?></td>
                    <td><span class="badge bg-light text-dark"><?= $t['conducteur'] ?></span></td>
                    <td><?= $t['places_disponibles'] ?> / <?= $t['places_totales'] ?></td>
                    <td>
                        <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($_SESSION['user']['id'] == $t['id_conducteur']): ?>
                                <a href="index.php?page=delete_trajet&id=<?= $t['id_trajet'] ?>" 
                                   class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                            <?php elseif ($t['places_disponibles'] > 0): ?>
                                <a href="index.php?page=reserver&id=<?= $t['id_trajet'] ?>" 
                                   class="btn btn-sm btn-outline-primary">Réserver</a>
                            <?php else: ?>
                                <span class="badge bg-secondary">Complet</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>