<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM administrateurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['prenom'] . ' ' . $admin['nom'];
            header('Location: admin_dashboard.php');
            exit;
        }
    }

    $sql = "SELECT * FROM employes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user && $password == $user['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $user['prenom'];
            $_SESSION['id'] = $user['id'];
            header('Location: dashboard.php');
            exit;
        }
    } else {
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
    <h1>Espace réservé aux employé(e)s</h1>
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
