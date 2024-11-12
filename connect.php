<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>

    <?php
    session_start(); // Démarrer la session

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
        // Vérifier que les champs 'email' et 'password' sont définis
        if (isset($_POST['email']) && isset($_POST['password'])) {
            // Récupérer les données envoyées via POST
            $email = $conn->real_escape_string($_POST['email']);
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
                    $_SESSION['user_id'] = $user['id_user']; // Enregistre l'ID de l'utilisateur dans la session
                    $_SESSION['user_email'] = $user['email']; // Enregistre l'email dans la session
                    
                    // Redirection vers une autre page si la connexion est réussie
                    header("Location: acces.html"); // Remplacez "acces.html" par la page de destination souhaitée
                    exit(); // Termine le script pour s'assurer que la redirection est immédiate
                } else {
                    // Mot de passe incorrect
                    $message = "Mot de passe incorrect.";
                }
            } else {
                // L'email n'est pas trouvé dans la base de données
                $message = "Aucun utilisateur trouvé avec cet email.";
            }
        } else {
            $message = "Veuillez remplir tous les champs.";
        }
    }

    $conn->close();
    ?>

    <!-- Affichage du message d'erreur si la connexion échoue -->
    <?php if (!empty($message)): ?>
        <p style="color: red;">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    

</body>
</html>
