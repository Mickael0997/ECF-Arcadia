<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

$activity_id = $_GET['id'];

$sql = "DELETE FROM activites WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $activity_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt === false) {
    die($conn->errorInfo()[2]);
}

header('Location: admin_dashboard.php');
exit;
?>
