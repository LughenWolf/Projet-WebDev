<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'inscription</title>
</head>
<body>

<?php
// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "projet zoo";

$conn = new mysqli($server, $username, $password, $databaseName);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion à la BDD échouée : " . $conn->connect_error);
}

// Traitement du formulaire lors de la soumission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']); // 

    // Requête d'insertion
    $sql = "INSERT INTO user nom,prenom,email,mdp) VALUES ('$nom', '$prenom', '$email', '$password')";

    // Exécuter la requête et vérifier le succès
    if ($conn->query($sql) === TRUE) {
        echo "Données ajoutées avec succès";
    } else {
        echo "Erreur lors de l'insertion : " . $conn->error;
    }
}

?>

<!-- Formulaire HTML -->
<form class="form" method="post" action="">
    <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" required />
    <br>
    <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom" required />
    <br>
    <input type="email" name="email" id="email" placeholder="Entrez votre email" required />
    <br>
    <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required />
    <br>
    <button type="submit">SIGN IN</button>
</form>

</body>
</html>
