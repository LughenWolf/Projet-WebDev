<?php
// Connexion à la base de données
$host = '127.0.0.1';
$db = 'projet_zoo';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

// Récupérer les services pour le biome sélectionné
if (isset($_GET['id_biome'])) {
    $id_biome = (int)$_GET['id_biome'];
    $stmt = $pdo->prepare("SELECT DISTINCT nom FROM services WHERE id_biome = ?");
    $stmt->execute([$id_biome]);
    $services = $stmt->fetchAll();

    if ($services) {
        echo "<ul>";
        foreach ($services as $service) {
            echo "<li>" . htmlspecialchars($service['nom']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun service trouvé pour ce biome.</p>";
    }
} else {
    echo "<p>Veuillez sélectionner un biome.</p>";
}
?>
