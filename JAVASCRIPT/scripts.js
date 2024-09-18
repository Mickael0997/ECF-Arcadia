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
    // Sélection des éléments
    const btn = document.getElementById('open-popup-btn');
    const span = document.getElementById('close-popup-btn');
    const popup = document.getElementById('popup');
    const avisList = document.getElementById('avis-list');
    const ratingValue = document.getElementById('rating-value');
    const stars = document.querySelectorAll('.star');

    // Vérifiez que btn et span ne sont pas null avant de les utiliser
    if (btn && popup) {
        btn.addEventListener('click', function() {
            // Ouvre le popup
            popup.style.display = "block";
        });
    }

    if (span && popup) {
        span.addEventListener('click', function() {
            // Ferme le popup
            popup.style.display = "none";
        });
    }

    // Animation pour les avis des visiteurs
    const avisManuels = [
        { message: "Super expérience, les enfants ont adoré !", rating: 5 },
        { message: "Beau parc mais un peu cher.", rating: 3 },
        { message: "Très éducatif et bien entretenu.", rating: 4 },
        { message: "Nous reviendrons avec plaisir !", rating: 5 },
        { message: "Personnel très sympathique.", rating: 4 },
        { message: "Bonne variété d'animaux.", rating: 4 },
        { message: "Activités intéressantes pour les petits.", rating: 5 },
        { message: "Parc très propre et bien organisé.", rating: 4 },
        { message: "Excellente journée en famille.", rating: 5 },
        { message: "Prix de la restauration un peu élevé.", rating: 3 }
    ];

    // Fonction pour afficher les avis un par un
    function afficherAvisUnParUn(avis) {
        if (avisList) {
            let index = 0;
            avisList.innerHTML = ''; // Clear the list initially
            const intervalId = setInterval(() => {
                if (index < avis.length) {
                    const avisItem = document.createElement('li');
                    const stars = '⭐'.repeat(avis[index].rating);
                    avisItem.textContent = `${avis[index].message} - ${stars}`;
                    avisList.innerHTML = ''; // Clear the list before showing the next avis
                    avisList.appendChild(avisItem);
                    index++;
                } else {
                    clearInterval(intervalId); // Stop the interval when all avis are shown
                }
            }, 5000); // Change avis every 5 seconds
        }
    }

    // Fonction pour récupérer et afficher les messages avec la note
    function fetchMessages() {
        fetch('../PHP/get_messages.php')
            .then(response => response.json())
            .then(data => {
                const avisDynamique = data.map(message => ({
                    message: `${message.pseudo} : ${message.message}`,
                    rating: message.rating
                }));
                const tousLesAvis = avisManuels.concat(avisDynamique);
                afficherAvisUnParUn(tousLesAvis);
            })
            .catch(error => console.error('Erreur lors de la récupération des messages :', error));
    }

    // Affiche les avis manuels au chargement de la page
    afficherAvisUnParUn(avisManuels);

    // Récupère les messages dynamiques au chargement de la page
    fetchMessages();

    // Répète la récupération toutes les 10 secondes pour les nouveaux messages
    setInterval(fetchMessages, 10000);

    // Sélection des étoiles de gauche à droite
    if (stars && ratingValue) {
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingValue.value = value;

                // Met à jour l'apparence des étoiles sélectionnées
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('selected');
                    } else {
                        s.classList.remove('selected');
                    }
                });
            });

            // Ajoute un effet de survol pour montrer la sélection potentielle
            star.addEventListener('mouseover', function() {
                const value = this.getAttribute('data-value');
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('hover');
                    } else {
                        s.classList.remove('hover');
                    }
                });
            });

            // Retire l'effet de survol lorsque la souris quitte les étoiles
            star.addEventListener('mouseout', function() {
                stars.forEach(s => {
                    s.classList.remove('hover');
                });
            });
        });
    }
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
    // Masquer les descriptions sur les petits écrans
    if (window.innerWidth <= 640) {
        document.querySelectorAll('.description').forEach(function(description) {
            description.style.display = 'none';
        });
    }

    // Gestion des clics sur les icônes de cœur
    const hearts = document.querySelectorAll('.heart-icon');

    hearts.forEach((heart) => {
        heart.style.color = 'grey'; // Initialisation de la couleur du cœur

        // Gestionnaire d'événement au clic sur l'icône de cœur
        heart.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut
            const imageanimal = this.dataset.id; // Récupère l'ID de l'animal cliqué
            recordView(imageanimal); // Appelle la fonction pour enregistrer la vue

            // Ajout ou retrait de la classe 'liked' pour styliser l'icône
            this.classList.toggle('liked');
            
            // Change la couleur selon si la classe 'liked' est présente
            this.style.color = this.classList.contains('liked') ? 'red' : 'grey';
        });
    });

    // Fonction pour enregistrer les vues
    function recordView(imageanimal) {
        fetch('record_views.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ imageanimal: imageanimal })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const viewCount = document.getElementById('viewCount-' + imageanimal);
                viewCount.textContent = 'Nombre de vues: ' + data.view;
            } else {
                console.error('Erreur lors de l\'enregistrement du clic:', data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});



//-------------------------------------------------------------------------------------------------


//-------------------------------------------------------------------------------------------------


