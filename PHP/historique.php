<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($conn)) {
    require 'database.php';
}

try {
    // Récupérer les informations de l'administrateur connecté
    $id_admin = $_SESSION['id_admin'];
    $sql = "SELECT * FROM administrateur WHERE id_admin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_admin]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        die("Administrateur non trouvé");
    }

    $animal_filter = $_GET['animal'] ?? '';
    $habitat_filter = $_GET['habitat'] ?? '';
    $date_filter = $_GET['date'] ?? '';
    $employe_filter = $_GET['employe'] ?? '';
    $veterinaire_filter = $_GET['veterinaire'] ?? '';

    // Récupérer les données pour les filtres
    $sql = "SELECT id_animal, espece FROM animal";
    $stmt = $conn->query($sql);
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id_habitat, nom FROM habitat";
    $stmt = $conn->query($sql);
    $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id_employe, nom FROM employe";
    $stmt = $conn->query($sql);
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id_veterinaire, nom FROM veterinaire";
    $stmt = $conn->query($sql);
    $veterinaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Préparer la requête pour récupérer les observations des employés et vétérinaires
    $sql_observations_animal = "
        SELECT observation_animal.date_observation, 
            employe.nom AS employe, 
            veterinaire.nom AS veterinaire, 
            habitat.nom AS habitat, 
            animal.espece AS animal, 
            observation_animal.observation
        FROM observation_animal
        LEFT JOIN employe ON observation_animal.id_utilisateur = employe.id_employe
        LEFT JOIN veterinaire ON observation_animal.id_utilisateur = veterinaire.id_veterinaire
        JOIN animal ON observation_animal.id_animal = animal.id_animal
        JOIN habitat ON animal.id_habitat = habitat.id_habitat
        WHERE 1 = 1";

    // Ajouter des conditions aux requêtes en fonction des filtres sélectionnés
    if ($animal_filter != '') {
        $sql_observations_animal .= " AND animal.id_animal = :animal_filter";
    }
    if ($habitat_filter != '') {
        $sql_observations_animal .= " AND habitat.id_habitat = :habitat_filter";
    }
    if ($date_filter != '') {
        $sql_observations_animal .= " AND DATE(observation_animal.date_observation) = :date_filter";
    }
    if ($employe_filter != '') {
        $sql_observations_animal .= " AND employe.id_employe = :employe_filter";
    }
    if ($veterinaire_filter != '') {
        $sql_observations_animal .= " AND veterinaire.id_veterinaire = :veterinaire_filter";
    }

    // Préparer et exécuter la requête pour les observations des animaux
    $stmt_observations_animal = $conn->prepare($sql_observations_animal);

    if ($animal_filter != '') {
        $stmt_observations_animal->bindParam(':animal_filter', $animal_filter, PDO::PARAM_INT);
    }
    if ($habitat_filter != '') {
        $stmt_observations_animal->bindParam(':habitat_filter', $habitat_filter, PDO::PARAM_INT);
    }
    if ($date_filter != '') {
        $stmt_observations_animal->bindParam(':date_filter', $date_filter);
    }
    if ($employe_filter != '') {
        $stmt_observations_animal->bindParam(':employe_filter', $employe_filter, PDO::PARAM_INT);
    }
    if ($veterinaire_filter != '') {
        $stmt_observations_animal->bindParam(':veterinaire_filter', $veterinaire_filter, PDO::PARAM_INT);
    }

    $stmt_observations_animal->execute();
    $observations_animal = $stmt_observations_animal->fetchAll(PDO::FETCH_ASSOC);

    // Préparer la requête pour récupérer les observations des habitats
    $sql_observations_habitat = "
        SELECT observation_habitat.date_observation, 
            employe.nom AS employe, 
            veterinaire.nom AS veterinaire, 
            habitat.nom AS habitat, 
            observation_habitat.observation
        FROM observation_habitat
        LEFT JOIN employe ON observation_habitat.id_utilisateur = employe.id_employe
        LEFT JOIN veterinaire ON observation_habitat.id_utilisateur = veterinaire.id_veterinaire
        JOIN habitat ON observation_habitat.id_habitat = habitat.id_habitat
        WHERE 1 = 1";

    // Ajouter des conditions aux requêtes en fonction des filtres sélectionnés
    if ($habitat_filter != '') {
        $sql_observations_habitat .= " AND habitat.id_habitat = :habitat_filter";
    }
    if ($date_filter != '') {
        $sql_observations_habitat .= " AND DATE(observation_habitat.date_observation) = :date_filter";
    }
    if ($employe_filter != '') {
        $sql_observations_habitat .= " AND employe.id_employe = :employe_filter";
    }
    if ($veterinaire_filter != '') {
        $sql_observations_habitat .= " AND veterinaire.id_veterinaire = :veterinaire_filter";
    }

    // Préparer et exécuter la requête pour les observations des habitats
    $stmt_observations_habitat = $conn->prepare($sql_observations_habitat);

    if ($habitat_filter != '') {
        $stmt_observations_habitat->bindParam(':habitat_filter', $habitat_filter, PDO::PARAM_INT);
    }
    if ($date_filter != '') {
        $stmt_observations_habitat->bindParam(':date_filter', $date_filter);
    }
    if ($employe_filter != '') {
        $stmt_observations_habitat->bindParam(':employe_filter', $employe_filter, PDO::PARAM_INT);
    }
    if ($veterinaire_filter != '') {
        $stmt_observations_habitat->bindParam(':veterinaire_filter', $veterinaire_filter, PDO::PARAM_INT);
    }

    $stmt_observations_habitat->execute();
    $observations_habitat = $stmt_observations_habitat->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

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
    <h2 class="history-title">Historique des Observations</h2>
