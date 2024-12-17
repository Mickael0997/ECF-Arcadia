<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

try {
    // Récupération de la table employées
    $sql = "SELECT * FROM employe";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération de la table vétérinaires
    $sql = "SELECT * FROM veterinaire";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $veterinaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/historique.css">
    <link rel="stylesheet" href="../CSS/employes.css">
    <link rel="stylesheet" href="../CSS/ges_animaux.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<header>
<div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./admin_dashboard.php';" style="cursor: pointer;">
        <h6>session, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h6>
        <h1>Gestion du Personnel</h1>
    </div>
    <div class="admin-navbar">
        <ul class="links">
            <li><a href="./employes.php">Gestion du Personnel</a></li>
            <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
            <li><a href="./gest_activites.php">Gestion des Activités</a></li>
            <li><a href="./historique.php">Historique</a></li>
            <li><a class="admin-buttons admin-button" href="./logout.php">Déconnexion</a></li>
        </ul>
    </div>
</header>
<div class="background-gradient"></div>
<main>
    <div class="titre">
        <h2>Gestion des Employés</h2>
    </div>
    <a href="./add_employes.php" class="employe_btn">Ajouter un employé</a>
    <table class="admin_tableaux">
        <thead>
            <tr class="admin_tableau">
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Fonction</th>
                <th>E-mail</th>
                <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            <?php if (!empty($employes)): ?>
                <?php foreach ($employes as $employe): ?>
                    <tr class="admin_tableau">
                        <td><?php echo htmlspecialchars($employe['nom']); ?></td>
                        <td><?php echo htmlspecialchars($employe['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($employe['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($employe['fonction']); ?></td>
                        <td><?php echo htmlspecialchars($employe['adresse_mail']); ?></td>
                        <td>
                            <a href="edit_employes.php?id=<?php echo $employe['id_employe']; ?>">Modifier</a>
                            <a href="#" class="delete-link" data-id="<?php echo $employe['id_employe']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Aucun employé trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="titre">
        <h2>Gestion des Vétérinaires</h2>
    </div>
    <a href="./add_veterinaires.php" class="veterinaire_btn">Ajouter un vétérinaire</a>
    <table class="admin_tableaux">
        <thead>
            <tr class="admin_tableau">
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>E-mail</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($veterinaires)): ?>
                <?php foreach ($veterinaires as $veterinaire): ?>
                    <tr class="admin_tableau">
                        <td><?php echo htmlspecialchars($veterinaire['nom']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['adresse_mail']); ?></td>
                        <td>
                            <a href="edit_veterinaires.php?id=<?php echo $veterinaire['id_veterinaire']; ?>">Modifier</a>
                            <a href="#" class="delete-link" data-id="<?php echo $veterinaire['id_veterinaire']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun vétérinaire trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<!-- Fenêtre modale pour la confirmation de suppression -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Êtes-vous sûr de vouloir supprimer cet élément ?</p>
        <button id="confirmDelete">Confirmer</button>
        <button id="cancelDelete">Annuler</button>
    </div>
</div>

<!-- Message de succès ou d'annulation -->
<div id="message" class="message"></div>

<script src="../JAVASCRIPT/scripts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteLinks = document.querySelectorAll('.delete-link');
        const deleteModal = document.getElementById('deleteModal');
        const closeModal = document.querySelector('.close');
        const confirmDelete = document.getElementById('confirmDelete');
        const cancelDelete = document.getElementById('cancelDelete');
        const message = document.getElementById('message');
        let deleteId;

        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                deleteId = this.getAttribute('data-id');
                deleteModal.style.display = 'block';
            });
        });

        closeModal.addEventListener('click', function() {
            deleteModal.style.display = 'none';
        });

        cancelDelete.addEventListener('click', function() {
            deleteModal.style.display = 'none';
            message.textContent = 'Suppression annulée';
            message.style.display = 'block';
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        });

        confirmDelete.addEventListener('click', function() {
            window.location.href = `delete_employes.php?id=${deleteId}`;
        });

        window.addEventListener('click', function(event) {
            if (event.target === deleteModal) {
                deleteModal.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>