<?php
require 'database.php';

if (!isset($_POST['image_id'])) {
    die("Image ID not provided");
}

$image_id = $_POST['image_id'];

// Validation de l'entrée
if (!preg_match("/^[a-zA-Z0-9]+$/", $image_id)) {
    die("Invalid image ID");
}

try {
    $sql = "SELECT views FROM record_view WHERE image_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$image_id]);

    if ($stmt->rowCount() > 0) {
        $views = $stmt->fetchColumn();
        $views++;

        $sql_update = "UPDATE record_view SET views = ? WHERE image_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->execute([$views, $image_id]);
    } else {
        $views = 1;
        $sql_insert = "INSERT INTO record_view (image_id, views) VALUES (?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->execute([$image_id, $views]);
    }

    echo json_encode(['success' => true, 'views' => $views]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
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
    <header>
    <a href="./index.php" id="logo-link">   
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
    </a>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> !</h1>
        <div class="navbar">
            <ul class="links">
            <li> <a href="#">Les Tendances</a></li>
<li> <a href="./employes.php">Gestion des Employées</a></li>
<li> <a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
<li> <a href="./submit_comment.php">Gestion des Observations</a></li>
<li> <a href="./gest_animaux.php">Gestion des Animaux</a></li>
<li> <a href="./gest_activites.php">Gestion des Activitées</a></li>
<div class="burger-divider"></div>
<div class="buttons">
<a href="./logout.php" class="action-button" >Déconnexion</a>
</div> 
</ul>
</div>
</header>
<body>
<main>

<script src="../JAVASCRIPT/scripts.js"></script>
</main>

</body>
</html>