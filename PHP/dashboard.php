<?php
require 'auth.php';
require 'database.php';

// Fait appel à la table employes
$employe_id = $_SESSION['id'];
$sql = "SELECT * FROM employes WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$stmt->execute([$employe_id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupère la table ANIMAUX
$sql = "SELECT * FROM animaux";
$stmt = $conn->query($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les commentaires de la base de données pour les animaux
$sql = "SELECT commentaires.comments, animaux.espece FROM commentaires INNER JOIN animaux ON commentaires.animal_id = animaux.id";
$stmt = $conn->query($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$commentaires_animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère la table HABITATS
$sql = "SELECT id, nom FROM habitats"; // Ajout de 'nom' pour récupérer le nom de l'habitat
$stmt = $conn->query($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les commentaires de la base de données pour les habitats
$sql = "SELECT commentaires.comments, habitats.nom, habitats.images_habitats, habitats.description 
        FROM commentaires 
        INNER JOIN habitats ON commentaires.habitat_id = habitats.id"; // Correction ici
$stmt = $conn->query($sql);

if (!$stmt) {
    die(print_r($conn->errorInfo(), true));
}

$commentaires_habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$commentaires_habitats) {
    die("Aucun commentaire trouvé.");
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
            <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo Écologique" id="logo">
        </a>
        
        <div class="admin-title">  
            <h1 class="titre">Bonjour <?php echo htmlspecialchars($employe['prenom']); ?> !</h1>
        </div> 
        
        <di class="admin-navbar">
            <ul class="links">
                <li><a href="./traitement.php">Tâches</a></li>
                <li><a href="./nourriture.php">Enregistrer la Nourriture</a></li>
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
                <li><a href="./traitement.php">Tâches</a></li>
                <li><a href="./nourriture.php">Enregistrer la Nourriture</a></li>
                <div class="burger-divider"></div>
                <div class="admin-buttons">
                    <a href="./logout.php" class="admin-action-button">Déconnexion</a>
                </div>
            </ul>
        </div>
    </header>
    <main>
    <div class="btn-historique"><a href="./historique.php">Consulter la main courante</a>

    <div class="admin-title">
        <h2 class="titre">Journal de bord</h2>
    </div>
<!--Enregistrer les commentaires ANIMAUX-->
<table class="tables-dash">
    <thead>
        <tr class="table-dash">
            <form id="animalForm" method="post">
                <th><label for="animal">Animal :</label></th>
                <th><label for="comment">Commentaire :</label></th>
                <th><label for="valid"></label>Valider :</label></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> <select id="animal" name="animal_id" required>
                    <?php foreach ($animaux as $animal) { ?>
                    <option value="<?php echo $animal['id']; ?>"><?php echo $animal['espece']; ?></option>
                    <?php } ?>
            </select><br></td>
            <td><textarea id="comments" name="commentaire" required></textarea></td>
            <td><input type="submit" value="Soumettre"></td>
            </form>
        </tr>
    </tbody>
</table>


<!--Enregistrer les commentaires HABITATS-->

<table class="tables-dash">
    <thead>
        <tr class="table-dash">
            <th><label for="habitatSelect">Habitat :</label></th>
            <th><label for="habitatComments">Commentaire :</label></th>
            <th><label for="valid">Valider :</label></th>
        </tr>
    </thead>
    <form id="habitatForm" method="post">
    <tbody>
        <tr>
            <td> <select id="habitatSelect" name="habitats_id" required>
                    <?php foreach ($habitats as $habitat) { ?>
                    <option value="<?php echo $habitat['id']; ?>"><?php echo $habitat['nom']; ?></option>
                    <?php } ?>
            </select><br></td>
            <td><textarea id="habitatComments" name="commentaire" required></textarea></td>
            <td><input type="submit" value="Soumettre"></td>
        </tr>
    </tbody>
    </form>
</table>

</main>


    <footer>

    </footer>
    <!-- JAVASCRIPT  -->
    <script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>
