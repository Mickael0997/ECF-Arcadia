document.addEventListener('DOMContentLoaded', function() {
    const navbarToggle = document.getElementById('navbar-toggle');
    const navbar = document.getElementById('navbar');
    const navbarIcon = document.getElementById('navbar-icon');
    const menuTitles = document.querySelectorAll('.menu-title');

    // Fonction pour fermer tous les sous-menus
    function closeAllSubmenus() {
        const submenus = document.querySelectorAll('.submenu');
        submenus.forEach(submenu => {
            submenu.classList.remove('show');
        });
    }

    // Fonction pour réinitialiser la navbar
    function resetNavbar() {
        navbar.classList.remove('show-navbar');
        navbarIcon.classList.add('fa-bars');
        navbarIcon.classList.remove('fa-times');
        closeAllSubmenus();
    }

    // Bascule de la navbar
    navbarToggle.addEventListener('click', function() {
        if (navbar.classList.contains('show-navbar')) {
            // Si la navbar est ouverte, on la referme et on réinitialise
            resetNavbar();
        } else {
            // Si elle est fermée, on l'ouvre
            navbar.classList.add('show-navbar');
            navbarIcon.classList.remove('fa-bars');
            navbarIcon.classList.add('fa-times');
        }
    });

    // Affichage des sous-menus avec possibilité de refermer
    menuTitles.forEach(title => {
        title.addEventListener('click', function(event) {
            event.preventDefault();
            const targetMenu = document.getElementById(this.getAttribute('data-target'));
            if (targetMenu) {
                // Vérifie si le sous-menu cliqué est déjà ouvert
                const isCurrentlyOpen = targetMenu.classList.contains('show');

                // Fermer tous les sous-menus
                closeAllSubmenus();

                // Si le sous-menu cliqué n'était pas ouvert, l'ouvrir
                if (!isCurrentlyOpen) {
                    targetMenu.classList.add('show');
                }
            }
        });
    });

// Modal du plan
const planLink = document.querySelector('[href="../ASSETS/planparc.jpg"]');
const modal = document.getElementById('image-modal');
const modalImg = document.getElementById('modal-image');
const closeBtn = document.querySelector('.close');

planLink.addEventListener('click', function(event) {
    event.preventDefault();
    modal.style.display = "flex";
    modalImg.src = "../ASSETS/planparc.jpg";
});

closeBtn.addEventListener('click', function() {
    modal.style.display = "none";
    modalImg.classList.remove('zoomed');
    modalImg.style.transform = 'scale(1)';
    modalImg.style.transformOrigin = 'center center';
});

// Gestion du zoom de l'image au survol
modalImg.addEventListener('mousemove', function(event) {
    if (modalImg.classList.contains('zoomed')) {
        const rect = modalImg.getBoundingClientRect();
        const offsetX = (event.clientX - rect.left) / rect.width * 100;
        const offsetY = (event.clientY - rect.top) / rect.height * 100;
        modalImg.style.transformOrigin = `${offsetX}% ${offsetY}%`;
    }
});

// Bascule du zoom de l'image
modalImg.addEventListener('click', function() {
    if (modalImg.classList.contains('zoomed')) {
        modalImg.classList.remove('zoomed');
        modalImg.style.transform = 'scale(1)';
    } else {
        modalImg.classList.add('zoomed');
        modalImg.style.transform = 'scale(2)';
    }
});
});
