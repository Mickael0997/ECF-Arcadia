<?php
session_start();
require 'database.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM administrateurs WHERE email = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die($conn->errorInfo()[2]);
}

$stmt->bindValue(1, $email, PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($result) === 1) {
    $admin = $result[0];
    if (password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['prenom'] . ' ' . $admin['nom'];
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "Mot de passe incorrect.";
    }
} else {
    echo "Email incorrect.";
}
?>