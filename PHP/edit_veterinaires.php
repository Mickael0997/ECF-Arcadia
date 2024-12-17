<?php
require 'database.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $specialite = htmlspecialchars($_POST['specialite']);
    $adresse_mail = htmlspecialchars($_POST['adresse_mail']);
    $telephone = htmlspecialchars($_POST['telephone']);

    $sql = "UPDATE veterinaire SET nom = ?, prenom = ?, specialite = ?, adresse_mail = ?, telephone = ? WHERE id_veterinaire = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nom, $prenom, $specialite, $adresse_mail, $telephone, $id]);

    header('Location: veterinaires.php');
    exit;
}

$sql = "SELECT * FROM veterinaire WHERE id_veterinaire = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$veterinaire = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <title>Modifier un vétérinaire</title>
</head>
<body>
<header>
    <div class="title">
        <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='./admin_dashboard.php';" style="cursor: pointer;">
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
    </div>
</header>
<div class="background-gradient"></div>
<main>
    <div class="titre">
        <h2>Modifier un vétérinaire</h2>
    </div>
    <form method="POST" action="edit_veterinaires.php?id=<?php echo $id; ?>">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($veterinaire['nom']); ?>" required>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($veterinaire['prenom']); ?>" required>
        <label for="specialite">Spécialité:</label>
        <input type="text" id="specialite" name="specialite" value="<?php echo htmlspecialchars($veterinaire['specialite']); ?>" required>
        <label for="adresse_mail">E-mail:</label>
        <input type="email" id="adresse_mail" name="adresse_mail" value="<?php echo htmlspecialchars($veterinaire['adresse_mail']); ?>" required>
        <label for="telephone">Téléphone:</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($veterinaire['telephone']); ?>" required>
        <button type="submit">Modifier</button>
    </form>
</main>
<script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>