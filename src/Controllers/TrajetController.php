<?php
namespace App\Controllers;
use App\Models\Trajet;

class TrajetController {
    public function listTrajets($pdo) {
        $trajets = Trajet::getAll($pdo);
        require_once __DIR__ . '/../Views/trajets.php';
    }
}