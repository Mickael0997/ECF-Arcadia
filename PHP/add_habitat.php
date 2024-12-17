<?php
require 'database.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $image_habitat = htmlspecialchars($_POST['image_habitat']);

    $sql = "INSERT INTO habitat (nom, description, image_habitat) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $description, $image_habitat]);

    header('Location: gest_habitats.php');
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
    <link rel="stylesheet" href="../CSS/ges_habitats.css">
    <link rel="stylesheet" href="../CSS/edit_habitat.css">
    <title>Ajouter un habitat</title>
</head>
<body>
<header>
    <div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./gest_habitats.php';" style="cursor: pointer;">
        <h1>Ajouter un habitat</h1>
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
    <form method="POST" action="add_habitat.php">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="image_habitat">URL de l'image:</label>
        <input type="text" id="image_habitat" name="image_habitat" required>

        <button type="submit">Ajouter</button>
    </form>
</main>
</body>
</html>