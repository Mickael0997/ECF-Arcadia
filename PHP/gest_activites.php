<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

try {
// Récupération de la table parc_activites
    $sql = "SELECT * FROM parc_activites";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $parc_activites = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="../CSS/ges_activity.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Tableau de bord Administrateur</title>
</head>
<body>
<header>
    <a href="./admin_dashboard.php" id="logo-link">   
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
    </a>
    
    <div class="admin-title">
            <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
        </div>
        
        <div class="admin-navbar">
            <ul class="links">
                <li><a href="./employes.php">Gestion des Employés</a></li>
                <li><a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
                <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
                <li><a href="./gest_activites.php">Gestion des Activités</a></li>
                <li><a href="./historique.php">Historique</a></li>
            </ul>
            <div class="admin-buttons">
                <a href="./logout.php" class="action-button">Déconnexion</a>
            </div>
            <div class="burger-menu-button">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="burger-menu">
            <ul class="links">
                <li><a href="./employes.php">Gestion des Employés</a></li>
                <li><a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
                <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
                <li><a href="./gest_activites.php">Gestion des Services</a></li>
                <li><a href="./historique.php">Historique</a></li>
                <div class="burger-divider"></div>
                <div class="admin-buttons">
                    <a href="./logout.php" class="admin-action-button">Déconnexion</a>
                </div>
            </ul>
        </div>
</header>
<main>
    <div class="admin-title">
        <h2>Gestion des Activitées</h2>
    </div>
    <a class="gest-act-button" href="add_activity.php">Ajouter une nouvelle activité</a>
    <table class="gest-act-tableaux">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parc_activites as $activite): ?>
                <tr>
                    <td><?php echo htmlspecialchars($activite['nom']); ?></td>
                    <td><?php echo htmlspecialchars($activite['description']); ?></td>
                    <td><?php echo htmlspecialchars($activite['activites_images']); ?></td>
                    <td>
                        <a class="gest-act-button" href="edit_activity.php?id=<?php echo $activite['id']; ?>">Modifier</a>
                        <a class="gest-act-button" href="delete_activity.php?id=<?php echo $activite['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
    <script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>