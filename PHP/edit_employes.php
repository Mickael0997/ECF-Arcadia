<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

$employe_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone_portable = $_POST['telephone_portable'];
    $email = $_POST['email'];

    $sql = "UPDATE employes SET nom = ?, prenom = ?, telephone_portable = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    if ($stmt->execute([$nom, $prenom, $telephone_portable, $email, $employe_id])) {
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "Erreur : " . implode(":", $conn->errorInfo());
    }
} else {
    $sql = "SELECT * FROM employes WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    $stmt->execute([$employe_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        die($conn->errorInfo());
    }

    $employe = $result;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Employé</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <form action="edit_employes.php?id=<?php echo $employe_id; ?>" method="post">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($employe['nom']); ?>" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($employe['prenom']); ?>" required><br>

        <label for="telephone_portable">Téléphone :</label>
        <input type="text" id="telephone_portable" name="telephone_portable" value="<?php echo htmlspecialchars($employe['telephone_portable']); ?>" required><br>

        <label for="email">E-mail :</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($employe['email']); ?>" required><br>
        
        <input type="submit" value="Modifier">
    </form>
</body>
</html>