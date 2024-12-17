<?php
header('Content-Type: application/json');

// Connexion à la base de données
require 'database.php';

try {
    $conn = new PDO("mysql:host=localhost;dbname=ecf", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lire les données envoyées par la requête AJAX
    $data = json_decode(file_get_contents("php://input"), true);
    $idAnimal = $data['id_animal'];

    // Mettre à jour le nombre de vues (incrémentation)
    $sql = "UPDATE `view` SET `nombre_view` = `nombre_view` + 1 WHERE `id_animal` = :id_animal";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_animal', $idAnimal, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Échec de la mise à jour']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
