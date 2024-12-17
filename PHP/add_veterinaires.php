<?php
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $adresse_mail = htmlspecialchars($_POST['adresse_mail']);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $telephone = htmlspecialchars($_POST['telephone']);

    $sql = "INSERT INTO veterinaire (nom, prenom, adresse_mail, mot_de_passe, telephone) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $prenom, $adresse_mail, $mot_de_passe, $telephone]);

    header('Location: employes.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/ges_employes.css">
    <title>Ajouter un vétérinaire</title>
</head>
<body>
<header>
    <div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./admin_dashboard.php';" style="cursor: pointer;">
        <h6>session, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h6>
        <h1>Ajouter un Employé</h1>
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
    <form method="POST" action="add_veterinaires.php" class="add-employe">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        <label for="adresse_mail">E-mail:</label>
        <input type="email" id="adresse_mail" name="adresse_mail" required>
        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        <label for="telephone">Téléphone:</label>
        <input type="text" id="telephone" name="telephone" required>
        <button type="submit" class="btn-edit">Ajouter</button>
    </form>
</main>
<script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>