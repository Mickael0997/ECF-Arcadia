// Fonctions burger menu button open

const burgerMenuButton = document.querySelector('.burger-menu-button')
const burgerMenuButtonIcon = document.querySelector('.burger-menu-button i')
const burgerMenu = document.querySelector('.burger-menu')

// Ouverture au click
burgerMenuButton.onclick = function(){
    burgerMenu.classList.toggle('open');
    const isOpen = burgerMenu.classList.contains('open');
    burgerMenuButtonIcon.classList = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'
}

// gestion de l'affichage

document.addEventListener("DOMContentLoaded", function() {
    burgerMenuButton.addEventListener("click", function() {
        burgerMenu.classList.toggle("show");
    });
});

//------------------------------------------------------------------------------------------------



// ---------- AFFICHAGE POPUP POUR AVIS ----------
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('popup');
    const btn = document.getElementById("open-popup-btn");
    const span = document.getElementById("close-popup-btn");

    // Vérifiez que btn et span ne sont pas null avant de les utiliser
    if (btn) {
        btn.addEventListener('click', function() {
            // Ouvre le popup
            popup.style.display = "block";
        });
    }

    if (span) {
        span.addEventListener('click', function() {
            // Ferme le popup
            popup.style.display = "none";
        });
    }   
    

    // Animation pour les avis des visiteurs
    const avisList = document.getElementById('avis-list');
    const avis = [
        { message: "Super expérience, les enfants ont adoré !", "⭐": 5 },
        { message: "Beau parc mais un peu cher.", "⭐": 3 },
        { message: "Très éducatif et bien entretenu.", "⭐": 4 },
        { message: "Nous reviendrons avec plaisir !", "⭐": 5 },
        { message: "Personnel très sympathique.", "⭐": 4 },
        { message: "Bonne variété d'animaux.", "⭐": 4 },
        { message: "Activités intéressantes pour les petits.", "⭐": 5 },
        { message: "Parc très propre et bien organisé.", "⭐": 4 },
        { message: "Excellente journée en famille.", "⭐": 5 },
        { message: "Prix de la restauration un peu élevé.", "⭐": 3 }
    ];

    // Initialisation et affichage de l'avis actuel
    let avisIndex = 0;

    // Fonction qui réinitialise les avis    
    function afficherAvis() {
        avisList.innerHTML = '';
        const avisItem = document.createElement('li');
        const stars = '⭐'.repeat(avis[avisIndex]["⭐"]);
        avisItem.textContent = `${avis[avisIndex].message} - ${stars}`;
        avisList.appendChild(avisItem);
        avisIndex = (avisIndex + 1) % avis.length;
    }

    // Créé une animation et affiche un nouvel avis toutes les 3 secondes
    setInterval(afficherAvis, 3000);
});

//------------------------------------------------------------------------------------------------

// AFFICHAGE DEROULANT PRESENTATION DU ZOO PAGES D'ACCUEIL


function toggleSection(sectionId) {
    const section = document.getElementById(sectionId);
    section.style.display = section.style.display === 'none' ? 'flex' : 'none';

    if (section.style.display === 'block' && window.innerWidth <= 640) {
        const descriptions = section.querySelectorAll('.description');
        descriptions.forEach(function(description) {
            description.style.display = 'none';
        });
    }
}

function toggleParc() {
    toggleSection('parc-section');
}

function toggleHabitats() {
    toggleSection('habitats-section');
}

function toggleActivity() {
    toggleSection('activity-section');
}

function toggleEco() {
    toggleSection('eco-section');
}

function toggleDescription(imageElement) {
    const description = imageElement.parentElement.nextElementSibling.querySelector('.description');
    if (window.innerWidth <= 640) {
        description.style.display = description.style.display === 'none' ? 'block' : 'none';
    }
}

window.addEventListener('resize', function() {
    if (window.innerWidth > 640) {
        document.querySelectorAll('.description').forEach(function(description) {
            description.style.display = 'block';
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 640) {
        document.querySelectorAll('.description').forEach(function(description) {
            description.style.display = 'none';
        });
    }
});

//------------------------------------------------------------------------------------------------

// Comptabilise les vues / Gère l'ouverture et la fermeture de la fenêtre modale

// Attache un gestionnaire d'événements au document qui sera exécuté lorsque le DOM sera entièrement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne toutes les icônes de cœur dans le tableau et les stocke dans la variable "hearts"
    const hearts = document.querySelectorAll('.heart-icon');

    // Parcourt chaque icône dans "hearts"
    hearts.forEach((heart) => {
        // Définit la couleur de l'icône en gris
        heart.style.color = 'grey';
        // Attache un gestionnaire d'événements à chaque icône qui sera exécuté lorsque l'icône est cliquée
        heart.addEventListener('click', function(event) {
            // Empêche l'action par défaut du navigateur lorsqu'un utilisateur clique sur un lien
            event.preventDefault();
            // Récupère l'ID de l'image à partir de l'attribut data-id de l'icône
            const imagesanimauxid = this.dataset.id;
            // Appelle la fonction recordView avec l'ID de l'image
            recordView(imagesanimauxid);
            // Si la couleur de l'icône est rouge, la change en gris, sinon la change en rouge
            this.style.color = this.style.color === 'red' ? 'grey' : 'red';
        });
    });
});

function recordView(images_animaux_id) {
    // Envoie une requête POST à 'record_views.php' avec l'ID de l'image dans le corps de la requête
    fetch('record_views.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ images_animaux_id: images_animaux_id })
    })
    // Convertit la réponse en JSON
    .then(response => response.json())
    // Traite la réponse JSON
    .then(data => {
        // Si la requête a réussi
        if (data.success) {
            // Récupère l'élément HTML où afficher le nombre de vues
            const viewCount = document.getElementById('viewCount-' + images_animaux_id);
            // Met à jour le texte de cet élément avec le nombre de vues
            viewCount.textContent = 'Nombre de vues: ' + data.views;
        } else {
            // Si la requête a échoué, affiche un message d'erreur dans la console
            console.error('Erreur lors de l\'enregistrement du clic:', data.message);
        }
    })
    // Si une erreur se produit lors de l'envoi de la requête, affiche un message d'erreur dans la console
    .catch(error => console.error('Erreur:', error));
};

//-------------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------------

// GESTION DES COMMENTAIRES

$(document).ready(function(){
    $("#animalForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'submit_comment.php',
            type: 'post',
            data: $(this).serialize(),
            success: function(response){
                alert(response);
            }
        });
    });

    $("#habitatForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'submit_comment.php',
            type: 'post',
            data: $(this).serialize(),
            success: function(response){
                alert(response);
            }
        });
    });
});

