<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

$activity_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $activites_images = $_POST['activites_images']; // Ajoutez cette ligne

    $sql = "UPDATE parc_activites SET nom = ?, description = ?, activites_images = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    $stmt->execute([$nom, $description, $activites_images, $activity_id]); // Ajoutez $activites_images ici

    header('Location: admin_dashboard.php');
    exit;
} else {
    $sql = "SELECT * FROM parc_activites WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    $stmt->execute([$activity_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        die($conn->errorInfo());
    }

    $activity = $result;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Activité</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <form action="edit_activity.php?id=<?php echo $activity_id; ?>" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($activity['nom']); ?>" required><br>
        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($activity['description']); ?></textarea><br>
        <input type="submit" value="Modifier">
    </form>
</body>
</html>
