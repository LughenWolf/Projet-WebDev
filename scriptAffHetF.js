fetch('header.html')
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur dans le chargement du header");
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('header').innerHTML = data;
        })
        .catch(error => console.error(error));

fetch('footer.html')
        .then(response => {
            if (!response.ok) {
                throw new Error("Erreur dans le chargement du footer");
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('footer').innerHTML = data;
        })
        .catch(error => console.error(error));