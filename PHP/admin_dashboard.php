<?php
session_start();

// Démarrez la session si elle n'est pas déjà démarrée
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Vérifiez si la variable de session 'last_activity' est définie
if(isset($_SESSION['last_activity'])) {
    // Vérifiez si l'utilisateur est inactif depuis plus de 5 minutes (300 secondes)
    if(time() - $_SESSION['last_activity'] > 300) {
        // Si oui, détruisez la session et redirigez l'utilisateur vers la page de connexion
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

// Mettez à jour la dernière activité de l'utilisateur
$_SESSION['last_activity'] = time();

// Vérifiez si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Incluez le fichier de connexion à la base de données
require 'database.php';

try {
// Récupération des tables
$tables = ['employes', 'veterinaires', 'animaux', 'parc_activites', 'habitats', 'parc_animaux', 'record_view'];
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

    // Récupération des images et des vues
    $sql = "SELECT parc_animaux.*, record_view.views FROM parc_animaux LEFT JOIN record_view ON parc_animaux.id = record_view.images_animaux_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $images_views = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT commentaires.comments, commentaires.date, employes.nom as employe, animaux.espece, habitats.nom as habitat, veterinaires.nom as veterinaire
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
    $commentaire = $_POST['comments'];

    $sql = "INSERT INTO commentaires (employe_id, animal_id, habitat_id, comments, date) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$employe_id, $animal_id, $habitat_id, $comments]);

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
    <title>Tableau de bord Administrateur</title>
</head>
<body>
    <header>

        <a href="../PHP/index.php" id="logo-link">
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
                <li><a href="./historique.php">Historique</a></li>
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
                <li><a href="./historique.php">Historique</a></li>
                <div class="burger-divider"></div>
                <div class="admin-buttons">
                    <a href="./logout.php" class="admin-action-button">Déconnexion</a>
                </div>
            </ul>
        </div>
</header>
<div class="admin-title">
        <h2>Journal de bord</h2>
</div> 
    <main>
<section>
    <h2 class="view-title">Les Chouchous</h2>
<section class="vues">
    <div class="vue">
        <?php foreach ($images_views as $image_view) { ?>
            <div class="image-container">
                <img class="vue-image" src="<?php echo htmlspecialchars($image_view['images_animaux']); ?>" alt="Image de l'animal" data-id="<?php echo htmlspecialchars($image_view['id']); ?>">
                <div class="likes">
                <i class="bi bi-heart-fill" style="color: red;"></i>
                    <span id="viewCount-<?php echo htmlspecialchars($image_view['id']); ?>"><?php echo htmlspecialchars($image_view['views']); ?><br></span>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
</main>
<footer>
</footer>
<script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>





