<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

try {
//Récupération de la table veterinaires
    $sql = "SELECT * FROM veterinaires";
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
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <header>
    <a href="./admin_dashboard.php" id="logo-link">   
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
    </a>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> !</h1>
<div class="navbar">
            <ul class="links">
                 <li><a href="#">Gestion des Vétérinaires</a></li>    
                <li> <a href="../PHP/gest_activites.php">Gestion des Activitées</a></li>   
                <li> <a href="../PHP/employes.php">Gestion des Employées</a></li>
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
                <li><a href="#">Gestion des Vétérinaires</a></li>    
                <li> <a href="../PHP/gest_activites.php">Gestion des Activitées</a></li>   
                <li> <a href="../PHP/employes.php">Gestion des Employées</a></li>
                <li> <a href="../PHP/gest_animaux.php">Gestion des Animaux</a></li>
                <div class="buttons">
                <a href="./logout.php" class="action-button" >Déconnexion</a>
            </div>         
                <div class="burger-divider"></div>
            </ul>
        </div>
    </header> 
<script src="JS/script.js"></script>
    <main>

<div class="titre">
    <h2>Gestion des Vétérinaires</h2>
</div>
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
                <?php foreach ($veterinaires as $veterinaire): ?>
                    <tr class="admin_tableau">
                        <td><?php echo htmlspecialchars($veterinaire['nom']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['email']); ?></td>
                        <td>
                        <a href="edit_employes.php?id=<?php echo $veterinaire['id']; ?>">Modifier</a>
                        <a href="delete_employes.php?id=<?php echo $veterinaire['id']; ?>">Supprimer</a>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_veterinaires.php">Ajouter un vétérinaire</a>
        </main>
</body>
</html>