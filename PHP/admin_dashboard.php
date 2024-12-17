<?php
require 'database.php';
session_start();

// Vérifiez si l'utilisateur est inactif depuis plus de 5 minutes (300 secondes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 300) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Mettez à jour la dernière activité de l'utilisateur
$_SESSION['last_activity'] = time();

// Vérifiez si l'utilisateur est connecté en tant qu'administrateur ou employé
if (!isset($_SESSION['id_admin']) && !isset($_SESSION['id_employe'])) {
    header('Location: login.php');
    exit();
}

// Récupération des informations de l'utilisateur connecté
if (isset($_SESSION['id_admin'])) {
    $user_id = $_SESSION['id_admin'];
    $sql = "SELECT a.nom, a.prenom, e.fonction 
            FROM administrateur a 
            JOIN employe e ON a.adresse_mail = e.adresse_mail 
            WHERE a.id_admin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $is_admin = true;
} else {
    $user_id = $_SESSION['id_employe'];
    $sql = "SELECT nom, prenom, fonction FROM employe WHERE id_employe = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $is_admin = false;
}

// Vérifiez si l'utilisateur est bien un employé ou un administrateur
if (!$user) {
    header('Location: login.php');
    exit();
}

// Fonction pour récupérer les animaux
function getAnimaux($conn) {
    $sql = "SELECT id_animal, surnom FROM animal";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les habitats
function getHabitats($conn) {
    $sql = "SELECT id_habitat, nom FROM habitat";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les activités
function getActivites($conn) {
    $sql = "SELECT id_activite, nom FROM activite";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les images des animaux et le nombre de vues
function getImagesViews($conn) {
    $sql = "SELECT p.image_animal, p.id_parc, a.surnom, SUM(v.nombre_view) AS total_views
            FROM parc p
            LEFT JOIN view v ON p.id_view = v.id_view
            JOIN animal a ON p.id_animal = a.id_animal
            GROUP BY p.id_parc, a.surnom";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Traitement du formulaire d'ajout d'observation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data) {
        $action = $data['action'];

        if ($action === 'add') {
            $user_name = htmlspecialchars($user['nom'] . ' - ' . $user['prenom'] . ' - ' . $user['fonction']);
            $user_role = isset($_SESSION['id_admin']) ? 'Administrateur' : $user['fonction'];
            $category = htmlspecialchars($data['category']);
            $details = htmlspecialchars($data['details']);

            // Récupération du surnom de l'animal si la catégorie est "animal"
            if ($category === 'zoo' && $data['zoo-category'] === 'animal') {
                $animal_id = htmlspecialchars($data['animal']);
                $sql = "SELECT surnom FROM animal WHERE id_animal = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$animal_id]);
                $animal = $stmt->fetch(PDO::FETCH_ASSOC);
                $animal_surnom = $animal['surnom'];
                $details = "Animal: " . $animal_surnom . ", " . $details;
            }

            $sql = "INSERT INTO journal (user_name, user_role, category, details) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$user_name, $user_role, $category, $details]);

            echo json_encode(['success' => true, 'entry' => [
                'date' => date('Y-m-d H:i:s'),
                'user_name' => $user_name,
                'user_role' => $user_role,
                'category' => $category,
                'details' => $details,
                'id' => $conn->lastInsertId()
            ]]);
            exit();
        }

        // Traitement de la suppression d'une observation
        if ($action === 'delete') {
            $observation_id = htmlspecialchars($data['id']);
            $sql = "DELETE FROM journal WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$observation_id]);

            echo json_encode(['success' => true]);
            exit();
        }

        // Traitement de la modification d'une observation
        if ($action === 'update') {
            $observation_id = htmlspecialchars($data['id']);
            $category = htmlspecialchars($data['category']);
            $details = htmlspecialchars($data['details']);

            $sql = "UPDATE journal SET category = ?, details = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$category, $details, $observation_id]);

            echo json_encode(['success' => true]);
            exit();
        }
    }
}

// Traitement de la recherche par date
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search-date'])) {
    $search_date = htmlspecialchars($_POST['search-date']);

    $sql = "SELECT * FROM journal WHERE DATE(date) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$search_date]);
    $journal_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Récupération des entrées du journal pour aujourd'hui
    $sql = "SELECT * FROM journal WHERE DATE(date) = CURDATE() ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $journal_entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Traitement des modifications et suppressions après le rechargement de la page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'update') {
        $observation_id = htmlspecialchars($_POST['id']);
        $category = htmlspecialchars($_POST['category']);
        $details = htmlspecialchars($_POST['details']);

        $sql = "UPDATE journal SET category = ?, details = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$category, $details, $observation_id]);

        header('Location: admin_dashboard.php');
        exit();
    }

    if ($action === 'delete') {
        $observation_id = htmlspecialchars($_POST['id']);
        $sql = "DELETE FROM journal WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$observation_id]);

        header('Location: admin_dashboard.php');
        exit();
    }
}

