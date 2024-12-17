<?php
require 'database.php'; // Assurez-vous que ce fichier contient la connexion à la base de données

// Vérifiez si l'ID de l'entrée est fourni
if (isset($_POST['id'])) {
    $entryId = $_POST['id'];

    // Préparez et exécutez la requête de suppression
    $sql = "DELETE FROM journal WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute([$entryId]))
    }

?>