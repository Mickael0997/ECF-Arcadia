<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

$veterinaire_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    $sql = "UPDATE veterinaires SET nom = ?, prenom = ?, telephone = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    if ($stmt->execute([$nom, $prenom, $telephone, $email, $veterinaire_id])) {
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "Erreur : " . implode(":", $conn->errorInfo());
    }
} else {
    $sql = "SELECT * FROM veterinaires WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    $stmt->execute([$veterinaire_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        die($conn->errorInfo());
    }

    $veterinaire = $result;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Vétérinaire</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <form action="edit_veterinaire.php?id=<?php echo $veterinaire_id; ?>" method="post">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($veterinaire['nom']); ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($veterinaire['prenom']); ?>" required><br>

        <label for="telephone">Téléphone :</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($veterinaire['telephone']); ?>" required><br>

        <label for="email">E-mail :</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($veterinaire['email']); ?>" required><br>
        
        <input type="submit" value="Modifier">
    </form>
</body>
</html>