<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'projet zoo';
$username = 'root';
$password = '';

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => "Erreur de connexion : " . $e->getMessage()]);
    exit;
}

// Récupérer la liste des enclos et leurs détails pour un biome
if (isset($_POST['id_biome']) && !isset($_POST['id_enclos'])) {
    $id_biome = (int) $_POST['id_biome'];

    if ($id_biome <= 0) {
        echo json_encode(['success' => false, 'error' => "ID de biome invalide."]);
        exit;
    }

    try {
        $sql = "SELECT e.id_enclos, e.status, hr.heure_repas, hr.date_repas
                FROM enclos e
                LEFT JOIN horaire_repas hr ON e.id_enclos = hr.id_enclos
                WHERE e.id_biome = :id_biome";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_biome' => $id_biome]);
        $enclos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $enclos]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => "Erreur SQL : " . $e->getMessage()]);
    }
    exit;
}

// Récupérer les animaux pour un enclos spécifique
if (isset($_POST['id_enclos']) && !isset($_POST['heure_repas'])) {
    $id_enclos = (int) $_POST['id_enclos'];

    if ($id_enclos <= 0) {
        echo json_encode(['success' => false, 'error' => "ID d'enclos invalide."]);
        exit;
    }

    try {
        $sql = "SELECT a.nom FROM animaux a WHERE a.id_enclos = :id_enclos";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_enclos' => $id_enclos]);
        $animaux = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode(['success' => true, 'data' => $animaux]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => "Erreur SQL : " . $e->getMessage()]);
    }
    exit;
}

// Ajouter ou mettre à jour les horaires de repas et le statut d'un enclos
if (isset($_POST['id_enclos'], $_POST['status'], $_POST['heure_repas'], $_POST['date_repas'])) {
    $id_enclos = (int) $_POST['id_enclos'];
    $status = $_POST['status'];
    $heure_repas = $_POST['heure_repas'];
    $date_repas = $_POST['date_repas'];

    try {
        $pdo->beginTransaction();

        // Mettre à jour le statut de l'enclos
        $sql_enclos = "UPDATE enclos SET status = :status WHERE id_enclos = :id_enclos";
        $stmt = $pdo->prepare($sql_enclos);
        $stmt->execute(['status' => $status, 'id_enclos' => $id_enclos]);

        // Mettre à jour ou insérer les horaires de repas
        $sql_horaires = "INSERT INTO horaire_repas (id_enclos, heure_repas, date_repas) 
                         VALUES (:id_enclos, :heure_repas, :date_repas)
                         ON DUPLICATE KEY UPDATE heure_repas = :heure_repas, date_repas = :date_repas";
        $stmt = $pdo->prepare($sql_horaires);
        $stmt->execute([
            'id_enclos' => $id_enclos,
            'heure_repas' => $heure_repas,
            'date_repas' => $date_repas
        ]);

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => "Mise à jour réussie."]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => "Erreur SQL : " . $e->getMessage()]);
    }
    exit;
}

// Si aucune requête valide n'est reçue
echo json_encode(['success' => false, 'error' => "Aucune requête valide reçue."]);
?>
