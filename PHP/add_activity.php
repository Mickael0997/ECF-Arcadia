<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $activites_images = $_FILES['images'];

    $activites_images = 'images/' . basename($activites_images['name']);
    move_uploaded_file($_FILES['images']['tmp_name'], $activites_images);

    $sql = "INSERT INTO parc_activites (nom, description, activites_images) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $description, $activites_images]);

    if ($stmt === false) {
        die($conn->errorInfo()[2]);
    }

    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Activité</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
<form action="add_activity.php" method="post" enctype="multipart/form-data">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom">

    <label for="description">Description :</label>
    <textarea id="description" name="description"></textarea>

    <label for="images">Image :</label>
    <input type="file" id="images" name="images">

    <input type="submit" value="Ajouter l'activité">
</form>
</body>
</html>
