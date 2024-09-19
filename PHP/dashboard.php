<?php
session_start();
require 'auth.php';
require 'database.php';

// Vérifiez si l'utilisateur est inactif depuis plus de 5 minutes (300 secondes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Mettez à jour la dernière activité de l'utilisateur
$_SESSION['last_activity'] = time();
// Vérifie si l'utilisateur est connecté et si l'ID employé est défini
if (!isset($_SESSION['id_employe'])) {
    header('Location: login.php');
    exit;
}

$id_employe = $_SESSION['id_employe'];

try {
    // Prépare et exécute la requête
    $sql = "SELECT * FROM employe WHERE id_employe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_employe]);

    // Récupère les résultats
    $employe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employe) {
        die('Employé non trouvé.');
    }
} catch (PDOException $e) {
    die('Erreur de base de données : ' . $e->getMessage());
}

$animal_filter = $_GET['animal'] ?? '';
$habitat_filter = $_GET['habitat'] ?? '';
$date_filter = $_GET['date'] ?? '';

    // Récupérer les données pour les filtres
    $sql = "SELECT id_animal, espece FROM animal";
    $stmt = $conn->query($sql);
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT id_habitat, nom FROM habitat";
    $stmt = $conn->query($sql);
    $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/historique.css">
    <link rel="stylesheet" href="../CSS/employes.css">
    <link rel="stylesheet" href="../CSS/veterinaires.css">
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
    <a href="../PHP/index.php" id="logo-link">
            <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">
        </a>

        <div class="admin-title">  
            <h1 class="titre">Bonjour <?php echo htmlspecialchars($employe['prenom']); ?> !</h1>
        </div> 
        
        <div class="admin-navbar">
            <ul class="links">
            <li><a href="./admin_messages.php">Messsages</a></li>
            <li><a href="./gest_animal_employe.php">Gestion des Animaux</a></li>
            <li><a href="./gest_habitat_employe.php">Gestion des Habitats</a></li>
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
            <li><a href="./admin_messages.php">Messsages</a></li>
                <li><a href="./gest_animal_employe.php">Gestion des Animaux</a></li>
                <li><a href="./gest_habitat_employe.php">Gestion des Habitats</a></li>
                <div class="burger-divider"></div>
                <div class="admin-buttons">
                    <a href="./logout.php" class="admin-action-button">Déconnexion</a>
                </div>
            </ul>
        </div>
</header>
    <main>



</main>


    <footer>

    </footer>
    <!-- JAVASCRIPT  -->
    <script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>
