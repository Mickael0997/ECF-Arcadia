use mysqli; // Add missing import
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO employes (nom, prenom, telephone, fonction, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $nom, PDO::PARAM_STR);
    $stmt->bindValue(2, $prenom, PDO::PARAM_STR);
    $stmt->bindValue(3, $telephone, PDO::PARAM_STR);
    $stmt->bindValue(5, $email, PDO::PARAM_STR);
    $stmt->execute();

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
    <title>Ajouter un Vétérinaire</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
<form action="add_veterinaires.php" method="post" enctype="multipart/form-data">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom">

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom">

    <label for="telephone">Téléphone</label>
    <input type="number" id="telephone" name="telephone">

    <label for="email">E-mail :</label>
    <input type="email" id="email" name="email">

    <input type="submit" value="Ajouter un vétérinaire">
</form>
</body>
</html>
