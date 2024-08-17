<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

try {
    // Récupération des tables
    $tables = ['employes', 'veterinaires', 'animaux', 'parc_activites', 'habitats', 'parc_animaux'];
    $data = [];

    foreach ($tables as $table) {
        $sql = "SELECT * FROM $table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $employes = $data['employes'];
    $veterinaires = $data['veterinaires'];
    $animaux = $data['animaux'];
    $habitats = $data['habitats'];

    // Récupération des commentaires avec filtres
    $animal_filter = $_GET['animal'] ?? '';
    $habitat_filter = $_GET['habitat'] ?? '';
    $employe_filter = $_GET['employe'] ?? '';
    $veterinaire_filter = $_GET['veterinaire'] ?? '';
    $date_filter = $_GET['date'] ?? '';

    $sql = "SELECT commentaires.commentaire, commentaires.date, employes.nom as employe, animaux.espece, habitats.habitats as habitat, veterinaires.nom as veterinaire
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

    // Récupération des vues des images
    $sql = "SELECT * FROM record_view";
    $stmt = $conn->query($sql);
    $record_view = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Ajouter commentaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employe_id = $_SESSION['id'];
    $animal_id = $_POST['animal_id'];
    $habitat_id = $_POST['habitat_id'];
    $commentaire = $_POST['commentaire'];

    $sql = "INSERT INTO commentaires (employe_id, animal_id, habitat_id, commentaire, date) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employe_id, $animal_id, $habitat_id, $commentaire]);

    if ($stmt->rowCount() > 0) {
        echo "Commentaire ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du commentaire.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <header>

        <a href="../PHP/index.php" id="logo-link">
            <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
        </a>

        <div class="admin-title">
            <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> !</h1>
        </div>
        
        <div class="admin-navbar">
            <ul class="links">
                <li><a href="./employes.php">Gestion des Employés</a></li>
                <li><a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
                <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
                <li><a href="./gest_activites.php">Gestion des Activités</a></li>
            </ul>
            <div class="buttons">
                <a href="./logout.php" class="action-button">Déconnexion</a>
            </div>
            <div class="burger-menu-button">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <div class="burger-menu">
            <ul class="links">
                <li><a href="./employes.php">Gestion des Employés</a></li>
                <li><a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
                <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
                <li><a href="./gest_activites.php">Gestion des Activités</a></li>
                <div class="burger-divider"></div>
                <div class="admin-buttons">
                    <a href="./logout.php" class="admin-action-button">Déconnexion</a>
                </div>
            </ul>
        </div>
    </header>


    <main>

    
        
<div class="admin-title"><h2>Journal de bord</h2></div>
        <form class="admin-form" method="get" action="historique.php">
            
            <section class="admin">

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
            </section>
        </form>

        <section>
            <div class="admin-title"><h2>Observations</h2></div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Observations</th>
                        <th>Date</th>
                        <th>Employé</th>
                        <th>Animal</th>
                        <th>Habitat</th>
                        <th>Valider</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commentaires as $commentaire) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($commentaire['commentaire']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['date']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['employe']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['espece']); ?></td>
                            <td><?php echo htmlspecialchars($commentaire['habitat']); ?></td>
                            <td><button type="button">Valider</button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
        
        <section>
            <h2>Nombre de vues des images</h2>
            <table class="tableaux">
                <thead>
                    <tr>
                        <th>ID de l'image</th>
                        <th>Nombre de vues</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($record_view as $views) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($views['image_id']); ?></td>
                            <td id="viewCount-<?php echo htmlspecialchars($views['image_id']); ?>"><?php echo htmlspecialchars($views['views']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
    </footer>
    <script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>



 




