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
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
<header>
    <a href="./admin_dashboard.php" id="logo-link">   
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
    </a>
    
<div class="navbar">  
    <ul class="links">
                <li> <a href="#">Gestion des Activitées</a></li>
                <li> <a href="../PHP/employes.php">Gestion des Employées</a></li>   
                <li> <a href="../PHP/veterinaires.php">Gestion des Vétérinaires</a></li>
                <li> <a href="../PHP/gest_animaux.php">Gestion des Animaux</a></li>
    </ul>
        <div class="buttons">
        <a href="./logout.php" class="action-button" >Déconnexion</a>
        </div> 
            <div class="burger-menu-button">
                <i class="fas fa-bars"></i>
            </div>
</div>
    <div class="burger-menu">
        <ul class="links">
                <li> <a href="#">Gestion des Activitées</a></li>
                <li> <a href="../PHP/employes.php">Gestion des Employées</a></li>   
                <li> <a href="../PHP/veterinaires.php">Gestion des Vétérinaires</a></li>
                <li> <a href="../PHP/gest_animaux.php">Gestion des Animaux</a></li>       
        </ul>
<div class="burger-divider"></div>
    <div class="buttons">
    <a href="./logout.php" class="action-button" >Déconnexion</a>       
    </div>     
    </div>
</header> 

<script src="JS/script.js"></script>

<main>
    <h2>Gestion des Activitées</h2>
        <table class="admin_tableaux">
            <thead>
                <tr class="admin_table">
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
                            <a href="edit_activity.php?id=<?php echo $activite['id']; ?>">Modifier</a>
                            <a href="delete_activity.php?id=<?php echo $activite['id']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_activity.php">Ajouter une nouvelle activité</a>
    </main>
</body>
</html>