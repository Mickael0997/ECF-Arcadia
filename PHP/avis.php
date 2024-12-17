
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/avis.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Navbar Responsive</title>
</head>
<body>
<div class="bandeau-avis" id="bandeau-avis">
    <button id="toggle-avis-btn" class="toggle-avis-btn">▼</button>
    <ul id="avis-list"></ul>
</div>
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Sélection du conteneur de la liste des avis
    const avisList = document.getElementById('avis-list');
    const toggleAvisBtn = document.getElementById('toggle-avis-btn');
    const bandeauAvis = document.getElementById('bandeau-avis');

    // Données des avis
    const avisManuels = [
        { message: "Super expérience, les enfants ont adoré !", rating: 5, photo: "../ASSETS/profile1.jpg" },
        { message: "Beau parc mais un peu cher.", rating: 3, photo: "../ASSETS/profile2.jpg" },
        { message: "Très éducatif et bien entretenu.", rating: 4, photo: "../ASSETS/profile3.jpg" },
        { message: "Nous reviendrons avec plaisir !", rating: 5, photo: "../ASSETS/profile4.jpg" },
        { message: "Personnel très sympathique.", rating: 4, photo: "../ASSETS/profile5.jpg" },
        { message: "Bonne variété d'animaux.", rating: 4, photo: "../ASSETS/profile6.jpg" },
        { message: "Activités intéressantes pour les petits.", rating: 5, photo: "../ASSETS/profile7.jpg" },
        { message: "Parc très propre et bien organisé.", rating: 4, photo: "../ASSETS/profile8.jpg" },
        { message: "Excellente journée en famille.", rating: 5, photo: "../ASSETS/profile9.jpg" },
        { message: "Prix de la restauration un peu élevé.", rating: 3, photo: "../ASSETS/profile10.jpg" }
    ];

    // Fonction pour afficher un avis aléatoire
    function afficherAvisAleatoire(avis) {
        if (avisList) {
            avisList.innerHTML = ''; // Efface la liste actuelle
            const randomIndex = Math.floor(Math.random() * avis.length);
            const item = avis[randomIndex];

            const avisItem = document.createElement('li');
            const profileImg = document.createElement('img');
            profileImg.src = item.photo;
            profileImg.alt = "Photo de profil";

            // Créer un conteneur pour le texte de l'avis
            const avisTextContainer = document.createElement('span');
            const avisMessage = document.createElement('span');
            avisMessage.textContent = item.message;

            // Créer un conteneur pour les étoiles
            const avisStars = document.createElement('span');
            avisStars.textContent = ' ' + '⭐'.repeat(item.rating); // Ajoute les étoiles

            // Ajouter le message et les étoiles au conteneur de texte
            avisTextContainer.appendChild(avisMessage);
            avisTextContainer.appendChild(avisStars);

            // Ajoute l'image de profil et le texte au conteneur de l'avis
            avisItem.appendChild(profileImg);
            avisItem.appendChild(avisTextContainer);
            avisList.appendChild(avisItem);
        }
    }

    // Appel initial de la fonction pour afficher un avis
    afficherAvisAleatoire(avisManuels);

    // Afficher un avis aléatoire toutes les 3 secondes
    const avisInterval = setInterval(() => {
        afficherAvisAleatoire(avisManuels);
    }, 3000);

    // Fonction pour ouvrir/fermer le bandeau des avis
    toggleAvisBtn.addEventListener('click', function() {
        if (bandeauAvis.classList.contains('closed')) {
            bandeauAvis.classList.remove('closed');
            toggleAvisBtn.textContent = '▼';
            // Redémarrer l'affichage des avis
            clearInterval(avisInterval);
            setInterval(() => {
                afficherAvisAleatoire(avisManuels);
            }, 3000);
        } else {
            bandeauAvis.classList.add('closed');
            toggleAvisBtn.textContent = '▲';
            // Arrêter l'affichage des avis
            clearInterval(avisInterval);
        }
    });
});
</script>
</body>