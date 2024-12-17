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
    };

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



