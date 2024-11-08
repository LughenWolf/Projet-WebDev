<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <form class="form" method="post" action="">
        <input type="email" name="email" id="email" placeholder="Entrez votre email" required />
        <br>
        <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required />
        <br>
        <button type="submit">SIGN IN</button>
    </form>

    <?php
    // Connexion à la base de données
    $server = "localhost";
    $username = "root";
    $password = "";
    $databaseName = "projet zoo"; // Corrigé

    $conn = new mysqli($server, $username, $password, $databaseName);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connexion à la BDD échouée : " . $conn->connect_error);
    }

    $message = ""; // Variable pour stocker les messages

    // Traitement du formulaire lors de la soumission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si les champs sont vides après soumission
        if (empty($_POST['email']) || empty($_POST['password'])) {
            // Si l'email ou le mot de passe est vide, afficher un message pour remplir les champs
            $message = "Veuillez remplir tous les champs.";
        } else {
            // Récupérer les données du formulaire et les échapper pour éviter les injections SQL
            $email = $conn->real_escape_string($_POST['email']);
            $password = $_POST['password'];

            // Requête pour récupérer l'utilisateur avec l'email donné
            $sql = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // L'email existe, on vérifie le mot de passe
                $user = $result->fetch_assoc();

                // Vérification du mot de passe (comparaison directe, car les mots de passe ne sont pas hachés)
                if ($password == $user['mdp']) {
                    // Si les informations sont correctes, on crée la session utilisateur
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
    }
    ?>

    <?php
    // Afficher le message uniquement après soumission du formulaire (avec méthode POST)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Affichage du message si celui-ci existe
        if (!empty($message)): 
    ?>
        <!-- Afficher le message avec une couleur appropriée -->
        <p style="color: <?php echo (strpos($message, 'réussie') !== false) ? 'green' : 'red'; ?>;">
            <?php echo $message; ?>
        </p>
    <?php 
        endif;
    }
    ?>
</body>
</html>
