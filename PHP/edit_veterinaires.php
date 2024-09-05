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
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/historique.css">
    <link rel="stylesheet" href="../CSS/employes.css">
    <link rel="stylesheet" href="../CSS/veterinaires.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Modifier un Vétérinaire</title>
</head>
<body>
<header>
    <a href="./admin_dashboard.php" id="logo-link">   
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
    </a>
    <div class="admin-title">
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
    </div>

    <div class="admin-navbar">
        <ul class="links">
            <li><a href="./employes.php">Gestion des Employés</a></li>
            <li><a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
            <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
            <li><a href="./gest_activites.php">Gestion des Activités</a></li>
            <li><a href="./historique.php">Historique</a></li>
        </ul>
        <div class="admin-buttons">
            <a href="./logout.php" class="action-button">Déconnexion</a>
        </div>
        <div class="burger-menu-button">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <div class="burger-menu">
        <ul class="links">
            <li><a href="./employes.php">Gestion des Employés</a></li>
            <li><a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
            <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
            <li><a href="./gest_activites.php">Gestion des Services</a></li>
            <li><a href="./historique.php">Historique</a></li>
            <div class="burger-divider"></div>
            <div class="admin-buttons">
                <a href="./logout.php" class="admin-action-button">Déconnexion</a>
            </div>
        </ul>
    </div>
</header>
<main>
    <form class="veterinaires-form" action="edit_veterinaire.php?id=<?php echo $veterinaire_id; ?>" method="post">

        <label class="veterinaires-label" for="nom">Nom :</label>
        <input class="veterinaires-input" type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($veterinaire['nom']); ?>" required><br>

        <label class="veterinaires-label" for="prenom">Prénom :</label>
        <input class="veterinaires-input" type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($veterinaire['prenom']); ?>" required><br>

        <label class="veterinaires-label" for="telephone">Téléphone :</label>
        <input class="veterinaires-input" type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($veterinaire['telephone']); ?>" required><br>

        <label class="veterinaires-label" for="email">E-mail :</label>
        <input class="veterinaires-input" type="text" id="email" name="email" value="<?php echo htmlspecialchars($veterinaire['email']); ?>" required><br>
        
        <input class="veterinaires-input" type="submit" value="Modifier">
    </form>
</main>
</body>
</html>