// Récupération des animaux, habitats et activités
$animaux = getAnimaux($conn);
$habitats = getHabitats($conn);
$activites = getActivites($conn);
$images_views = getImagesViews($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <title>Tableau de bord Administrateur</title>
</head>
<body>
    <header>
        <div class="title">
            <img class="logo-title" src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo" onclick="location.href='../PHP/index.php';" style="cursor: pointer;">
            <h1 class="title">Bienvenue, <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h1>
        </div>
        <div class="admin-navbar">
            <ul class="links">
                <?php if ($is_admin): ?>
                <li><a href="./employes.php">Gestion du Personnel</a></li>
                <?php endif; ?>
                <li><a href="./gest_animaux.php">Gestion des Animaux</a></li>
                <li><a href="./gest_activites.php">Gestion des Activités</a></li>
                <li><a href="./gest_habitats.php">Gestion des Habitats</a></li>
                <?php if ($is_admin): ?>
                    <li><a href="./historique.php">Historique</a></li>
                <?php endif; ?>
                <li><a class="admin-buttons admin-button" href="./logout.php">Déconnexion</a></li>
            </ul>
        </div> 
    </header>
    <div class="background-gradient"></div>
    <main>
        <div class='modal' id='entry-modal' style="display: none;">
            <div class='modal-overlay'></div>
            <div class='modal-wrapper'>
                <div class='modal-content'>
                    <span class="close">&times;</span>
                    <form id="entry-form" method="POST">
                        <label for="entry-category">Catégorie:</label>
                        <select id="entry-category" name="category" required>
                            <option value="">Sélectionner une catégorie</option>
                            <option value="zoo">Zoo</option>
                            <option value="reunion">Réunion</option>
                        </select><br>
                        <div id="zoo-options" class="category-options">
                            <label for="zoo-category">Type:</label>
                            <select id="zoo-category" name="zoo-category">
                                <option value="">Sélectionner un type</option>
                                <option value="animal">Animal</option>
                                <option value="habitat">Habitat</option>
                                <option value="activite">Activité</option>
                            </select><br>
                            <div id="animal-options" class="category-options">
                                <label for="animal-select">Animal:</label>
                                <select id="animal-select" name="animal">
                                    <option value="">Sélectionner un animal</option>
                                    <?php foreach ($animaux as $animal): ?>
                                        <option value="<?php echo htmlspecialchars($animal['id_animal']); ?>"><?php echo htmlspecialchars($animal['surnom']); ?></option>
                                    <?php endforeach; ?>
                                </select><br>
                                <label for="animal-reason">Raison:</label>
                                <select id="animal-reason" name="reason">
                                    <option value="">Sélectionner une raison</option>
                                    <option value="repas">Repas</option>
                                    <option value="sante">Santé</option>
                                </select><br>
                                <div id="repas-options" class="category-options">
                                    <label for="repas-nourriture">Nourriture:</label>
                                    <select id="repas-nourriture" name="repas-nourriture">
                                        <option value="">Sélectionner une nourriture</option>
                                        <option value="boeufs">Boeufs</option>
                                        <option value="poulets">Poulets</option>
                                        <option value="poissons">Poissons</option>
                                        <option value="legumes">Légumes</option>
                                        <option value="fruits">Fruits</option>
                                    </select><br>
                                    <label for="repas-quantite">Quantité:</label>
                                    <input type="number" id="repas-quantite" name="repas-quantite" min="0"><br>
                                    <label for="repas-unite">Unité:</label>
                                    <select id="repas-unite" name="repas-unite">
                                        <option value="kg">kg</option>
                                        <option value="g">g</option>
                                    </select><br>
                                    <label for="repas-heure">Heure:</label>
                                    <input type="time" id="repas-heure" name="repas-heure"><br>
                                </div>
                                <label for="animal-observation">Observation:</label>
                                <textarea id="animal-observation" name="details"></textarea><br>
                            </div>
                            <div id="habitat-options" class="category-options">
                                <label for="habitat-select">Habitat:</label>
                                <select id="habitat-select" name="habitat">
                                    <?php foreach ($habitats as $habitat): ?>
                                        <option value="<?php echo htmlspecialchars($habitat['id_habitat']); ?>"><?php echo htmlspecialchars($habitat['nom']); ?></option>
                                    <?php endforeach; ?>
                                </select><br>
                                <label for="habitat-observation">Observation:</label>
                                <textarea id="habitat-observation" name="details"></textarea><br>
                            </div>
                            <div id="activite-options" class="category-options">
                                <label for="activite-select">Activité:</label>
                                <select id="activite-select" name="activite">
                                    <?php foreach ($activites as $activite): ?>
                                        <option value="<?php echo htmlspecialchars($activite['id_activite']); ?>"><?php echo htmlspecialchars($activite['nom']); ?></option>
                                    <?php endforeach; ?>
                                </select><br>
                                <label for="activite-observation">Observation:</label>
                                <textarea id="activite-observation" name="details"></textarea><br>
                            </div>
                        </div>
                        <div id="reunion-options" class="category-options">
                            <label for="reunion-start-time">Heure de début:</label>
                            <input type="time" id="reunion-start-time" name="reunion-start-time"><br>
                            <label for="reunion-end-time">Heure de fin:</label>
                            <input type="time" id="reunion-end-time" name="reunion-end-time"><br>
                            <label for="reunion-observation">Observation:</label>
                            <textarea id="reunion-observation" name="details"></textarea><br>
                        </div>
                        <button type="submit">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="journal-container">
    <div id="journal-header">
        <h2 class="admin-title">Journal des observations</h2>
        <div class="journal-buttons">
            <button id="search-entry-button">Rechercher une observation</button>
            <button id="add-entry-button">Ajouter une observation</button>
        </div>
    </div>
    <div class='modal' id='search-modal' style="display: none;">
        <div class='modal-overlay'></div>
        <div class='modal-wrapper'>
            <div class='modal-content'>
                <span class="close">&times;</span>
                <form id="search-form" method="POST" action="admin_dashboard.php">
                    <label for="search-date">Date:</label>
                    <input type="date" id="search-date" name="search-date" required><br>
                    <button type="submit">Rechercher</button>
                </form>
            </div>
        </div>
    </div>
</div>
        <div class="journal-container" id="journal-entries">
            <?php foreach ($journal_entries as $entry): ?>
                <div class="journal-entry">
                    <div class="entry-date"><?php echo htmlspecialchars($entry['date']); ?></div>
                    <div class="entry-user"><?php echo htmlspecialchars($entry['user_name']); ?></div>
                    <div class="entry-details">
                        <strong>Catégorie:</strong> <?php echo htmlspecialchars($entry['category']); ?><br>
                        <strong>Détails:</strong> <?php echo htmlspecialchars($entry['details']); ?>
                    </div>
                    <div class="entry-actions">
                        <form method="POST" action="admin_dashboard.php" style="display:inline;">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($entry['id']); ?>">
                            <input type="hidden" name="category" value="<?php echo htmlspecialchars($entry['category']); ?>">
                            <input type="hidden" name="details" value="<?php echo htmlspecialchars($entry['details']); ?>">
                            <button type="submit" class="edit-button">Modifier</button>
                        </form>
                        <form method="POST" action="admin_dashboard.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($entry['id']); ?>">
                            <button type="submit" class="sup-button">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>    
        <h2 class="title-admin">Les Chouchous</h2>
        <section class="vues">
    <div class="vue">
        <?php if (!empty($images_views)) { ?>
            <?php foreach ($images_views as $image_view) { ?>
                <div class="image-container">
                    <?php if (isset($image_view['image_animal'], $image_view['id_parc'], $image_view['total_views'], $image_view['surnom'])) { ?>
                        <h3 class="animal-name"><?php echo htmlspecialchars($image_view['surnom']); ?></h3>
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
    </main>
    <script src="../JAVASCRIPT/journal.js"></script>
</body>
</html>