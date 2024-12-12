document.addEventListener("DOMContentLoaded", () => {
    const token = localStorage.getItem("token");

    if (!token) {
        alert("Vous devez être connecté pour accéder à cette page.");
        window.location.href = "connexion.html";
    } else {
        // Optionnel : Décoder et afficher les informations utilisateur
        const userData = JSON.parse(atob(token.split('.')[1])); // Exemple de décodage
        console.log("Utilisateur connecté :", userData);
        document.getElementById("userDisplay").textContent = `${userData.prenom} ${userData.nom}`;
    }
});