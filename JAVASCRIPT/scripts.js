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

// Fonction évènements affichage des avis clients

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
