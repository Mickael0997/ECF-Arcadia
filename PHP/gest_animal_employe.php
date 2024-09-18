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

    // Récupérer la liste des animaux
    $sql = "SELECT * FROM animal";
    $stmt = $conn->query($sql);
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération et mapping des animaux
    $animalIds = [1, 2, 3, 4, 5, 6];
    $animalMap = fetchDataAndMap($conn, 'animal', 'id_animal', $animalIds);

    // Récupération et mapping des parcs
    $parcIds = [1, 2, 3, 4, 5, 6];
    $parcMap = fetchDataAndMap($conn, 'parc', 'id_parc', $parcIds);

    // Récupérer la liste des types de nourriture
    $sql = "SELECT * FROM nourriture";
    $stmt = $conn->query($sql);
    $nourritures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer la liste des vétérinaires
    $sql = "SELECT * FROM veterinaire";
    $stmt = $conn->query($sql);
    $veterinaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialisation des variables pour affichage
    $infos = [
        ['id_animal' => 1, 'id_parc' => 1],
        ['id_animal' => 2, 'id_parc' => 2],
        ['id_animal' => 3, 'id_parc' => 3],
        ['id_animal' => 4, 'id_parc' => 4],
        ['id_animal' => 5, 'id_parc' => 5],
        ['id_animal' => 6, 'id_parc' => 6],
    ];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['observation'], $_POST['date_observation'], $_POST['id_animal'], $_POST['id_utilisateur'])) {
            // Insertion dans la table observation_animal
            $observation = $_POST['observation'];
            $date_observation = $_POST['date_observation'];
            $id_animal = $_POST['id_animal'];
            $id_utilisateur = $_POST['id_utilisateur'];

            $sql = "INSERT INTO observation_animal (observation, date_observation, id_animal, id_utilisateur) 
                    VALUES (:observation, :date_observation, :id_animal, :id_utilisateur)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':observation', $observation);
            $stmt->bindParam(':date_observation', $date_observation);
            $stmt->bindParam(':id_animal', $id_animal);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);

            if ($stmt->execute()) {
                echo "Nouvelle observation ajoutée avec succès.";
            } else {
                echo "Erreur d'ajout d'observation : " . $stmt->errorInfo()[2];
            }
        }

        // Enregistrement des informations de nourriture
        if (isset($_POST['nourriture'], $_POST['quantite'], $_POST['heure_alimentation'], $_POST['id_animal'])) {
            $type = $_POST['nourriture'];
            $quantite = $_POST['quantite'];
            $heure_alimentation = $_POST['heure_alimentation'];
            $id_animal = $_POST['id_animal'];

            $sql = "INSERT INTO nourriture (type, quantite, heure_alimentation, id_animal) 
                    VALUES (:type, :quantite, :heure_alimentation, :id_animal)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':quantite', $quantite);
            $stmt->bindParam(':heure_alimentation', $heure_alimentation);
            $stmt->bindParam(':id_animal', $id_animal);

            if ($stmt->execute()) {
                echo "Nouvelle nourriture ajoutée avec succès";
            } else {
                echo "Erreur lors de l'insertion dans la table nourriture: " . $stmt->errorInfo()[2];
            }
        }
    }
} catch (PDOException $e) {
    die('Erreur de base de données : ' . $e->getMessage());
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
<body>
    <main>
        <div class="g_a_e">
            <h3>Gestion des Animaux</h3>
        </div>
        <div class="g_a_e">
    <?php foreach ($infos as $assoc) : ?>
        <?php
            $animal = $animalMap[$assoc['id_animal']];
            $parc = $parcMap[$assoc['id_parc']];
        ?>
        <div class="g_a_e_I">
            <a href="<?php echo htmlspecialchars($animal['id_animal']); ?>">
                <img src="<?php echo htmlspecialchars($parc['image_animal']); ?>" 
                alt="<?php echo htmlspecialchars($animal['espece']); ?>">
                <i data-id="<?php echo htmlspecialchars($animal['id_animal']); ?>"></i>
            </a>
            <div class="lab_inp">
                <p class="title"><?php echo htmlspecialchars($animal['espece']); ?></p>
                <p><strong>Surnom :</strong> <?php echo htmlspecialchars($animal['surnom']); ?></p>
                <p><strong>Âge :</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
                <br>
                <!-- Formulaire pour ajouter une observation et de la nourriture -->
                <form action="gest_animal_employe.php" method="post">
                    <label for="observation">Observation:</label><br>
                    <textarea name="observation" id="observation" required></textarea><br>
                    <label for="date_observation">Date d'observation:</label><br>
                    <input type="datetime-local" name="date_observation" id="date_observation" required><br>

                    <label for="nourriture">Nourriture:</label><br>
                    <textarea name="nourriture" id="nourriture" required>
                        <?php foreach ($nourritures as $nourriture): ?>
                            <?= htmlspecialchars($nourriture['type']) . "\n" ?>
                        <?php endforeach; ?>
                    </textarea><br>
                    <label for="quantite">Quantité:</label><br>
                    <input type="text" name="quantite" id="quantite" required><br>
                    <label for="heure_alimentation">Heure d'alimentation:</label><br>
                    <input type="time" name="heure_alimentation" id="heure_alimentation" required><br>
                    <input type="hidden" name="id_animal" value="<?= htmlspecialchars($animal['id_animal']) ?>">
                    <input type="hidden" name="id_utilisateur" value="<?= htmlspecialchars($id_employe) ?>">
                    <button type="submit">Enregistrer</button>
                </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
