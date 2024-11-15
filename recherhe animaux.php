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

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire et les échapper pour éviter les injections SQL
    $animal = $conn->real_escape_string($_POST['animaux']);
    
    // Requête pour récupérer l'ID de l'enclos de l'animal
    $sql = "SELECT enclos.id_enclos 
            FROM animaux 
            INNER JOIN enclos ON animaux.id_enclos = enclos.id_enclos 
            WHERE animaux.nom LIKE '%$animal%' = '$animal'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si un enclos est trouvé, envoyer l'ID de l'enclos comme réponse
        $row = $result->fetch_assoc();
        echo $row['id_enclos']; // Envoie directement l'ID de l'enclos
    } else {
        // Envoie un message d'erreur en cas de problème
        echo "Aucun enclos trouvé pour cet animal.";
    }
}

// Fermer la connexion
$conn->close();
?>
