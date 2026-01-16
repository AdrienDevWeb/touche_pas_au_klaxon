<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Connexion Employé</h4>
                </div>
                <div class="card-body">
                    <form action="index.php?page=login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email professionnel</label>
                            <input type="email" name="email" class="form-control" id="email" required placeholder="adrien@klaxon.fr">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>