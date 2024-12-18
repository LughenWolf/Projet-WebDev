<?php
// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "projet zoo"; // Nom de la base de données
session_start();
$conn = new mysqli($server, $username, $password, $databaseName);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion à la BDD échouée : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que le champ 'animaux' est défini
    if (!isset($_POST['animaux']) || empty($_POST['animaux'])) {
        echo json_encode(["error" => "Le champ 'animaux' est vide ou non défini."]);
        exit();
    }

    // Récupérer les données du formulaire et les échapper pour éviter les injections SQL
    $animal = $conn->real_escape_string($_POST['animaux']);
    
    // Requête pour récupérer les IDs liés aux tables
    $sql = "
        SELECT 
            enclos.id_enclos, 
            animaux.id_animaux, 
            biome.id_biome,
            biome.nom AS biome_nom
        FROM animaux
        INNER JOIN enclos ON animaux.id_enclos = enclos.id_enclos
        INNER JOIN biome ON enclos.id_biome = biome.id_biome
        WHERE animaux.nom LIKE '%$animal%'
    ";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Si des résultats sont trouvés, les convertir en JSON
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                "id_enclos" => $row['id_enclos'],
                "id_animal" => $row['id_animaux'],
                "id_biome" => $row['id_biome'],
                "biome_nom" => $row['biome_nom']
            ];
        }
        // Envoyer les résultats au format JSON
        echo json_encode($data);
    } else {
        // Aucun résultat trouvé
        echo json_encode(["error" => "Aucun résultat trouvé pour cet animal."]);
    }
}
echo json_encode($_SESSION['user_role'] );
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status=$conn->real_escape_string($_POST['status']);
    $sq2 = "UPDATE enclosures SET status = ? WHERE id = ?";

    // Préparer et exécuter la requête sécurisée
    $stmt = $conn->prepare($sq2);
    $stmt->bind_param("si", $status, $id_enclos);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $horaire=$conn->real_escape_string($_POST['horaire']);
    $date=$conn->real_escape_string($_POST['date']);
    $sq3 = "UPDATE horaire_repas SET heure_repas = ?, date_repas = ? WHERE id_enclos = ?";

    // Préparer et exécuter la requête sécurisée
    $stmt = $conn->prepare($sq3);
    $stmt->bind_param("ssi", $horaire, $date, $id_enclos);
}
$conn->close();
?>
