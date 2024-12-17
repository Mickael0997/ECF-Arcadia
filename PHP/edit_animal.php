<?php
require 'database.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

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

    $sql = "UPDATE animal SET surnom = ?, espece = ?, age = ?, etat_sante = ?, description = ?, id_habitat = ?, sexe = ?, race = ?, poids = ?, date_naissance = ?, type_alimentation = ? WHERE id_animal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$surnom, $espece, $age, $etat_sante, $description, $id_habitat, $sexe, $race, $poids, $date_naissance, $type_alimentation, $id]);

    header('Location: gest_animaux.php');
    exit;
}

$sql = "SELECT * FROM animal WHERE id_animal = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/edit_animal.css">
    <title>Modifier un animal</title>
</head>
<body>
<header>
    <div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./gest_animaux.php';" style="cursor: pointer;">
        <h1>Modifier un animal</h1>
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
<form method="POST" action="edit_animal.php?id=<?php echo $id; ?>">
        <label for="surnom">Surnom:</label>
        <input type="text" id="surnom" name="surnom" value="<?php echo htmlspecialchars($animal['surnom']); ?>" required>

        <label for="espece">Espèce:</label>
        <input type="text" id="espece" name="espece" value="<?php echo htmlspecialchars($animal['espece']); ?>" required>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($animal['age']); ?>" required>

        <label for="etat_sante">Etat de santé:</label>
        <input type="text" id="etat_sante" name="etat_sante" value="<?php echo htmlspecialchars($animal['etat_sante']); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($animal['description']); ?></textarea>

        <label for="id_habitat">Habitat:</label>
        <input type="number" id="id_habitat" name="id_habitat" value="<?php echo htmlspecialchars($animal['id_habitat']); ?>" required>

        <label for="sexe">Sexe:</label>
        <input type="text" id="sexe" name="sexe" value="<?php echo htmlspecialchars($animal['sexe']); ?>" required>

        <label for="race">Race:</label>
        <input type="text" id="race" name="race" value="<?php echo htmlspecialchars($animal['race']); ?>" required>

        <label for="poids">Poids:</label>
        <input type="number" id="poids" name="poids" value="<?php echo htmlspecialchars($animal['poids']); ?>" required>

        <label for="date_naissance">Date de naissance:</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($animal['date_naissance']); ?>" required>

        <label for="type_alimentation">Type d'alimentation:</label>
        <input type="text" id="type_alimentation" name="type_alimentation" value="<?php echo htmlspecialchars($animal['type_alimentation']); ?>" required>

        <button type="submit">Modifier</button>
    </form>
</main>
</body>
</html>