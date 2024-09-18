<?php
session_start();

// Vérifiez si l'utilisateur est inactif depuis plus de 5 minutes (300 secondes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Mettez à jour la dernière activité de l'utilisateur
$_SESSION['last_activity'] = time();

// Vérifiez si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}

// Incluez le fichier de connexion à la base de données
require 'database.php';

// Récupération des tables
$tables = ['employe', 'veterinaire', 'animal', 'habitat', 'parc', 'view'];
$data = [];

foreach ($tables as $table) {
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$employes = $data['employe'];
$veterinaires = $data['veterinaire'];
$animaux = $data['animal'];
$habitats = $data['habitat'];

// Gestion des vues des images et des incrémentations
$sql = "SELECT parc.*, SUM(view.nombre_view) AS total_views 
        FROM parc 
        LEFT JOIN view ON parc.id_parc = view.id_animal 
        GROUP BY parc.id_parc";
$stmt = $conn->prepare($sql);
$stmt->execute();
$images_views = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($images_views as $image) {
    $image_animal = $image['id_parc'];
    
    if (!preg_match("/^[0-9]+$/", $image_animal)) {
        continue;
    }

    try {
        $sql = "SELECT nombre_view FROM view WHERE id_animal = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$image_animal]);
        $views = $stmt->fetchColumn();

        if ($views !== false) {
            $views++;
            $sql_update = "UPDATE view SET nombre_view = ? WHERE id_animal = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->execute([$views, $image_animal]);
        } else {
            $views = 1;
            $sql_insert = "INSERT INTO view (id_animal, nombre_view) VALUES (?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->execute([$image_animal, $views]);
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
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

    <main>
        <section>
            <h2 class="view-title">Les Chouchous</h2>
            <section class="vues">
                <div class="vue">
                    <?php if (!empty($images_views)) { ?>
                        <?php foreach ($images_views as $image_view) { ?>
                            <div class="image-container">
                                <?php if (isset($image_view['image_animal'], $image_view['id_parc'], $image_view['total_views'])) { ?>
                                    <img class="vue-image" src="<?php echo htmlspecialchars($image_view['image_animal']); ?>" alt="Image de l'animal" data-id="<?php echo htmlspecialchars($image_view['id_parc']); ?>">
                                    <div class="likes">
                                        <i class="bi bi-heart-fill" style="color: red;"></i>
                                        <span id="viewCount-<?php echo htmlspecialchars($image_view['id_parc']); ?>"><?php echo htmlspecialchars($image_view['total_views']); ?><br></span>
                                    </div>
                                <?php } else { ?>
                                    <p>Données manquantes pour cette vue.</p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p>Aucune vue disponible.</p>
                    <?php } ?>
                </div>
            </section>
        </section>
    </main>
</body>
</html>
