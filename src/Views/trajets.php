<?php
// On récupère les trajets en joignant la table agences pour avoir les noms des villes
$query = "SELECT t.*, 
          dep.nom_ville AS ville_depart, 
          arr.nom_ville AS ville_arrivee 
          FROM trajets t
          JOIN agences dep ON t.id_agence_depart = dep.id_agence
          JOIN agences arr ON t.id_agence_arrivee = arr.nom_ville
          ORDER BY t.gdh_depart ASC";

$stmt = $pdo->query("SELECT t.*, ad.nom_ville as ville_dep, aa.nom_ville as ville_arr 
                     FROM trajets t 
                     JOIN agences ad ON t.id_agence_depart = ad.id_agence 
                     JOIN agences aa ON t.id_agence_arrivee = aa.id_agence");
$trajets = $stmt->fetchAll();
?>

<main class="container mt-5">
    <h1>Trajets entre agences</h1>
    <table class="table table-striped shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date / Heure</th>
                <th>Places</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trajets as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t['ville_dep']) ?></td>
                    <td><?= htmlspecialchars($t['ville_arr']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($t['gdh_depart'])) ?></td>
                    <td><?= $t['places_disponibles'] ?> / <?= $t['places_totales'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>