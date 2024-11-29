<?php
header("Content-Type: application/json; charset=UTF-8");
// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "projet_zoo";

$conn = new mysqli($server, $username, $password, $databaseName);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données JSON envoyées
    $rawData = $_POST['data'] ?? null;
    $data = json_decode($rawData, true);

    if (isset($data['email'], $data['password']) && !empty($data['email']) && !empty($data['password'])) {
        $email = htmlspecialchars($data['email']);
        $password = htmlspecialchars($data['password']);

        // Préparer et exécuter la requête SQL
        $stmt = $conn->prepare("SELECT id, prenom, nom, mdp FROM user WHERE email = $email LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($password === $user['mdp']) {
                // Générer un token simple (id utilisateur encodé en base64)
                $token = base64_encode(json_encode([
                    'id' => $user['id'],
                    'prenom' => $user['prenom'],
                    'nom' => $user['nom'],
                    'email' => $email
                ]));

                echo json_encode(['status' => 'success', 'token' => $token]);
                exit();
            } else {
                // Mot de passe incorrect
                echo json_encode(['status' => 'error', 'message' => 'Mot de passe incorrect.']);
                exit();
            }
        } else {
            // Utilisateur non trouvé
            echo json_encode(['status' => 'error', 'message' => 'Utilisateur non trouvé.']);
            exit();
        }
    } else {
        // Champs manquants
        echo json_encode(['status' => 'error', 'message' => 'Veuillez remplir tous les champs.']);
        exit();
    }
} 

$conn->close();
?>
