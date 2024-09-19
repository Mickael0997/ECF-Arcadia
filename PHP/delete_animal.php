<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

$animal_id = $_GET['id'];

$sql = "DELETE FROM animaux WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$stmt->execute([$animal_id]);

header('Location: admin_dashboard.php');
exit;
?>