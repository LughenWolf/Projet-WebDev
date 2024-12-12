$(document).ready(function () {
    // Fonction pour afficher les enclos en fonction du biome et du rôle utilisateur
    $(".biome-button").on("click", function () {
        const id_biome = $(this).data("id");
        $("#enclos-list").html("Chargement...");

        // Appel à l'API pour récupérer les enclos
        $.post("./back/affichage_animaux.php", { id_biome }, function (response) {
            if (response.success) {
                const isAdmin = response.role === "admin"; // Rôle utilisateur
                //const isAdmin=1;

                let content = `
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Enclos</th>
                                ${isAdmin ? '<th>Statut</th>' : ''}
                                ${isAdmin ? '<th>Horaires</th>' : ''}
                                ${isAdmin ? '<th>Actions</th>' : ''}
                                <th>Animaux</th>
                                <th>Carrousel</th>
                            </tr>
                        </thead>
                        <tbody>`;
                
                // Parcourir les enclos et générer les lignes du tableau
                response.data.forEach(enclos => {
                    content += `
                        <tr>
                            <td>${enclos.id_enclos}</td>
                            ${isAdmin ? `
                                <td>
                                    <select class="status" data-id="${enclos.id_enclos}">
                                        <option value="open" ${enclos.status === 'open' ? 'selected' : ''}>Ouvert</option>
                                        <option value="close" ${enclos.status === 'close' ? 'selected' : ''}>Fermé</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="time" class="heure-repas" data-id="${enclos.id_enclos}" value="${enclos.heure_repas || ''}">
                                    <input type="date" class="date-repas" data-id="${enclos.id_enclos}" value="${enclos.date_repas || ''}">
                                </td>
                                <td>
                                    <button class="update-enclos btn btn-primary" data-id="${enclos.id_enclos}">Mettre à jour</button>
                                </td>
                            ` : ''}
                            <td>
                                <ul id="animal-list-${enclos.id_enclos}"></ul>
                            </td>
                            <td>
                                <div id="carousel-${enclos.id_enclos}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner" id="carousel-inner-${enclos.id_enclos}">
                                        <div class="carousel-item active">
                                            <img src="./media/images_animaux/default.jpg" class="d-block w-100" alt="Default">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                });
                
                content += "</tbody></table>";
                $("#enclos-list").html(content);

                // Charger les animaux pour chaque enclos
                response.data.forEach(enclos => {
                    $.post("./back/affichage_animaux.php", { id_enclos: enclos.id_enclos }, function (animalResponse) {
                        if (animalResponse.success) {
                            const animalList = $(`#animal-list-${enclos.id_enclos}`);
                            const carouselInner = $(`#carousel-inner-${enclos.id_enclos}`);
                            animalList.html(
                                animalResponse.data.map(a => `<li>${a}</li>`).join("")
                            );

                            // Ajouter les images des animaux au carrousel
                            const images = animalResponse.data.map((a, index) => `
                                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                    <img src="./media/images_animaux/${a}.jpg" class="d-block w-100" alt="${a}">
                                </div>
                            `).join("");

                            carouselInner.html(images);

                            // Activer le carrousel avec défilement automatique si plusieurs images
                            if (animalResponse.data.length > 1) {
                                $(`#carousel-${enclos.id_enclos}`).carousel({
                                    interval: 2000, // Temps entre les transitions en millisecondes
                                    ride: 'carousel'
                                });
                            }
                        } else {
                            alert("Erreur chargement animaux : " + animalResponse.error);
                        }
                    });
                });
            } else {
                $("#enclos-list").html("Erreur : " + response.error);
            }
        });
    });
});
