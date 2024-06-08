<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM employes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password ==$user['password']   ) {
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $user['prenom'];
        $_SESSION['id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
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
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="post">
            <label for="email">Email :</label>
            <input value="" type="email" id="email" name="email" required>
            <label for="password">Mot de passe :</label>
            <input value="" type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
