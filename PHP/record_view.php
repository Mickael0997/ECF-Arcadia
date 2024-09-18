<?php
// Connexion à la base de données
require 'database.php';

function validateInput($image_animal) {
    // Validation de l'entrée : Doit être un nombre entier
    if (!preg_match("/^[0-9]+$/", $image_animal)) {
        die(json_encode(['success' => false, 'message' => 'Invalid image ID']));
    }
}

function getAnimal($conn, $image_animal) {
    // Valider l'existence de l'animal dans la table parc
    $sql = "SELECT id_animal FROM parc WHERE id_parc = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$image_animal]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getViews($conn, $id_animal) {
    // Récupérer les vues associées à l'animal
    $sql = "SELECT id_view, nombre_view FROM view WHERE id_animal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_animal]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateViews($conn, $id_view, $views) {
    // Mettre à jour le nombre de vues
    $sql_update = "UPDATE view SET nombre_view = ? WHERE id_view = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->execute([$views, $id_view]);
}

function insertViews($conn, $id_animal) {
    // Insérer une nouvelle entrée de vues pour l'animal
    $sql_insert = "INSERT INTO view (id_animal, nombre_view) VALUES (?, 1)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->execute([$id_animal]);
    return $conn->lastInsertId();
}

function updateParcView($conn, $id_parc, $id_view) {
    // Associer la vue à l'image de l'animal dans la table parc
    $sql_update_parc = "UPDATE parc SET id_view = ? WHERE id_parc = ?";
    $stmt_update_parc = $conn->prepare($sql_update_parc);
    $stmt_update_parc->execute([$id_view, $id_parc]);
}

$image_animal = $_POST['imageanimal'];
validateInput($image_animal);

try {
    $conn->beginTransaction();

    // Vérifier si l'animal existe dans la table parc
    $animalData = getAnimal($conn, $image_animal);
    if (!$animalData) {
        throw new Exception('Animal not found');
    }

    $id_animal = $animalData['id_animal'];

    // Vérifier si une entrée existe déjà pour cet animal dans la table view
    $viewData = getViews($conn, $id_animal);

    if ($viewData !== false) {
        $id_view = $viewData['id_view'];
        $views = $viewData['nombre_view'] + 1;
        updateViews($conn, $id_view, $views);
    } else {
        $id_view = insertViews($conn, $id_animal);
        $views = 1;
    }

    // Mettre à jour la table parc avec l'ID de vue
    updateParcView($conn, $image_animal, $id_view);

    // Commit la transaction
    $conn->commit();

    // Retourner le résultat au client
    echo json_encode(['success' => true, 'view' => $views]);
} catch (PDOException $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
