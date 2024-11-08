<!DOCTYPE html>
<html>
<head>
    <title>connexion</title>
</head>
<body>
    <form class="form" method="post" action="">
        <input type="email" name="email" id="email" placeholder="Entrez votre email" required />
        <br>
        <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required />
        <br>
        <button type="submit">SING IN </button>
    </form>
    </body>
    </html>
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
    $nom = $conn->real_escape_string($_POST['mail']);
    $prenom = $conn->real_escape_string($_POST['password']);
?>
