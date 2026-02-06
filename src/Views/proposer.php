<?php include 'header.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 card shadow border-0 p-4">
            <h2 class="text-center mb-4">Proposer un trajet</h2>
            <form action="index.php?page=save_trajet" method="POST">
                <div class="mb-3">
                    <label>Départ</label>
                    <select name="id_dep" class="form-select">
                        <?php foreach ($agences as $a): ?> <option value="<?= $a['id_agence'] ?>"><?= $a['nom_ville'] ?></option> <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Arrivée</label>
                    <select name="id_arr" class="form-select">
                        <?php foreach ($agences as $a): ?> <option value="<?= $a['id_agence'] ?>"><?= $a['nom_ville'] ?></option> <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Date</label>
                    <input type="datetime-local" name="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nombre de places</label>
                    <input type="number" name="places" class="form-control" min="1" max="8" value="4">
                </div>
                <button type="submit" class="btn btn-primary w-100">Publier</button>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>