<?php
// Définir la fonction fetchDataAndMap
function fetchDataAndMap($conn, $table, $idColumn, $ids) {
    // Construire la requête SQL
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT * FROM $table WHERE $idColumn IN ($placeholders)";
    
    // Préparer et exécuter la requête
    $stmt = $conn->prepare($sql);
    $stmt->execute($ids);
    
    // Récupérer les résultats
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Mapper les résultats dans un tableau associatif
    $map = [];
    foreach ($results as $row) {
        $map[$row[$idColumn]] = $row;
    }
    
    return $map;
}

// Votre code existant
session_start();
require 'database.php'; // Fichier de configuration pour la connexion à la base de données

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id_employe'])) {
    header('Location: login.php');
    exit;
}

$id_employe = $_SESSION['id_employe'];

try {
    // Récupérer les informations de l'utilisateur connecté
    $sql = "SELECT * FROM employe WHERE id_employe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_employe]);
    $employe = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employe) {
        die('Employé non trouvé.');
    }

// Récupération des données du formulaire
$sql = "SELECT * FROM habitat WHERE id_habitat = ?";
$stmt = $conn->prepare($sql);
//jungle
$stmt->execute([1]);
$habitat1 = $stmt->fetch(PDO::FETCH_ASSOC);
//savane
$stmt->execute([2]);
$habitat2 = $stmt->fetch(PDO::FETCH_ASSOC);
//marais
$stmt->execute([3]);
$habitat3 = $stmt->fetch(PDO::FETCH_ASSOC);


// Partie PHP pour gérer les requêtes POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Enregistrement des observations des habitats
    if (isset($_POST['observation'], $_POST['date_observation'], $_POST['id_habitat'], $_POST['id_utilisateur'])) {
        // Insertion dans la table observation_habitat
        $observation_habitat = $_POST['observation'];
        $date_observation_habitat = $_POST['date_observation'];
        $id_habitat = $_POST['id_habitat'];
        $id_utilisateur_habitat = $_POST['id_utilisateur'];

        $sql = "INSERT INTO observation_habitat (observation, date_observation, id_habitat, id_utilisateur) 
                VALUES (:observation, :date_observation, :id_habitat, :id_utilisateur)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':observation', $observation);
        $stmt->bindParam(':date_observation', $date_observation);
        $stmt->bindParam(':id_habitat', $id_habitat);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur);
        if ($stmt->execute()) {
            echo "Nouvelle observation ajoutée avec succès.";
        } else {
            echo "Erreur d'ajout d'observation : " . $stmt->errorInfo()[2];
        }
    }
}
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
    <div class="g_a_e">
        <h3>Liste des Habitats</h3>
</div>
<div class="g_a_e">
    <div class="g_a_e_I">
        <img src="<?php echo htmlspecialchars($habitat1['image_habitat']); ?>" alt="Une Jungle">
    
<!-- Formulaire pour les observations des habitats -->
    <div class="lab_inp">
        <form action="gest_habitat_employe.php" method="POST">
            <label for="observation">Observation Habitat:</label>
            <textarea name="observation" id="observation" required></textarea>
            <label for="date_observation">Date d'observation:</label>
            <input type="datetime-local" name="date_observation" id="date_observation" required>
            <label for="id_habitat">ID Habitat:</label>
            <input type="number" name="id_habitat" id="id_habitat" required>
            <button type="submit">Ajouter Observation Habitat</button>
        </form>
    </div>
    </div>
</div>
<div class="g_a_e">
    <div class="g_a_e_I">
        <img src="<?php echo htmlspecialchars($habitat2['image_habitat']); ?>" alt="Une Jungle">
    
<!-- Formulaire pour les observations des habitats -->
    <div class="lab_inp">
    <form action="gest_habitat_employe.php" method="POST">
            <label for="observation">Observation Habitat:</label>
            <textarea name="observation" id="observation" required></textarea>
            <label for="date_observation">Date d'observation:</label>
            <input type="datetime-local" name="date_observation" id="date_observation" required>
            <label for="id_habitat">ID Habitat:</label>
            <input type="number" name="id_habitat" id="id_habitat" required>
            <button type="submit">Ajouter Observation Habitat</button>
        </form>
    </div>
    </div>
</div>
<div class="g_a_e">
    <div class="g_a_e_I">
        <img src="<?php echo htmlspecialchars($habitat3['image_habitat']); ?>" alt="Une Jungle">
    
<!-- Formulaire pour les observations des habitats -->
    <div class="lab_inp">
    <form action="gest_habitat_employe.php" method="POST">
            <label for="observation">Observation Habitat:</label>
            <textarea name="observation" id="observation" required></textarea>
            <label for="date_observation">Date d'observation:</label>
            <input type="datetime-local" name="date_observation" id="date_observation" required>
            <label for="id_habitat">ID Habitat:</label>
            <input type="number" name="id_habitat" id="id_habitat" required>
            <button type="submit">Ajouter Observation Habitat</button>
        </form>
    </div>
    </div>
</div>

    </main>
</body>
</html>