</div>
<form method="GET" action="">
        <label for="animal">Animal:</label>
        <select name="animal" id="animal">
            <option value="">Tous</option>
            <?php foreach ($animaux as $animal): ?>
                <option value="<?= htmlspecialchars($animal['id_animal']) ?>"><?= htmlspecialchars($animal['espece']) ?></option>
            <?php endforeach; ?>
        </select>


        <label for="habitat">Habitat:</label>
        <select name="habitat" id="habitat">
            <option value="">Tous</option>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?= htmlspecialchars($habitat['id_habitat']) ?>"><?= htmlspecialchars($habitat['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="<?= htmlspecialchars($date_filter) ?>">

        <label for="employe">Employé:</label>
        <select name="employe" id="employe">
            <option value="">Tous</option>
            <?php foreach ($employes as $employe): ?>
                <option value="<?= htmlspecialchars($employe['id_employe']) ?>"><?= htmlspecialchars($employe['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="veterinaire">Vétérinaire:</label>
        <select name="veterinaire" id="veterinaire">
            <option value="">Tous</option>
            <?php foreach ($veterinaires as $veterinaire): ?>
                <option value="<?= htmlspecialchars($veterinaire['id_veterinaire']) ?>"><?= htmlspecialchars($veterinaire['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <h2>Observations</h2>
<table border="1">
    <tr>
        <th>Date</th>
        <th>Employé</th>
        <th>Vétérinaire</th>
        <th>Habitat</th>
        <th>Animal</th>
        <th>Observation</th>
    </tr>
    <?php if (!empty($observations)): ?>
        <?php foreach ($observations as $observation): ?>
            <tr>
                <td><?= htmlspecialchars($observation['date_observation']) ?></td>
                <td><?= htmlspecialchars($observation['employe'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($observation['veterinaire'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($observation['habitat']) ?></td>
                <td><?= htmlspecialchars($observation['animal']) ?></td>
                <td><?= htmlspecialchars($observation['observation']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">Aucune observation trouvée.</td>
        </tr>
    <?php endif; ?>
</table>
</body>
<script src="../JAVASCRIPT/scripts.js"></script>
</html>

