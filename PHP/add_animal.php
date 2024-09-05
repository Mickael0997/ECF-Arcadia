<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $espece = $_POST['espece'];
    $surnom = $_POST['surnom'];
    $date_naissance = $_POST['date_naissance'];
    $age = $_POST['age'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $sexe = $_POST['sexe'];
    $type_animal = $_POST['type_animal'];
    $race = $_POST['race'];
    $nourriture_id = $_POST['nourriture_id'];
    $habitat_id = $_POST['habitat_id'];
    $observations = $_POST['observations'];
    $etat = $_POST['etat'];
    $grammes_nourritures = $_POST['grammes_nourritures'];
    $description_id = $_POST['description'];

    $sql = "INSERT INTO animaux (espece, surnom, date_naissance, age, taille, poids, sexe, type_animal, race, nourriture_id, habitat_id, observations, etat, grammes_nourritures) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $espece, PDO::PARAM_STR);
    $stmt->bindValue(2, $surnom, PDO::PARAM_STR);
    // Continuez avec les autres paramètres...

    $stmt->execute();

    if ($stmt === false) {
        die($conn->errorInfo()[2]);
    }

    if (isset($_SESSION['admin_id'])) {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Animal</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <form action="add_animal.php" method="post">
        <label for="espece">Espèce :</label>
        <input type="text" id="espece" name="espece" required><br>

        <label for="surnom">Surnom :</label>
        <input type="text" id="surnom" name="surnom" required><br>

        <label for="date_naissance">date de naissance :</label>
        <input type="text" id="date_naissance" name="date_naissance" required><br>

        <label for="age">Âge :</label>
        <input type="text" id="age" name="age" required><br>

        <label for="taille">Taille :</label>
        <input type="text" id="taille" name="taille" required><br>

        <label for="poids">Poids :</label>
        <input type="text" id="poids" name="poids" required><br>

        <label for="sexe">sexe :</label>
        <input type="text" id="sexe" name="sexe" required><br>

        <label for="type_animal">Catégories :</label>
        <input type="text" id="type_animal" name="type_animal" required><br>

        <label for="race">Race :</label>
        <input type="text" id="race" name="race" required><br>

        <label for="nourriture_id">Nourriture :</label>
        <input type="text" id="nourriture_id" name="nourriture_id" required><br>

        <label for="habitat_id">habitat :</label>
        <input type="text" id="habitat_id" name="habitat_id" required><br>

        <label for="observations">observations :</label>
        <input type="text" id="observations" name="observations" required><br>

        <label for="etat">Etat :</label>
        <input type="text" id="etat" name="etat" required><br>

        <label for="grammes_nourritures">Grammages Nourritures :</label>
        <input type="text" id="grammes_nourritures" name="grammes_nourritures" required><br>


        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br>

        <input type="submit" value="Ajouter un animal">
    </form>
</body>
</html>
