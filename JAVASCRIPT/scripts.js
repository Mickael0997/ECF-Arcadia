
// Fonction évènements affichage des avis clients

document.addEventListener('DOMContentLoaded', function() {   
});

// Animation pour les avis des visiteurs

const avisList = document.getElementById('avis-list');
const avis = [
        { message: "Super expérience, les enfants ont adoré !", etoiles: 5 },
        { message: "Beau parc mais un peu cher.", etoiles: 3 },
        { message: "Très éducatif et bien entretenu.", etoiles: 4 },
        { message: "Nous reviendrons avec plaisir !", etoiles: 5 },
        { message: "Personnel très sympathique.", etoiles: 4 },
        { message: "Bonne variété d'animaux.", etoiles: 4 },
        { message: "Activités intéressantes pour les petits.", etoiles: 5 },
        { message: "Parc très propre et bien organisé.", etoiles: 4 },
        { message: "Excellente journée en famille.", etoiles: 5 },
        { message: "Prix de la restauration un peu élevé.", etoiles: 3 }
    ];

// Initialisation et affichage de l'avis actuelle

let avisIndex = 0;

// Fonction qui reinitialise les avis    

function afficherAvis() {
    avisList.innerHTML = '';
    const avisItem = document.createElement('li');
    avisItem.textContent = `${avis[avisIndex].message} - ${avis[avisIndex].etoiles} étoiles`;
    avisList.appendChild(avisItem);
    avisIndex = (avisIndex + 1) % avis.length;
}

// Créé une animation et affiche un nouvel avis toutes les 3 secondes

setInterval(afficherAvis, 3000);
