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
            window.location.href = 'profil.html';
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







