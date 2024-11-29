document.addEventListener("DOMContentLoaded", () => {
    // Gestion de la bascule entre Connexion et Inscription
    const switchToRegister = document.getElementById("switch-to-register");
    const switchToLogin = document.getElementById("switch-to-login");
    const wrapper = document.querySelector(".wrapper");

    // Basculer vers la section d'inscription
    switchToRegister.addEventListener("click", (event) => {
        event.preventDefault();
        wrapper.classList.add("hidden");
    });

    // Basculer vers la section de connexion
    switchToLogin.addEventListener("click", (event) => {
        event.preventDefault();
        wrapper.classList.remove("hidden");
    });

    // Formulaire de connexion
    const loginForm = document.querySelector(".login form");
    loginForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const formData = new FormData(loginForm);
        const email = formData.get("email");
        const password = formData.get("password");

        // Validation simple côté client
        if (!email || !password) {
            alert("Veuillez remplir tous les champs.");
            return;
        }

        try {
            const response = await fetch(loginForm.action, {
                method: "POST",
                body: formData,
            });

            const result = await response.json();
            if (result.success) {
                alert("Connexion réussie !");
                localStorage.setItem("user", JSON.stringify(result.user));
                window.location.href = "profil.html";
            } else {
                alert(result.message || "Erreur lors de la connexion.");
            }
        } catch (error) {
            console.error("Erreur :", error);
            alert("Une erreur est survenue. Veuillez réessayer.");
        }
    });

    // Formulaire d'inscription
    const registerForm = document.querySelector(".register form");
    registerForm.addEventListener("submit", async (event) => {
        event.preventDefault();

        const formData = new FormData(registerForm);
        const prenom = formData.get("prenom");
        const nom = formData.get("nom");
        const email = formData.get("email");
        const password = formData.get("password");

        // Validation simple côté client
        if (!prenom || !nom || !email || !password) {
            alert("Veuillez remplir tous les champs.");
            return;
        }

        try {
            const response = await fetch(registerForm.action, {
                method: "POST",
                body: formData,
            });

            const result = await response.json();
            if (result.success) {
                alert("Inscription réussie !");
                wrapper.classList.remove("hidden"); // Retour à la section connexion
            } else {
                alert(result.message || "Erreur lors de l'inscription.");
            }
        } catch (error) {
            console.error("Erreur :", error);
            alert("Une erreur est survenue. Veuillez réessayer.");
        }
    });
});
