


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
    const burgerMenuButton = document.querySelector(".burger-menu-button");
    const burgerMenu = document.querySelector(".burger-menu");

    burgerMenuButton.addEventListener("click", function() {
        burgerMenu.classList.toggle("show");
    });
});


// Fonctions de la fenêtre POPUP 

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
window.onclick = function(event) {
    if (event.target == popup) {
        popup.style.display = "none";
    }
}

// Fonctions évènements affichage des avis clients

document.addEventListener('DOMContentLoaded', function() {   
});

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

// Initialisation et affichage de l'avis actuelle

let avisIndex = 0;

// Fonction qui reinitialise les avis    

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

// Comptabilise les vues / Gère l'ouverture et la fermeture de la fenêtre modale

function recordView(imageId) {
    fetch('record_view.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'image_id=' + imageId
    })
    .then(response => response.json())
    .then(data => {
        // Optionally, update view count on the same page
        document.getElementById('viewCount-' + imageId).innerText = 'Nombre de vues: ' + data.views;
        updateAdminDashboard(imageId, data.views);
    })
    .catch(error => console.error('Error:', error));
}

function updateAdminDashboard(imageId, views) {
    const adminDashboard = window.parent.document.getElementById('viewCount-' + imageId);
    if (adminDashboard) {
        adminDashboard.innerText = 'Nombre de vues: ' + views;
    }
}



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