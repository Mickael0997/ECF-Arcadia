<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

$employe_id = $_GET['id'];

$sql = "DELETE FROM employes WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$stmt->execute([$employe_id]);

header('Location: admin_dashboard.php');
exit;
?>