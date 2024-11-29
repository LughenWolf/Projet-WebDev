<?php
// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "projet zoo"; // Nom de la base de données

$conn = new mysqli($server, $username, $password, $databaseName);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion à la BDD échouée : " . $conn->connect_error);
}

$message = ""; // Variable pour stocker les messages

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire et les échapper pour éviter les injections SQL
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    
    // Vérification de l'existence de l'email
    $emailToCheck = $email;

    // Requête pour vérifier si l'email existe déjà
    $sql2 = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param("s", $emailToCheck);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification du résultat
    if ($result->num_rows > 0) {
        // Si l'email est déjà présent, définir un message spécifique
        $message = "L'email existe déjà dans la base de données.";
        echo $message;
        header("Location: ../connexion.html");
        exit; // Assurez-vous de stopper l'exécution après une redirection
    } else {
        // L'email n'existe pas, préparer et exécuter l'insertion des nouvelles données
        $sql = "INSERT INTO user (nom, prenom, email, mdp) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($sql);

        // Lier les paramètres pour l'insertion
        $insert_stmt->bind_param("ssss", $nom, $prenom, $email, $password);
        
        // Exécuter la requête d'insertion et vérifier le succès
        if ($insert_stmt->execute()) {
            $message = "Données ajoutées avec succès";
            header("Location: profil.html");
            exit;
        } else {
            $message = "Erreur lors de l'insertion : " . $conn->error;
        }

        // Fermer la requête d'insertion
        $insert_stmt->close();
    }

    // Fermer la requête de vérification
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>
