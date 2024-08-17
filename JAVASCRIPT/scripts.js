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

    // Lorsque l'utilisateur clique sur le bouton, ouvre le popup
    btn.onclick = function() {
        popup.style.display = "block";
    }

    // Lorsque l'utilisateur clique sur (x), ferme le popup
    span.onclick = function() {
        popup.style.display = "none";
    }

    // Lorsque l'utilisateur clique n'importe où en dehors du popup, ferme le popup
    /*window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    }*/
     // Lorsque l'utilisateur clique sur la croix, ferme le popup
    document.querySelector('.closepopup').onclick = function() {
    popup.style.display = "none";
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

document.addEventListener('DOMContentLoaded', function() {
    const animals = document.querySelectorAll('.tableau img');

    animals.forEach((animal) => {
        animal.addEventListener('click', function() {
            const imageId = this.dataset.id; // Utilisez l'attribut data-id pour obtenir l'ID de l'image
            recordView(imageId);
        });
    });
});

function recordView(imageId) {
    fetch('record_views.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ image_id: imageId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const viewCount = document.getElementById('viewCount-' + imageId);
            viewCount.textContent = 'Nombre de vues: ' + data.views;
        } else {
            console.error('Erreur lors de l\'enregistrement du clic:', data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
}

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

