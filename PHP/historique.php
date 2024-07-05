<?php
require 'auth.php';
require 'database.php';

// Récupérer les filtres
$animal_filter = $_GET['animal'] ?? '';
$habitat_filter = $_GET['habitat'] ?? '';
$employe_filter = $_GET['employe'] ?? '';
$date_filter = $_GET['date'] ?? '';

// Construire la requête SQL avec les filtres
$sql = "SELECT commentaires.commentaire, commentaires.date, employes.nom as employe, animaux.espece, habitats.nom as habitat 
        FROM commentaires 
        INNER JOIN employes ON commentaires.employe_id = employes.id 
        INNER JOIN animaux ON commentaires.animal_id = animaux.id 
        INNER JOIN habitats ON commentaires.habitat_id = habitats.id 
        WHERE 1=1";

$params = [];

if ($animal_filter) {
    $sql .= " AND animaux.id = ?";
    $params[] = $animal_filter;
}

if ($habitat_filter) {
    $sql .= " AND habitats.id = ?";
    $params[] = $habitat_filter;
}

if ($employe_filter) {
    $sql .= " AND employes.id = ?";
    $params[] = $employe_filter;
}

if ($date_filter) {
    $sql .= " AND DATE(commentaires.date) = ?";
    $params[] = $date_filter;
}

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$stmt->execute($params);
$commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Commentaires</title>
</head>
<body>
    <h1>Historique des Commentaires</h1>

    <form method="get" action="historique.php">
        <label for="animal">Animal :</label>
        <select id="animal" name="animal">
            <option value="">Tous</option>
            <?php foreach ($animaux as $animal) { ?>
                <option value="<?php echo $animal['id']; ?>" <?php if ($animal_filter == $animal['id']) echo 'selected'; ?>>
                    <?php echo $animal['espece']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="habitat">Habitat :</label>
        <select id="habitat" name="habitat">
            <option value="">Tous</option>
            <?php foreach ($habitats as $habitat) { ?>
                <option value="<?php echo $habitat['id']; ?>" <?php if ($habitat_filter == $habitat['id']) echo 'selected'; ?>>
                    <?php echo $habitat['nom']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="employe">Employé :</label>
        <select id="employe" name="employe">
            <option value="">Tous</option>
            <?php // Récupérer et afficher les employés ?>
            <?php foreach ($employes as $employe) { ?>
                <option value="<?php echo $employe['id']; ?>" <?php if ($employe_filter == $employe['id']) echo 'selected'; ?>>
                    <?php echo $employe['nom']; ?>
                </option>
            <?php } ?>
        </select><br>

        <label for="date">Date :</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>"><br>

        <input type="submit" value="Filtrer">
    </form>

    <table>
        <tr>
            <th>Commentaire</th>
            <th>Date</th>
            <th>Employé</th>
            <th>Animal</th>
            <th>Habitat</th>
        </tr>
        <?php foreach ($commentaires as $commentaire) { ?>
            <tr>
                <td><?php echo htmlspecialchars($commentaire['commentaire']); ?></td>
                <td><?php echo htmlspecialchars($commentaire['date']); ?></td>
                <td><?php echo htmlspecialchars($commentaire['employe']); ?></td>
                <td><?php echo htmlspecialchars($commentaire['espece']); ?></td>
                <td><?php echo htmlspecialchars($commentaire['habitat']); ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
