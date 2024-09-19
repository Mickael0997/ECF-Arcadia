<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

$animal_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $espece = $_POST['espece'];
    $description = $_POST['description'];
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

    $sql = "UPDATE animaux SET espece = ?, description = ?, surnom = ?, date_naissance = ?, age = ?, taille = ?, poids = ?, sexe = ?, type_animal = ?, race = ?, nourriture_id = ?, habitat_id = ?, observations = ?, etat = ?, grammes_nourritures = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    $stmt->execute([$espece, $description, $surnom, $date_naissance, $age, $taille, $poids, $sexe, $type_animal, $race, $nourriture_id, $habitat_id, $observations, $etat, $grammes_nourritures, $animal_id]);

    header('Location: admin_dashboard.php');
    exit;
} else {
    $sql = "SELECT * FROM animaux WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    $stmt->execute([$animal_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        die($conn->errorInfo());
    }

    $animal = $result;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Animal</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <form action="edit_animal.php?id=<?php echo $animal_id; ?>" method="post">

        <label for="espece">Espèce :</label>
        <input type="text" id="espece" name="espece" value="<?php echo htmlspecialchars($animal['espece']); ?>" required><br>

        <label for="surnom">Surnom :</label>
        <input type="text" id="surnom" name="surnom" value="<?php echo htmlspecialchars($animal['surnom']); ?>" required><br>

        <label for="date_naissance">date de naissance :</label>
        <input type="text" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($animal['date_naissance']); ?>" required><br>

        <label for="age">Âge :</label>
        <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($animal['age']); ?>" required><br>

        <label for="taille">Taille :</label>
        <input type="text" id="taille" name="taille" value="<?php echo htmlspecialchars($animal['taille']); ?>" required><br>

        <label for="poids">Poids :</label>
        <input type="text" id="poids" name="poids" value="<?php echo htmlspecialchars($animal['poids']); ?>" required><br>

        <label for="sexe">sexe :</label>
        <input type="text" id="sexe" name="sexe" value="<?php echo htmlspecialchars($animal['sexe']); ?>" required><br>

        <label for="type_animal">Catégories :</label>
        <input type="text" id="type_animal" name="type_animal" value="<?php echo htmlspecialchars($animal['type_animal']); ?>" required><br>

        <label for="race">Race :</label>
        <input type="text" id="race" name="race" value="<?php echo htmlspecialchars($animal['race']); ?>" required><br>

        <label for="nourriture_id">Nourriture :</label>
        <input type="text" id="nourriture_id" name="nourriture_id" value="<?php echo htmlspecialchars($animal['nourriture_id']); ?>" required><br>

        <label for="habitat_id">habitat :</label>
        <input type="text" id="habitat_id" name="habitat_id" value="<?php echo htmlspecialchars($animal['habitat_id']); ?>" required><br>

        <label for="observations">observations :</label>
        <input type="text" id="observations" name="observations" value="<?php echo htmlspecialchars($animal['observations']); ?>" required><br>

        <label for="etat">Etat :</label>
        <input type="text" id="etat" name="etat" value="<?php echo htmlspecialchars($animal['etat']); ?>" required><br>

        <label for="grammes_nourritures">Grammages Nourritures :</label>
        <input type="text" id="grammes_nourritures" name="grammes_nourritures" value="<?php echo htmlspecialchars($animal['grammes_nourritures']); ?>" required><br>

        <label for="">Description :</label>
        <textarea id="description" name="description"></textarea><br>
        <input type="submit" value="Modifier">
    </form>
</body>
</html>
