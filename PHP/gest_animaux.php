<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

try {

// Récupération de la table animaux
    $sql = "SELECT * FROM animaux";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                <li> <a href="#">Gestion des Animaux</a></li>
                <li> <a href="../PHP/employes.php">Gestion des Employées</a></li>   
                <li> <a href="../PHP/veterinaires.php">Gestion des Vétérinaires</a></li>
                <li> <a href="../PHP/submit_comment.php">Gestion des Observations</a></li>
                <li> <a href="../PHP/gest_activites.php">Gestion des Activitées</a></li>
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
                <li> <a href="../PHP/employes.php">Gestion des Employées</a></li>   
                <li> <a href="../PHP/veterinaires.php">Gestion des Vétérinaires</a></li>
                <li> <a href="../PHP/submit_comment.php">Gestion des Observations</a></li>
                <li> <a href="../PHP/gest_activites.php">Gestion des Activitées</a></li>          
                <div class="burger-divider"></div>
                <div class="buttons">
                <a href="./logout.php" class="action-button" >Déconnexion</a>>
            </div> 
            </ul>
        </div>
    </header> 
<script src="JS/script.js"></script>
    <main>
    <div class="titre">
            <h2>Gestion des Animaux</h2>
        </div>
        <table class="admin_tableaux">
            <thead>
                <tr class="admin_tableau">
                    <th>Espèce</th>
                    <th>Surnom</th>
                    <th>Date de naissance</th>
                    <th>Âge</th>
                    <th>Taille</th>
                    <th>Poids</th>                    
                    <th>Sexe</th>
                    <th>Type Animal</th>
                    <th>Race</th>
                    <th>Nourriture</th>
                    <th>Habitat</th>
                    <th>nbr_clic</th>
                    <th>Etat</th>
                    <th>Nourritures en grammes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animaux as $animal): ?>
                    <tr class="admin_tableau">
                        <td><?php echo htmlspecialchars($animal['espece']); ?></td>
                        <td><?php echo htmlspecialchars($animal['surnom']); ?></td>
                        <td><?php echo htmlspecialchars($animal['date_naissance']); ?></td>
                        <td><?php echo htmlspecialchars($animal['age']); ?></td>
                        <td><?php echo htmlspecialchars($animal['taille']); ?></td>
                        <td><?php echo htmlspecialchars($animal['poids']); ?></td>
                        <td><?php echo htmlspecialchars($animal['sexe']); ?></td>
                        <td><?php echo htmlspecialchars($animal['type_animal']); ?></td>
                        <td><?php echo htmlspecialchars($animal['race']); ?></td>
                        <td><?php echo htmlspecialchars($animal['nourriture_id']); ?></td>
                        <td><?php echo htmlspecialchars($animal['habitat_id']); ?></td>
                        <td><?php echo htmlspecialchars($animal['nbr_clic']); ?></td>
                        <td><?php echo htmlspecialchars($animal['etat']); ?></td>
                        <td><?php echo htmlspecialchars($animal['grammes_nourritures']); ?></td>
                        <td>
                            <a href="edit_animal.php?id=<?php echo $animal['id']; ?>">Modifier</a>
                            <a href="delete_animal.php?id=<?php echo $animal['id']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_animal.php">Ajouter un nouvel animal</a>
        </main>
   
</body>

</html>
