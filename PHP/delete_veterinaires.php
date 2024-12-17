<?php
require 'database.php';

$id = $_GET['id'];

if ($id) {
    $sql = "DELETE FROM veterinaire WHERE id_veterinaire = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header('Location: employes.php');
    exit;
} else {
    header('Location: employes.php');
    exit;
}
?>