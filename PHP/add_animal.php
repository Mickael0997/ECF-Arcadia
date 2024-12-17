<?php
require 'database.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surnom = htmlspecialchars($_POST['surnom']);
    $espece = htmlspecialchars($_POST['espece']);
    $age = htmlspecialchars($_POST['age']);
    $etat_sante = htmlspecialchars($_POST['etat_sante']);
    $description = htmlspecialchars($_POST['description']);
    $id_habitat = htmlspecialchars($_POST['id_habitat']);
    $sexe = htmlspecialchars($_POST['sexe']);
    $race = htmlspecialchars($_POST['race']);
    $poids = htmlspecialchars($_POST['poids']);
    $date_naissance = htmlspecialchars($_POST['date_naissance']);
    $type_alimentation = htmlspecialchars($_POST['type_alimentation']);

    $sql = "INSERT INTO animal (surnom, espece, age, etat_sante, description, id_habitat, sexe, race, poids, date_naissance, type_alimentation) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$surnom, $espece, $age, $etat_sante, $description, $id_habitat, $sexe, $race, $poids, $date_naissance, $type_alimentation]);

    header('Location: gest_animaux.php');
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
    <link rel="stylesheet" href="../CSS/edit_animal.css">
    <title>Ajouter un animal</title>
</head>
<body>
<header>
    <div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./gest_animaux.php';" style="cursor: pointer;">
        <h1>Ajouter un animal</h1>
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
    <form method="POST" action="add_animal.php">
        <label for="surnom">Surnom:</label><br>
        <input type="text" id="surnom" name="surnom" required><br>

        <label for="espece">Espèce:</label><br>
        <input type="text" id="espece" name="espece" required><br>

        <label for="age">Age:</label><br>
        <input type="number" id="age" name="age" required><br>

        <label for="etat_sante">Etat de santé:</label><br>
        <input type="text" id="etat_sante" name="etat_sante" required><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>

        <label for="id_habitat">Habitat:</label><br>
        <input type="number" id="id_habitat" name="id_habitat" required><br>

        <label for="sexe">Sexe:</label><br>
        <input type="text" id="sexe" name="sexe" required><br>

        <label for="race">Race:</label><br>
        <input type="text" id="race" name="race" required><br>

        <label for="poids">Poids:</label><br>
        <input type="number" id="poids" name="poids" required><br>

        <label for="date_naissance">Date de naissance:</label><br>
        <input type="date" id="date_naissance" name="date_naissance" required><br>

        <label for="type_alimentation">Type d'alimentation:</label><br>
        <input type="text" id="type_alimentation" name="type_alimentation" required><br>

        <button type="submit">Ajouter</button>
    </form>
</main>
</body>
</html>