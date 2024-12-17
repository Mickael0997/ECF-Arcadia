<?php
require 'database.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $description = htmlspecialchars($_POST['description']);
    $image_activite = htmlspecialchars($_POST['image_activite']);

    $sql = "UPDATE activite SET nom = ?, description = ?, image_activite = ? WHERE id_activite = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $description, $image_activite, $id]);

    header('Location: gest_activites.php');
    exit;
}

$sql = "SELECT * FROM activite WHERE id_activite = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$activite = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/ges_activity.css">
    <link rel="stylesheet" href="../CSS/edit_activity.css">
    <title>Modifier une activité</title>
</head>
<body>
<header>
<div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./gest_activites.php';" style="cursor: pointer;">
        <h6>session, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h6>
        <h1>Modifier une activitée</h1>
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
    <form method="POST" action="edit_activity.php?id=<?php echo $id; ?>">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($activite['nom']); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($activite['description']); ?></textarea>

        <label for="image_activite">URL de l'image:</label>
        <input type="text" id="image_activite" name="image_activite" value="<?php echo htmlspecialchars($activite['image_activite']); ?>" required>

        <button type="submit">Modifier</button>
    </form>
</main>
</body>
</html>