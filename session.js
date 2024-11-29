//NE PAS TOUCHER !!!!!!!!!!
document.getElementById("switch-to-register").addEventListener('click', (event)=>{
    event.preventDefault();
    document.querySelector(".wrapper").classList.add("hidden");
})
document.getElementById("switch-to-login").addEventListener('click', (event)=>{
    event.preventDefault();
    document.querySelector(".wrapper").classList.remove("hidden");
})
//NE PAS TOUCHER !!!!!!!!!!


/*document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#login-form");

    if (form) {
        console.log("Formulaire trouvé. Attachement de l'événement...");
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const email = document.querySelector("#email");
            const password = document.querySelector("#password");

            if (!email || !password) {
                alert("Les champs email et mot de passe sont requis.");
                return;
            }

            const emailValue = email.value.trim();
            const passwordValue = password.value.trim();

            if (!emailValue || !passwordValue) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            try {
                const response = await fetch("http://localhost/projet/back/connexion.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ email: emailValue, password: passwordValue }),
                });

                const data = await response.json();

                if (data.token) {
                    localStorage.setItem("token", data.token);
                    window.location.href = "profil.html";
                } else {
                    alert(data.error || "Erreur lors de la connexion.");
                }
            } catch (error) {
                console.error("Erreur lors de la connexion :", error);
                alert("Une erreur est survenue. Veuillez réessayer.");
            }
        });
    } else {
        console.error("Formulaire introuvable !");
    }
});*/

document.querySelector('#login-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const email = formData.get('email');
    const password = formData.get('password');
    const errorMessage = document.getElementById('error-message'); // Message d'erreur

    try {
        const response = await fetch('http://localhost/projet/back/connexion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response;
        console.log(data);

        if (data.status === 200) {
            // Stocker le token
            localStorage.setItem('token', data.token);
            alert('Connexion réussie');
            location.reload(); // Recharger ou rediriger
        } else {
            // Afficher le message d'erreur sur place
            errorMessage.textContent = data.message;
            errorMessage.style.display = 'block';
        }
    } catch (error) {
        console.log(errorMessage);
        console.error('Erreur lors de la connexion :', error);
        errorMessage.textContent = 'Erreur interne. Veuillez réessayer.';
        errorMessage.style.display = 'block';
    }
});





