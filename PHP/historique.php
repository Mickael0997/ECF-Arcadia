<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($conn)) {
    require 'database.php';
}

require 'database.php';

try {
    // Récupérer les informations de l'employé connecté
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

// Préparer la requête pour récupérer les commentaires des employés
    $sql_employe_comments = "SELECT c.date, e.nom as employe, h.nom as habitat, a.espece as animal, c.comments 
                            FROM commentaires c
                            JOIN employes e ON c.employe_id = e.id
                            JOIN habitats h ON c.habitat_id = h.id
                            JOIN animaux a ON c.animal_id = a.id
                            WHERE c.employe_id IS NOT NULL";
    
    // Préparer la requête pour récupérer les commentaires des vétérinaires
    $sql_veterinaire_comments = "SELECT c.date, v.nom as veterinaire, h.nom as habitat, a.espece as animal, a.etat as etat_sante, c.comments 
                                FROM commentaires c
                                JOIN veterinaires v ON c.veterinaire_id = v.id
                                JOIN habitats h ON c.habitat_id = h.id
                                JOIN animaux a ON c.animal_id = a.id
                                WHERE c.veterinaire_id IS NOT NULL";

    // Ajouter des conditions aux requêtes en fonction des filtres sélectionnés
    if ($animal_filter != '') {
        $sql_employe_comments .= " AND a.id = :animal_filter";
        $sql_veterinaire_comments .= " AND a.id = :animal_filter";
    }
    if ($habitat_filter != '') {
        $sql_employe_comments .= " AND h.id = :habitat_filter";
        $sql_veterinaire_comments .= " AND h.id = :habitat_filter";
    }
    if ($employe_filter != '') {
        $sql_employe_comments .= " AND e.id = :employe_filter";
    }
    if ($veterinaire_filter != '') {
        $sql_veterinaire_comments .= " AND v.id = :veterinaire_filter";
    }
    if ($date_filter != '') {
        $sql_employe_comments .= " AND c.date = :date_filter";
        $sql_veterinaire_comments .= " AND c.date = :date_filter";
    }

    // Préparer et exécuter la requête pour les commentaires des employés
    $stmt_employe_comments = $conn->prepare($sql_employe_comments);
    if ($animal_filter != '') {
        $stmt_employe_comments->bindParam(':animal_filter', $animal_filter, PDO::PARAM_INT);
    }
    if ($habitat_filter != '') {
        $stmt_employe_comments->bindParam(':habitat_filter', $habitat_filter, PDO::PARAM_INT);
    }
    if ($employe_filter != '') {
        $stmt_employe_comments->bindParam(':employe_filter', $employe_filter, PDO::PARAM_INT);
    }
    if ($date_filter != '') {
        $stmt_employe_comments->bindParam(':date_filter', $date_filter);
    }
    $stmt_employe_comments->execute();
    $employe_comments = $stmt_employe_comments->fetchAll(PDO::FETCH_ASSOC);

    // Préparer et exécuter la requête pour les commentaires des vétérinaires
    $stmt_veterinaire_comments = $conn->prepare($sql_veterinaire_comments);
    if ($animal_filter != '') {
        $stmt_veterinaire_comments->bindParam(':animal_filter', $animal_filter, PDO::PARAM_INT);
    }
    if ($habitat_filter != '') {
        $stmt_veterinaire_comments->bindParam(':habitat_filter', $habitat_filter, PDO::PARAM_INT);
    }
    if ($veterinaire_filter != '') {
        $stmt_veterinaire_comments->bindParam(':veterinaire_filter', $veterinaire_filter, PDO::PARAM_INT);
    }
    if ($date_filter != '') {
        $stmt_veterinaire_comments->bindParam(':date_filter', $date_filter);
    }
    $stmt_veterinaire_comments->execute();
    $veterinaire_comments = $stmt_veterinaire_comments->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/historique.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<header>
    <a href="../PHP/admin_dashboard.php" id="logo-link">
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
    </a>

    <div class="admin-title">
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
    </div>

    <div class="admin-navbar">
        <ul class="links">
            <li><a href="./employes.php">Gestion des Employés</a></li>
            <li><a href="./veterinaires.php">Gestion des Vétérinaires</a></li>
            <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
            <li><a href="./gest_activites.php">Gestion des Activités</a></li>
        </ul>
        <div class="admin-buttons">
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
            <li><a href="./gest_activites.php">Gestion des Services</a></li>
            <div class="burger-divider"></div>
            <div class="admin-buttons">
                <a href="./logout.php" class="admin-action-button">Déconnexion</a>
            </div>
        </ul>
    </div>
</header>

<div>
    <h2 class="history-title">Historique des Tâches</h2>
</div>

<form class="history-form" method="get" action="historique.php">
    <section class="history">
        <table>
            <tr>
                <th>Employé :</th>
                <th>Animal :</th>
                <th>Habitat :</th>
                <th>Date :</th>
            </tr>
            <tr>
                <td>
                    <select id="employe" name="employe">
                        <option value="">Tous</option>
                        <?php foreach ($employes as $employe) { ?>
                            <option value="<?php echo $employe['id']; ?>" <?php if ($employe_filter == $employe['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($employe['nom']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select id="animal" name="animal">
                        <option value="">Tous</option>
                        <?php foreach ($animaux as $animal) { ?>
                            <option value="<?php echo $animal['id']; ?>" <?php if ($animal_filter == $animal['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($animal['espece']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select id="habitat" name="habitat">
                        <option value="">Tous</option>
                        <?php foreach ($habitats as $habitat) { ?>
                            <option value="<?php echo $habitat['id']; ?>" <?php if ($habitat_filter == $habitat['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($habitat['habitats']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>">
                </td>
                </td>
                    <td>
                        <button class="history-button" type="submit">Filtrer</button>
                    </td>
                </tr>
            </table>
        </section>
    

        <!-- Affichage des commentaires des employés -->
        <section class="history-table">
        <h2 class="history-title">Commentaires des Employés</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Employé</th>
                <th>Habitat</th>
                <th>Animal</th>
                <th>Commentaire</th>
            </tr>
            <?php foreach ($employe_comments as $comment) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($comment['date']); ?></td>
                    <td><?php echo htmlspecialchars($comment['employe']); ?></td>
                    <td><?php echo htmlspecialchars($comment['habitat']); ?></td>
                    <td><?php echo htmlspecialchars($comment['animal']); ?></td>
                    <td><?php echo htmlspecialchars($comment['comments']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </section>
</form>
<!-------------------------------------------------------------------------------------------------------------------------------------------->


<!-- Affichage des commentaires des vétérinaires -->

<form class="history-form" method="get" action="historique.php">
    <section class="history">
        <table>
            <tr>
                <th>Vétérinaires :</th>
                <th>Animal :</th>
                <th>Habitat :</th>
                <th>Date :</th>
            </tr>
            <tr>
                <td>
                <select id="veterinaire" name="veterinaire">
                        <option value="">Tous</option>
                        <?php foreach ($veterinaires as $veterinaire) { ?>
                            <option value="<?php echo $veterinaire['id']; ?>" <?php if ($veterinaire_filter == $veterinaire['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($veterinaire['nom']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select id="animal" name="animal">
                        <option value="">Tous</option>
                        <?php foreach ($animaux as $animal) { ?>
                            <option value="<?php echo $animal['id']; ?>" <?php if ($animal_filter == $animal['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($animal['espece']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select id="habitat" name="habitat">
                        <option value="">Tous</option>
                        <?php foreach ($habitats as $habitat) { ?>
                            <option value="<?php echo $habitat['id']; ?>" <?php if ($habitat_filter == $habitat['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($habitat['habitats']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date_filter); ?>">
                </td>
                <td>
                    <button class="history-button" type="submit">Filtrer</button>
                </td>
            </tr>
        </table>
        
    </section>

    <!-- Affichage des commentaires des vétérinaires -->
    <section class="history-table">
        <h2 class="history-title">Commentaires des Vétérinaires</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Vétérinaire</th>
                <th>Habitat</th>
                <th>Animal</th>
                <th>État de Santé</th>
                <th>Commentaire</th>
            </tr>
            <?php foreach ($veterinaire_comments as $comment) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($comment['date']); ?></td>
                    <td><?php echo htmlspecialchars($comment['veterinaire']); ?></td>
                    <td><?php echo htmlspecialchars($comment['habitat']); ?></td>
                    <td><?php echo htmlspecialchars($comment['animal']); ?></td>
                    <td><?php echo htmlspecialchars($comment['etat_sante']); ?></td>
                    <td><?php echo htmlspecialchars($comment['comments']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </section>
</form>
<script src="../JAVASCRIPT/scripts.js"></script>
</body>