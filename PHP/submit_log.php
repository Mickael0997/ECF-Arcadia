<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require 'auth.php';
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $employe = $_POST['employe'];
    $fonction = $_POST['fonction'];
    $commentaire = $_POST['commentaire'];

    $sql = "INSERT INTO journal (date, employe, fonction, commentaire) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    if ($stmt->execute([$date, $employe, $fonction, $commentaire])) {
        header('Location: dashboard.php');
    } else {
        echo "Erreur : " . implode(":", $conn->errorInfo());
    }
}
?>
