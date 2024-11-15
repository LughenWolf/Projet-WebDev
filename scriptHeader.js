
document.addEventListener("DOMContentLoaded", function () {
    const userDisplay = document.getElementById("userDisplay");
    const loginButton = document.getElementById("loginButton");

    // Vérifiez si l'utilisateur est déjà connecté
    const prenom = sessionStorage.getItem("prenom");
    const nom = sessionStorage.getItem("nom");

    if (prenom && nom) {
        // Si l'utilisateur est connecté, afficher son nom complet et masquer le bouton de connexion
        userDisplay.textContent = `${prenom} ${nom}`;
        loginButton.style.display = "none";
    } else {
        // Si non connecté, afficher le bouton de connexion
        loginButton.style.display = "inline";
    }
});

/*function handleLogin(prenom, nom) {
    // Enregistrer le prénom et nom dans la session
    sessionStorage.setItem("prenom", prenom);
    sessionStorage.setItem("nom", nom);

    // Rediriger ou mettre à jour l'interface après connexion
    document.getElementById("userDisplay").textContent = `${prenom} ${nom}`;
    document.getElementById("loginButton").style.display = "none";
}

// Exemple de déclenchement de la fonction handleLogin avec un prénom et un nom
// Appeler cette fonction après une connexion réussie en remplaçant les valeurs par celles de l'utilisateur connecté
handleLogin("Alice", "Dupont");*/