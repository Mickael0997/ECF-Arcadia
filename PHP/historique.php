<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

try {
    // Récupérer les informations de l'employé
    $employe_id = $_SESSION['admin_id'];
    $sql = "SELECT * FROM employes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employe_id]);
    $employe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employe) {
        die("Employé non trouvé");
    }

    // Récupérer les filtres
    $animal_filter = $_GET['animal'] ?? '';
    $habitat_filter = $_GET['habitat'] ?? '';
    $employe_filter = $_GET['employe'] ?? '';
    $veterinaire_filter = $_GET['veterinaire'] ?? '';
    $date_filter = $_GET['date'] ?? '';

    // Récupérer les données pour les filtres
    $sql = "SELECT id, espece FROM animaux";
    $stmt = $conn->query($sql);
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id, nom as habitats FROM habitats";
    $stmt = $conn->query($sql);
    $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id, nom FROM employes";
    $stmt = $conn->query($sql);
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id, nom FROM veterinaires";
    $stmt = $conn->query($sql);
    $veterinaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour récupérer les commentaires avec les filtres
    $sql = "SELECT commentaires.commentaire, commentaires.date, employes.nom as employe, animaux.espece, habitats.nom as habitat, veterinaires.nom as veterinaire
            FROM commentaires 
            INNER JOIN employes ON commentaires.employe_id = employes.id
            INNER JOIN animaux ON commentaires.animal_id = animaux.id 
            INNER JOIN habitats ON commentaires.habitat_id = habitats.id 
            INNER JOIN veterinaires ON commentaires.veterinaire_id = veterinaires.id 
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

    if ($veterinaire_filter) {
        $sql .= " AND veterinaires.id = ?";
        $params[] = $veterinaire_filter;
    }

    if ($date_filter) {
        $sql .= " AND DATE(commentaires.date) = ?";
        $params[] = $date_filter;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialiser $commentaires si aucun résultat
    if (!$commentaires) {
        $commentaires = [];
    }

// Récupérer les informations de nourriture
$sql_nourriture = "SELECT * FROM nourriture";
$stmt_nourriture = $conn->query($sql_nourriture);
$nourriture = $stmt_nourriture->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <header>
        <div>
            <a href="../index.php" id="logo-link">
                <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo Écologique" id="logo">
            </a>
        </div>
        <div>
            <h1 class="titre">Bonjour <?php echo htmlspecialchars($employe['prenom']); ?> !</h1>
        </div>
    </header>
    <main>
        <h1>Historique des Commentaires</h1>
        <section>
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
                            <?php echo $habitat['habitats']; ?>
                        </option>
                    <?php } ?>
                </select><br>

                <label for="employe">Employé :</label>
                <select id="employe" name="employe">
                    <option value="">Tous</option>
                    <?php foreach ($employes as $employe) { ?>
                        <option value="<?php echo $employe['id']; ?>" <?php if ($employe_filter == $employe['id']) echo 'selected'; ?>>
                            <?php echo $employe['nom']; ?>
                        </option>
                    <?php } ?>
                </select><br>

                <label for="veterinaire">Vétérinaire :</label>
                <select id="veterinaire" name="veterinaire">
                    <option value="">Tous</option>
                    <?php foreach ($veterinaires as $veterinaire) { ?>
                        <option value="<?php echo $veterinaire['id']; ?>" <?php if ($veterinaire_filter == $veterinaire['id']) echo 'selected'; ?>>
                            <?php echo $veterinaire['nom']; ?>
                        </option>
                    <?php } ?>
                </select><br>

                <label for="date">Date :</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>"><br>
                <input type="submit" value="Filtrer">
            </form>
        </section>

        <table class="tableaux">
            <thead>
                <tr>
                    <th>Commentaire</th>
                    <th>Date</th>
                    <th>Employé</th>
                    <th>Animal</th>
                    <th>Habitat</th>
                    <th>Vétérinaire</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($commentaires)): ?>
                    <?php foreach ($commentaires as $commentaire) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($commentaire['commentaire']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['date']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['employe']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['espece']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['habitat']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['veterinaire']); ?></td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun commentaire trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Historique de la Nourriture</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Espèce</th>
                <th>Surnom</th>
                <th>Type d'alimentation</th>
                <th>Grammes</th>
                <th>Commentaire</th>
            </tr>
            <?php foreach ($nourriture as $entry) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($entry['date']); ?></td>
                    <td><?php echo htmlspecialchars($entry['heure']); ?></td>
                    <td><?php echo htmlspecialchars($entry['espece']); ?></td>
                    <td><?php echo htmlspecialchars($entry['surnom']); ?></td>
                    <td><?php echo htmlspecialchars($entry['type_alimentation']); ?></td>
                    <td><?php echo htmlspecialchars($entry['grammes']); ?></td>
                    <td><?php echo htmlspecialchars($entry['commentaire']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </main>
</body>
</html>
