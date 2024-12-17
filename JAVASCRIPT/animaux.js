document.addEventListener('DOMContentLoaded', function() {
    // Gérer le retournement des cartes
    const infos = document.querySelectorAll('.info');
    infos.forEach(info => {
        info.addEventListener('click', function() {
            this.classList.toggle('flipped');
        });
    });

    // Gestion des clics sur les icônes de cœur
    const hearts = document.querySelectorAll('.heart-icon');

    hearts.forEach((heart) => {
        heart.style.color = 'grey'; // Initialisation de la couleur du cœur

        // Gestionnaire d'événement au clic sur l'icône de cœur
        heart.addEventListener('click', function(event) {
            event.stopPropagation(); // Empêche le retournement de la carte lors du clic sur l'icône
            const idAnimal = this.dataset.id; // Récupère l'ID de l'animal cliqué
            updateLike(idAnimal, this); // Appelle la fonction pour mettre à jour le like

            // Ajout ou retrait de la classe 'liked' pour styliser l'icône
            this.classList.toggle('liked');
            
            // Change la couleur selon si la classe 'liked' est présente
            this.style.color = this.classList.contains('liked') ? 'red' : 'grey';
        });
    });

    // Fonction pour mettre à jour les likes
    function updateLike(idAnimal, heartIcon) {
        fetch('update_like.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_animal: idAnimal })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Like mis à jour avec succès.');
                heartIcon.style.color = 'red'; // Maintient la couleur rouge après le clic
            } else {
                console.error('Erreur lors de la mise à jour du like:', data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});
