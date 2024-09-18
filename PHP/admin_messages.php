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
try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=localhost;dbname=ecf", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer tous les messages en attente
    $sql = "SELECT * FROM question WHERE statut = 'en_attente'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['valider'])) {
            $id_question = $_POST['id_question'];
            $sql = "UPDATE question SET statut = 'publié' WHERE id_question = :id_question";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_question', $id_question, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: admin_messages.php');
            exit();
        } elseif (isset($_POST['supprimer'])) {
            $id_question = $_POST['id_question'];
            $sql = "DELETE FROM question WHERE id_question = :id_question";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_question', $id_question, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: admin_messages.php');
            exit();
        }
    }
} catch (PDOException $e) {
    // Afficher une erreur en cas de problème de connexion ou d'exécution de la requête
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
<body>
    <h1>Messages en attente</h1>
    <?php if (!empty($questions)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($question['pseudo']); ?></td>
                        <td><?php echo htmlspecialchars($question['adresse_mail']); ?></td>
                        <td><?php echo htmlspecialchars($question['date_commentaire']); ?></td>
                        <td><?php echo htmlspecialchars($question['message']); ?></td>
                        <td>
                            <form action="admin_messages.php" method="POST">
                                <input type="hidden" name="id_question" value="<?php echo $question['id_question']; ?>">
                                <button type="submit" name="valider">Valider</button>
                                <button type="submit" name="supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun message en attente.</p>
    <?php endif; ?>
</body>
</html>