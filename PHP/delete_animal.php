<?php
require 'database.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'];

if ($id) {
    $sql = "DELETE FROM animal WHERE id_animal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header('Location: gest_animaux.php');
    exit;
} else {
    header('Location: gest_animaux.php');
    exit;
}
?>