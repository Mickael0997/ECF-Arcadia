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
    $telephone_portable = $_POST['telephone_portable'];
    $fonction = $_POST['fonction'];
    $email = $_POST['email'];

    $sql = "INSERT INTO employes (nom, prenom, telephone_portable, fonction, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $nom, PDO::PARAM_STR);
    $stmt->bindValue(2, $prenom, PDO::PARAM_STR);
    $stmt->bindValue(3, $telephone_portable, PDO::PARAM_STR);
    $stmt->bindValue(4, $fonction, PDO::PARAM_STR);
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
    <title>Ajouter un employé</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
<form action="add_empployes.php" method="post" enctype="multipart/form-data">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom">

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom">

    <label for="telephone_portable">Portable</label>
    <input type="number" id="telephone_portable" name="telephone_portable">

    <label for="fonction">Fonction :</label>
    <input type="text" id="fonction" name="fonction">

    <label for="email">E-mail :</label>
    <input type="email" id="email" name="email">

    <input type="submit" value="Ajouter un employé">
</form>
</body>
</html>
