<?php
function validateInput($images_animaux_id) {
    // Validation de l'entrée
    if (!preg_match("/^[a-zA-Z0-9]+$/", $images_animaux_id)) {
        die("Invalid image ID");
    }
}

function getViews($conn, $images_animaux_id) {
    $sql = "SELECT views FROM record_view WHERE images_animaux_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$images_animaux_id]);

    return $stmt->fetchColumn();
}

function updateViews($conn, $images_animaux_id, $views) {
    $sql_update = "UPDATE record_view SET views = ? WHERE images_animaux_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->execute([$views, $images_animaux_id]);
}

function insertViews($conn, $images_animaux_id, $views) {
    $sql_insert = "INSERT INTO record_view (images_animaux_id, views) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->execute([$images_animaux_id, $views]);
}

$images_animaux_id = $_POST['images_animaux_id']; // Modifié ici
validateInput($images_animaux_id);

try {
    $views = getViews($conn, $images_animaux_id);

    if ($views !== false) {
        $views++;
        updateViews($conn, $images_animaux_id, $views);
    } else {
        $views = 1;
        insertViews($conn, $images_animaux_id, $views);
    }

    echo json_encode(['success' => true, 'views' => $views]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
