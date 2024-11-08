<!DOCTYPE html>
<?php
// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "projet zoo";

// Connexion à la base de données
$conn = new mysqli($server, $username, $password, $databaseName);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion à la BDD échouée");
}
?>
<HTML>
<head>
    
TEST
    </head>
    <body>
<form class="form">
<input type="nom" id="nom" placeholder="entrez votre nom" />
<br>
<input type="prenom" id="prenom" placeholder="entrez votre prenom" />
<br>
<input type="email" id="email" placeholder="Entrez votre email"/>
<br>
<input type="password" id="password" placeholder="Entrez votre mot de
 passe"/>
<br>
<button>s inscrire</button>
</form>
</body>
</html>
