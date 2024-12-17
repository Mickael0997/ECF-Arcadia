<?php
require 'database.php';
session_start();

// Vérifiez si l'utilisateur est inactif depuis plus de 5 minutes (300 secondes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 300) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Mettez à jour la dernière activité de l'utilisateur
$_SESSION['last_activity'] = time();

// Vérifiez si l'utilisateur est connecté en tant qu'administrateur ou employé
if (!isset($_SESSION['id_admin']) && !isset($_SESSION['id_employe'])) {
    header('Location: login.php');
    exit();
}

// Récupération des informations de l'utilisateur connecté
if (isset($_SESSION['id_admin'])) {
    $user_id = $_SESSION['id_admin'];
    $sql = "SELECT a.nom, a.prenom, e.fonction 
            FROM administrateur a 
            JOIN employe e ON a.adresse_mail = e.adresse_mail 
            WHERE a.id_admin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $is_admin = true;
} else {
    $user_id = $_SESSION['id_employe'];
    $sql = "SELECT nom, prenom, fonction FROM employe WHERE id_employe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $is_admin = false;
}

// Vérifiez si l'utilisateur est bien un employé ou un administrateur
if (!$user) {
    header('Location: login.php');
    exit();
}

// Récupération des habitats
$sql = "SELECT * FROM habitat";
$stmt = $conn->prepare($sql);
$stmt->execute();
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/ges_habitats.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Gestion des Habitats</title>
</head>
<body>
<header>
    <div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./admin_dashboard.php';" style="cursor: pointer;">
        <h6>session, <?php echo htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?>: 
        <?php 
        if (isset($_SESSION['employees']) && is_array($_SESSION['employees'])) {
            echo htmlspecialchars(implode(', ', $_SESSION['employees']));
        } 
        ?>
        </h6>
        <h1>Gestion des Habitats</h1>
    </div>
    <div class="admin-navbar">
            <ul class="links">
                <?php if ($is_admin): ?>
                <li><a href="./employes.php">Gestion du Personnel</a></li>
                <?php endif; ?>
                <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
                <li><a href="./gest_activites.php">Gestion des Activités</a></li>
                <li><a href="./gest_habitats.php">Gestion des Habitats</a></li>
                <?php if ($is_admin): ?>
                    <li><a href="./historique.php">Historique</a></li>
                <?php endif; ?>
                <li><a class="admin-buttons admin-button" href="./logout.php">Déconnexion</a></li>
            </ul>
        </div> 
</header>
<div class="background-gradient"></div>
<main>
    <a class="gest-habitats-button" href="add_habitat.php">Ajouter un habitat</a>
    <table class="admin_tableaux">
        <thead>
            <tr class="admin_tableau">
                <th>Nom</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($habitats)): ?>
                <?php foreach ($habitats as $index => $habitat): ?>
                    <tr class="admin_tableau" style="background-color: <?php echo $index % 2 == 0 ? '#f2f2f2' : '#ffffff'; ?>">
                        <td><?php echo htmlspecialchars($habitat['nom']); ?></td>
                        <td><?php echo htmlspecialchars($habitat['description']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($habitat['image_habitat']); ?>" alt="Image de l'habitat" style="width: 100px; height: auto;"></td>
                        <td>
                            <a href="edit_habitat.php?id=<?php echo $habitat['id_habitat']; ?>" class="edit-link" data-id="<?php echo $habitat['id_habitat']; ?>">Modifier</a>
                            <a href="delete_habitat.php" class="delete-link" data-id="<?php echo $habitat['id_habitat']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucun habitat trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<!-- Fenêtre modale pour la confirmation de suppression ou de modification -->
<div id="actionModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="modalMessage">Êtes-vous sûr de vouloir effectuer cette action ?</p>
        <button id="confirmAction">Confirmer</button>
        <button id="cancelAction">Annuler</button>
    </div>
</div>

<!-- Message de succès ou d'annulation -->
<div id="message" class="message"></div>

<script src="../JAVASCRIPT/scripts.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteLinks = document.querySelectorAll('.delete-link');
        const editLinks = document.querySelectorAll('.edit-link');
        const actionModal = document.getElementById('actionModal');
        const closeModal = document.querySelector('.close');
        const confirmAction = document.getElementById('confirmAction');
        const cancelAction = document.getElementById('cancelAction');
        const message = document.getElementById('message');
        let actionType;
        let actionId;

        deleteLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                actionType = 'delete';
                actionId = this.getAttribute('data-id');
                document.getElementById('modalMessage').textContent = 'Êtes-vous sûr de vouloir supprimer cet élément ?';
                actionModal.style.display = 'block';
            });
        });

        editLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                actionType = 'edit';
                actionId = this.getAttribute('data-id');
                document.getElementById('modalMessage').textContent = 'Êtes-vous sûr de vouloir modifier cet élément ?';
                actionModal.style.display = 'block';
            });
        });

        closeModal.addEventListener('click', function() {
            actionModal.style.display = 'none';
        });

        cancelAction.addEventListener('click', function() {
            actionModal.style.display = 'none';
            message.textContent = 'Action annulée';
            message.style.display = 'block';
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        });

        confirmAction.addEventListener('click', function() {
            if (actionType === 'delete') {
                window.location.href = `delete_habitat.php?id=${actionId}`;
            } else if (actionType === 'edit') {
                window.location.href = `edit_habitat.php?id=${actionId}`;
            }
        });

        window.addEventListener('click', function(event) {
            if (event.target === actionModal) {
                actionModal.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>