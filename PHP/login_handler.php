<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'database.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Vérifiez si les champs ne sont pas vides
if (empty($email) || empty($password)) {
    echo "Veuillez remplir tous les champs.";
    exit;
}

// Vérification si c'est un administrateur
$sql = "SELECT id_admin, prenom, nom, mot_de_passe FROM administrateur WHERE adresse_mail = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die($conn->errorInfo()[2]);
}

$stmt->bindValue(1, $email, PDO::PARAM_STR);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Si un administrateur est trouvé
if ($admin) {
    if (password_verify($password, $admin['mot_de_passe'])) {
        $_SESSION['id_admin'] = $admin['id_admin'];
        $_SESSION['admin_name'] = $admin['prenom'] . ' ' . $admin['nom'];
        $_SESSION['loggedin'] = true;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "Mot de passe incorrect.";
        exit;
    }
}

// Si ce n'est pas un administrateur, vérification si c'est un employé
$sql = "SELECT id_employe, prenom, nom, fonction, mot_de_passe FROM employe WHERE adresse_mail = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die($conn->errorInfo()[2]);
}

$stmt->bindValue(1, $email, PDO::PARAM_STR);
$stmt->execute();
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

// Si un employé est trouvé
if ($employe) {
    if (password_verify($password, $employe['mot_de_passe'])) {
        $_SESSION['id_employe'] = $employe['id_employe'];
        $_SESSION['name'] = $employe['prenom'] . ' ' . $employe['nom'];
        $_SESSION['fonction'] = $employe['fonction'];  // Stocke la fonction pour potentielle gestion des rôles
        $_SESSION['loggedin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Mot de passe incorrect.";
        exit;
    }
}

// Si aucun administrateur ou employé n'est trouvé
echo "Email incorrect.";
exit;
?>