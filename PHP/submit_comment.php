<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employe_id = $_SESSION['id'];
    $animal_id = $_POST['animal_id'];
    $habitat_id = $_POST['habitat_id'];
    $commentaire = $_POST['commentaire'];

    $sql = "INSERT INTO commentaires (employe_id, animal_id, habitat_id, commentaire, date) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die($conn->errorInfo());
    }

    $stmt->execute([$employe_id, $animal_id, $habitat_id, $commentaire]);

    if ($stmt->rowCount() > 0) {
        exit("Commentaire ajouté avec succès.");
    } else {
        exit("Erreur lors de l'ajout du commentaire.");
    }
}
?>
