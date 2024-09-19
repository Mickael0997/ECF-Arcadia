<?php
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM veterinaires WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    if ($stmt->execute([$id])) {
        header('Location: admin_dashboard.php');
    } else {
        echo "Erreur : " . implode(":", $conn->errorInfo());
    }
}
?>