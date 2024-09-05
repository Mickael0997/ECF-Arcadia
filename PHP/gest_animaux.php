<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

// Récupération des données de la table animaux
$query = $conn->query('SELECT * FROM animaux');
$animaux = $query->fetchAll(PDO::FETCH_ASSOC);

// ACCES A LA TABLE
$animauxInfo = '';
foreach ($animaux as $animal) {
    $animauxInfo .= "Surnom: " . $animal['surnom'] . "<br>";
    $animauxInfo .= "Date de naissance: " . $animal['date_naissance'] . "<br>";
    $animauxInfo .= "Age: " . $animal['age'] . "<br>";
    $animauxInfo .= "Taille: " . $animal['taille'] . "<br>";
    $animauxInfo .= "Poids: " . $animal['poids'] . "<br>";
    $animauxInfo .= "Sexe: " . $animal['sexe'] . "<br>";
    $animauxInfo .= "Race: " . $animal['race'] . "<br>";
    $animauxInfo .= "Habitat: " . $animal['habitats_id'] . "<br>"; // Vous devrez peut-être récupérer le nom de l'habitat à partir de la base de données
    $animauxInfo .= "Etat: " . $animal['etat'] . "<br>";
    $animauxInfo .= "Alimentation: " . $animal['id_RegimeAlimentaires'] . "<br>"; // Vous devrez peut-être récupérer le nom du régime alimentaire à partir de la base de données
    $animauxInfo .= "<hr>";
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
    <link rel="stylesheet" href="../CSS/ges_animaux.css">
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
    <a href="./admin_dashboard.php" id="logo-link">   
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
    <div class="titre">
        <h2>Gestion des Animaux</h2>
    </div>
    <form method="post">
    <select name="animal_selected">
        <option value="">Sélectionner</option>
        <?php foreach ($animaux as $animal): ?>
            <option value="<?php echo $animal['id']; ?>">
                <?php echo htmlspecialchars($animal['surnom']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" name="info" value="Afficher les informations">
    <button onclick="window.location.href='add_animal.php'" class="gest-animaux-button">Ajouter un nouvel animal</button>
</form>
    <?php
    if (isset($_POST['animal_selected'])) {
        // Trouver l'animal sélectionné dans le tableau $animaux
        $selected_animal = array_filter($animaux, function($animal) {
            return $animal['id'] == $_POST['animal_selected'];
        });
        $selected_animal = reset($selected_animal); // Prendre le premier élément du tableau filtré
    ?>
<section class="gest-animaux">   
<form method="post" class="gest-animaux-form">
    <label for="espece">Espèce:</label><br>
    <input type="text" id="espece" name="espece" value="<?php echo htmlspecialchars($selected_animal['espece']); ?>"><br>

    <label for="surnom">Surnom:</label><br>
    <input type="text" id="surnom" name="surnom" value="<?php echo htmlspecialchars($selected_animal['surnom']); ?>"><br>

    <label for="date_naissance">Date de naissance:</label><br>
    <input type="date" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($selected_animal['date_naissance']); ?>"><br>

    <label for="age">Age:</label><br>
    <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($selected_animal['age']); ?>"><br>

    <label for="taille">Taille:</label><br>
    <input type="number" id="taille" name="taille" value="<?php echo htmlspecialchars($selected_animal['taille']); ?>"><br>

    <label for="poids">Poids:</label><br>
    <input type="number" id="poids" name="poids" value="<?php echo htmlspecialchars($selected_animal['poids']); ?>"><br>

    <label for="sexe">Sexe:</label><br>
    <input type="text" id="sexe" name="sexe" value="<?php echo htmlspecialchars($selected_animal['sexe']); ?>"><br>

    <label for="race">Race:</label><br>
    <input type="text" id="race" name="race" value="<?php echo htmlspecialchars($selected_animal['race']); ?>"><br>

    <label for="habitats_id">Habitat:</label><br>
    <input type="number" id="habitats_id" name="habitats_id" value="<?php echo htmlspecialchars($selected_animal['habitats_id']); ?>"><br>

    <label for="etat">Etat:</label><br>
    <input type="text" id="etat" name="etat" value="<?php echo htmlspecialchars($selected_animal['etat']); ?>"><br>

    <label for="id_RegimeAlimentaires">Alimentation:</label><br>
    <input type="number" id="id_RegimeAlimentaires" name="id_RegimeAlimentaires" value="<?php echo htmlspecialchars($selected_animal['id_RegimeAlimentaires']); ?>"><br>

    <input type="hidden" name="animal_id" value="<?php echo $selected_animal['id']; ?>"><br>
    <input type="submit" name="update" value="Mettre à jour">
    <input type="submit" name="delete" value="Supprimer">
</form>
</section>
    <?php
    }
    ?>
    
</main>
<script src="../JAVASCRIPT/scripts.js"></script>   
</body>
</html>
