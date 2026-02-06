<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prépare la requête
    $stmt = $pdo->prepare("SELECT * FROM employes WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    


    if ($user && $password === $user['password']) {
        
        $_SESSION['user'] = [
            'id' => $user['id_employe'],
            'nom' => $user['nom'],
            'prenom' => $user['prenom'],
            'role' => $user['role']
        ];
        
        // Redirige vers les trajets
        header('Location: index.php?page=trajets');
        exit;
    } else {
        $error = "Identifiants incorrects (Vérifie l'email ou le mot de passe).";
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow border-0 p-4" style="border-radius: 15px;">
                <h3 class="text-center mb-4 fw-bold" style="color: var(--klaxon-blue);">Connexion</h3>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger small"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="prof@test.fr" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small">Mot de passe</label>
                        <input type="password" name="password" class="form-control" placeholder="admin123" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>