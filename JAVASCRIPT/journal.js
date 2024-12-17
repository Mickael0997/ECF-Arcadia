document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('entry-modal');
    modal.style.display = 'none';
    const successMessage = createSuccessMessage();
    const journalEntriesContainer = document.getElementById('journal-entries');
    const addObservationForm = document.getElementById('entry-form');
    const searchForm = document.getElementById('search-form');

    // Ajout du code pour la fenêtre modale de recherche
    const searchModal = document.getElementById('search-modal');
    const searchButton = document.getElementById('search-entry-button');
    const closeSearchButton = searchModal.querySelector('.close');

    searchButton.addEventListener('click', function () {
        searchModal.style.display = 'block';
    });

    closeSearchButton.addEventListener('click', function () {
        searchModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === searchModal) {
            searchModal.style.display = 'none';
        }
    });

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(searchForm);
        const searchParams = new URLSearchParams();

        for (const pair of formData) {
            searchParams.append(pair[0], pair[1]);
        }

        fetch('admin_dashboard.php', {
            method: 'POST',
            body: searchParams
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newEntries = doc.getElementById('journal-entries').innerHTML;
            journalEntriesContainer.innerHTML = newEntries;
            searchModal.style.display = 'none';
        })
        .catch(error => console.error('Erreur lors de la recherche :', error));
    });

    setupEventListeners();

    function setupEventListeners() {
        // Ouverture et fermeture de la modale
        document.getElementById('add-entry-button').addEventListener('click', openModal);
        document.getElementsByClassName('close')[0].addEventListener('click', closeModal);
        searchForm.addEventListener('submit', searchEntries);
        window.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Gestion des sélections et changements
        document.getElementById('entry-category').addEventListener('change', handleCategoryChange);
        document.getElementById('zoo-category').addEventListener('change', handleZooCategoryChange);
        document.getElementById('animal-reason').addEventListener('change', handleAnimalReasonChange);

        // Soumission du formulaire
        addObservationForm.addEventListener('submit', submitEntryForm);
    }

    function openModal() {
        console.log('openModal called');
        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
        // Réinitialiser le comportement du formulaire
        addObservationForm.removeEventListener('submit', updateObservation);
        addObservationForm.addEventListener('submit', submitEntryForm);
    }

    function handleCategoryChange() {
        hideAllOptions();
        if (this.value === 'zoo') {
            showElementById('zoo-options');
        } else if (this.value === 'reunion') {
            showElementById('reunion-options');
        }
    }

    function handleZooCategoryChange() {
        hideZooSubOptions();
        const value = this.value;
        if (value === 'animal') showElementById('animal-options');
        else if (value === 'habitat') showElementById('habitat-options');
        else if (value === 'activite') showElementById('activite-options');
    }

    function handleAnimalReasonChange() {
        hideElementById('repas-options');
        if (this.value === 'repas') {
            showElementById('repas-options');
        }
    }

    function submitEntryForm(event) {
        event.preventDefault();

        const category = document.getElementById('entry-category').value;
        const details = buildEntryDetails(category);

        if (!details) {
            alert('Veuillez remplir tous les champs nécessaires.');
            return;
        }

        const formData = {
            category,
            details,
            animal: document.getElementById('animal-select')?.value,
            'zoo-category': document.getElementById('zoo-category')?.value,
        };

        addObservation(formData);
        addObservationForm.reset(); // Réinitialiser le formulaire
        closeModal(); // Ferme la fenêtre modale
    }

    function buildEntryDetails(category) {
        let details = '';
        if (category === 'zoo') {
            const zooCategory = document.getElementById('zoo-category').value;
            if (zooCategory === 'animal') {
                const animalName = getSelectedText('animal-select');
                const reason = document.getElementById('animal-reason').value;
                const observation = document.getElementById('animal-observation').value;
                if (reason === 'repas') {
                    const nourriture = document.getElementById('repas-nourriture').value;
                    const quantite = document.getElementById('repas-quantite').value;
                    const unite = document.getElementById('repas-unite').value;
                    const heure = document.getElementById('repas-heure').value;
                    details = `Animal: ${animalName}, Raison: ${reason}, Nourriture: ${nourriture}, Quantité: ${quantite} ${unite}, Heure: ${heure}, Observation: ${observation}`;
                } else {
                    details = `Animal: ${animalName}, Raison: ${reason}, Observation: ${observation}`;
                }
            } else if (zooCategory === 'habitat') {
                const habitat = getSelectedText('habitat-select');
                const observation = document.getElementById('habitat-observation').value;
                details = `Habitat: ${habitat}, Observation: ${observation}`;
            } else if (zooCategory === 'activite') {
                const activite = getSelectedText('activite-select');
                const observation = document.getElementById('activite-observation').value;
                details = `Activité: ${activite}, Observation: ${observation}`;
            }
        } else if (category === 'reunion') {
            const startTime = document.getElementById('reunion-start-time').value;
            const endTime = document.getElementById('reunion-end-time').value;
            const observation = document.getElementById('reunion-observation').value;
            details = `Réunion: ${observation}, Début: ${startTime}, Fin: ${endTime}`;
        }
        return details;
    }

    async function addObservation(formData) {
        try {
            const response = await fetch('admin_dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'add',
                    category: formData.category,
                    details: formData.details,
                    animal: formData.animal || null,
                    'zoo-category': formData['zoo-category'] || null,
                }),
            });

            const result = await response.json();

            if (result.success) {
                displayJournalEntry(result.entry); // Ajouter immédiatement dans l'UI
                showSuccessMessage('Événement ajouté avec succès');
            } else {
                console.error('Erreur lors de l\'ajout de l\'observation :', result.message);
            }
        } catch (error) {
            console.error('Erreur AJAX lors de l\'ajout :', error);
        }
    }

    function displayJournalEntry(entry) {
        const entryElement = document.createElement('div');
        entryElement.classList.add('journal-entry');
        entryElement.dataset.id = entry.id;
        entryElement.innerHTML = `
            <div>
                <strong>${entry.date}</strong> - ${entry.user_name} (${entry.user_role})
            </div>
            <div>${entry.category}: ${entry.details}</div>
            <button class="edit-btn">Modifier</button>
            <button class="delete-btn">Supprimer</button>
        `;
        journalEntriesContainer.prepend(entryElement);

        // Ajouter les événements pour les boutons
        const editBtn = entryElement.querySelector('.edit-btn');
        const deleteBtn = entryElement.querySelector('.delete-btn');

        editBtn.addEventListener('click', () => editObservation(entry));
        deleteBtn.addEventListener('click', () => deleteObservation(entry.id, entryElement));
    }

    function editObservation(entry) {
        openModal();

        // Remplir les champs avec les données existantes
        document.getElementById('entry-category').value = entry.category;

        // Remplis les champs spécifiques à la catégorie
        if (entry.category === 'zoo') {
            document.getElementById('zoo-category').value = entry.zoo_category;
            if (entry.zoo_category === 'animal') {
                document.getElementById('animal-select').value = entry.animal;
                document.getElementById('animal-reason').value = entry.reason;
                document.getElementById('animal-observation').value = entry.observation;
            }
        } else if (entry.category === 'reunion') {
            document.getElementById('reunion-start-time').value = entry.start_time;
            document.getElementById('reunion-end-time').value = entry.end_time;
            document.getElementById('reunion-observation').value = entry.observation;
        }

        // Change le comportement du bouton "Soumettre" pour enregistrer les modifications
        addObservationForm.removeEventListener('submit', submitEntryForm);
        addObservationForm.addEventListener('submit', (event) => {
            event.preventDefault();
            updateObservation(entry.id);
        });
    }

    async function updateObservation(id) {
        try {
            const updatedData = {
                id,
                category: document.getElementById('entry-category').value,
                details: buildEntryDetails(document.getElementById('entry-category').value),
            };

            const response = await fetch('admin_dashboard.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'update', ...updatedData }),
            });

            const result = await response.json();

            if (result.success) {
                showSuccessMessage('Observation modifiée avec succès.');
                closeModal();
                loadJournalEntries(); // Recharge les entrées
            } else {
                console.error('Erreur lors de la modification :', result.message);
            }
        } catch (error) {
            console.error('Erreur AJAX lors de la modification :', error);
        }
    }

    async function deleteObservation(id, entryElement) {
        try {
            console.log('Envoi de la requête de suppression pour l\'ID:', id); // Log pour vérifier l'envoi de la requête
            const response = await fetch('admin_dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'delete',
                    id: id,
                }),
            });

            const text = await response.text(); // Lire la réponse comme texte brut
            console.log('Réponse brute :', text); // Log pour vérifier la réponse brute
            const result = JSON.parse(text); // Parse uniquement si la réponse est correcte

            if (result.success) {
                entryElement.remove(); // Supprimer l'élément de l'interface
                showSuccessMessage('Entrée supprimée avec succès.');
            } else {
                console.error('Erreur lors de la suppression de l\'observation :', result.message);
            }
        } catch (error) {
            console.error('Erreur AJAX lors de la suppression :', error);
        }
    }

    async function loadJournalEntries() {
        try {
            const response = await fetch('admin_dashboard.php'); // Modifie selon le chemin de ton fichier PHP
            const text = await response.text(); // Lire la réponse comme texte brut
            console.log('Réponse brute :', text); // Debug
            const entries = JSON.parse(text); // Parse uniquement si la réponse est correcte

            journalEntriesContainer.innerHTML = ''; // Vide le conteneur pour éviter les doublons           
            if (entries && entries.length > 0) {
                entries.forEach(entry => displayJournalEntry(entry));
            } else {
                journalEntriesContainer.innerHTML = '<p>Aucune observation pour aujourd\'hui.</p>';
            }
        } catch (error) {
            console.error('Erreur lors du chargement des entrées :', error);
        }
    }
    async function searchEntries(event) {
        event.preventDefault();
        const filters = {
            date: document.getElementById('search-date').value,
            name: document.getElementById('search-name').value,
            animalNickname: document.getElementById('search-animal-nickname').value,
            habitat: document.getElementById('search-habitat').value,
            activity: document.getElementById('search-activity').value,
        };
    
        try {
            const response = await fetch('admin_dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'search', filters }),
            });
            const results = await response.json();
            journalEntriesContainer.innerHTML = '';
            results.forEach(entry => displayJournalEntry(entry));
        } catch (error) {
            console.error('Erreur lors de la recherche :', error);
        }
    }
    
    function createSuccessMessage() {
        const successMessage = document.createElement('div');
        successMessage.id = 'success-message';
        successMessage.style.position = 'fixed';
        successMessage.style.bottom = '10px';
        successMessage.style.right = '10px';
        successMessage.style.padding = '10px 20px';
        successMessage.style.backgroundColor = '#28a745';
        successMessage.style.color = '#fff';
        successMessage.style.borderRadius = '5px';
        successMessage.style.zIndex = '1000';
        successMessage.style.display = 'none';
        document.body.appendChild(successMessage);
        return successMessage;
    }
    
    function showSuccessMessage(message) {
        const successMessage = document.getElementById('success-message');
        successMessage.textContent = message;
        successMessage.style.display = 'block';
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 3000);
    }
    
    function hideAllOptions() {
        ['zoo-options', 'animal-options', 'habitat-options', 'activite-options', 'repas-options', 'reunion-options'].forEach(hideElementById);
    }
    
    function hideZooSubOptions() {
        ['animal-options', 'habitat-options', 'activite-options', 'repas-options'].forEach(hideElementById);
    }
    
    function hideElementById(id) {
        document.getElementById(id).style.display = 'none';
    }
    
    function showElementById(id) {
        document.getElementById(id).style.display = 'block';
    }
    
    function getSelectedText(selectId) {
        const select = document.getElementById(selectId);
        return select.options[select.selectedIndex].text;
    }
    
    // Charger les entrées du journal au démarrage
    loadJournalEntries();
});