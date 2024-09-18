<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Variable pour stocker un message d'erreur
    $error = '';

    // Vérification des administrateurs
    $sql = "SELECT * FROM administrateur WHERE adresse_mail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        if ($password == $admin['mot_de_passe']) {
            // Si l'admin est authentifié, démarrer la session d'administrateur
            $_SESSION['id_admin'] = $admin['id_admin'];
            $_SESSION['admin_name'] = $admin['prenom'] . ' ' . $admin['nom'];
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $error = "Mot de passe incorrect pour l'administrateur.";
        }
    } else {
        echo "Aucun administrateur trouvé avec cet email.";
    }

    // Si l'utilisateur n'est pas un administrateur, vérifier si c'est un employé
    $sql = "SELECT * FROM employe WHERE adresse_mail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $employe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employe) {
        if ($password == $employe['mot_de_passe']) {
            // Si l'employé est authentifié, démarrer la session d'employé
            $_SESSION['loggedin'] = true;
            $_SESSION['id_employe'] = $employe['id_employe'];
            $_SESSION['name'] = $employe['prenom'] . ' ' . $employe['nom'];
            $_SESSION['fonction'] = $employe['fonction'];  // Ajouter la fonction de l'employé pour d'éventuels usages
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Mot de passe incorrect pour l'employé.";
        }
    } else {
        echo "Aucun employé trouvé avec cet email.";
    }

    // Si aucune correspondance, afficher un message d'erreur
    if (empty($error)) {
        $error = "Email ou mot de passe incorrect";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <header>
        <a href="./index.php" id="logo-link">
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo Écologique" id="logo">
        </a>
    </header>
    <h1 class="login">Espace réservé aux employé(e)s</h1>
<section class="containers" id="connexion">

<div class="container">
    <div>
        <h3>Connexion</h3>
    </div>    
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="post">
            <label for="email">Email :</label>
            <input value="" type="email" id="email" name="email" required>
            <label for="password">Mot de passe :</label>
            <input value="" type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
</div>

</section>
</body>
</html>
