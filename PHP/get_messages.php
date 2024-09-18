<?php
// Connexion à la base de données
require 'database.php';

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=localhost;dbname=ecf", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélectionner les messages avec le pseudo et la note
    $stmt = $conn->prepare("SELECT pseudo, message FROM question WHERE statut = 'validé'");
    $stmt->execute();

    // Récupérer tous les résultats
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retourner les résultats en JSON
    echo json_encode($messages);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>