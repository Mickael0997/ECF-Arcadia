<?php
require 'database.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

if ($id) {
    $sql = "DELETE FROM habitat WHERE id_habitat = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header('Location: gest_habitats.php');
    exit;
} else {
    header('Location: gest_habitats.php');
    exit;
}
?>