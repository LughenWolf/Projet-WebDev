<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>

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
        // Récupérer les données envoyées via POST
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Requête pour récupérer l'utilisateur avec l'email donné
        $sql = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // L'email existe, on vérifie le mot de passe
            $user = $result->fetch_assoc();

            // Vérification du mot de passe (comparaison directe)
            if ($password == $user['mdp']) {
                // Création de la session utilisateur
                session_start();
                $_SESSION['user_id'] = $user['id_user']; // Enregistre l'ID de l'utilisateur dans la session
                $_SESSION['user_email'] = $user['email']; // Enregistre l'email dans la session
                
                // Message de connexion réussie
                $message = "Connexion réussie";
            } else {
                // Mot de passe incorrect
                $message = "Mot de passe incorrect.";
            }
        } else {
            // L'email n'est pas trouvé dans la base de données
            $message = "Aucun utilisateur trouvé avec cet email.";
        }
    }

    $conn->close();
    ?>

    <!-- Affichage du message avec couleur -->
    <?php if (!empty($message)): ?>
        <p style="color: <?php echo (strpos($message, 'réussie') !== false) ? 'green' : 'red'; ?>;">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

</body>
</html>
