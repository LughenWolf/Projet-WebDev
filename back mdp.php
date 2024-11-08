<?php
// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "projet zoo"; // Suppression de l'espace dans le nom de la base de données

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
    $sq2 = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sq2);
    $stmt->bind_param("s", $emailToCheck);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification du résultat
    if ($result->num_rows > 0) {
        // Si l'email est déjà présent, définir un message spécifique
        $message = "L'email existe déjà dans la base de données.";
    } else {
        // L'email n'existe pas, préparer et exécuter l'insertion des nouvelles données
        $sql = "INSERT INTO user (nom, prenom, email, mdp) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($sql);
        
        // Lier les paramètres pour l'insertion
        $insert_stmt->bind_param("ssss", $nom, $prenom, $email, $password);
        
        // Exécuter la requête d'insertion et vérifier le succès
        if ($insert_stmt->execute()) {
            $message = "Données ajoutées avec succès";
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

<!-- Formulaire HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'inscription</title>
</head>
<body>
    <form class="form" method="post" action="">
        <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" required />
        <br>
        <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom" required />
        <br>
        <input type="email" name="email" id="email" placeholder="Entrez votre email" required />
        <br>
        <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required />
        <br>
        <button type="submit">SIGN UP</button>
    </form>

    <!-- Affichage du message uniquement si la variable $message n'est pas vide -->
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
