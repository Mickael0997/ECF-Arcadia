<?php
require 'auth.php';
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $employe = $_POST['employe'];
    $fonction = $_POST['fonction'];
    $commentaire = $_POST['commentaire'];

    $sql = "INSERT INTO journal (date, employe, fonction, commentaire) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $date, $employe, $fonction, $commentaire);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
    } else {
        echo "Erreur : " . $stmt->error;
    }
}
?>
