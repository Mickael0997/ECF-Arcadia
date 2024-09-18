<?php
session_start();

if (!isset($_SESSION['id_admin']) || !isset($_SESSION['id_employe'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

// Récupération des données de la table animaux
$query = $conn->query('SELECT * FROM animal');
$animals = $query->fetchAll(PDO::FETCH_ASSOC);

// ACCESSING THE TABLE
$animalInfo = '';
foreach ($animals as $animal) {
    if (is_array($animal)) {
        $animalInfo .= "Surnom: " . htmlspecialchars($animal['surnom']) . "<br>";
        $animalInfo .= "Espèce: " . htmlspecialchars($animal['espece']) . "<br>";
        $animalInfo .= "Etat de santé: " . htmlspecialchars($animal['etat_sante']) . "<br>";
        $animalInfo .= "Age: " . htmlspecialchars($animal['age']) . "<br>";
        $animalInfo .= "Date de naissance: " . htmlspecialchars($animal['date_naissance']) . "<br>";
        $animalInfo .= "Poids: " . htmlspecialchars($animal['poids']) . "<br>";
        $animalInfo .= "Sexe: " . htmlspecialchars($animal['sexe']) . "<br>";
        $animalInfo .= "Race: " . htmlspecialchars($animal['race']) . "<br>";
        $animalInfo .= "Alimentation: " . htmlspecialchars($animal['type_alimentation']) . "<br>";
        $animalInfo .= "<hr>";

        $habitatQuery = $conn->prepare('SELECT nom FROM habitat WHERE id_habitat = :id');
        $habitatQuery->execute(['id' => $animal['id_habitat']]);
        $habitat = $habitatQuery->fetch(PDO::FETCH_ASSOC);
        if ($habitat && is_array($habitat)) {
            $animalInfo .= "Habitat: " . htmlspecialchars($habitat['nom']) . "<br>";
        } else {
            $animalInfo .= "Habitat: Non défini<br>";
        }
    } else {
        $animalInfo .= "Données d'animal incorrectes<br>";
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
        <option value="">Select</option>
        <?php foreach ($animals as $animal): ?>
            <option value="<?php echo $animal['id_animal']; ?>">
                <?php echo htmlspecialchars($animal['surnom']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" name="info" value="Afficher les informations">
    <button onclick="window.location.href='add_animal.php'" class="gest-animaux-button">Ajouter un animal</button>
</form>
    <?php
    if (isset($_POST['animal_selected'])) {
        // Find the selected animal in the $animals array
        $selected_animal = array_filter($animals, function($animal) {
            return $animal['id_animal'] == $_POST['animal_selected'];
        });
        $selected_animal = reset($selected_animal); // Take the first element from the filtered array
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

    <label for="poids">Poids:</label><br>
    <input type="number" id="poids" name="poids" value="<?php echo htmlspecialchars($selected_animal['poids']); ?>"><br>

    <label for="sexe">Sexe:</label><br>
    <input type="text" id="sexe" name="sexe" value="<?php echo htmlspecialchars($selected_animal['sexe']); ?>"><br>

    <label for="race">Race:</label><br>
    <input type="text" id="race" name="race" value="<?php echo htmlspecialchars($selected_animal['race']); ?>"><br>

    <label for="id_habitat">Habitat:</label><br>
    <input type="number" id="id_habitat" name="id_habitat" value="<?php echo htmlspecialchars($selected_animal['id_habitat']); ?>"><br>

    <label for="etat_sante">Etat:</label><br>
    <input type="text" id="etat_sante" name="etat_sante" value="<?php echo htmlspecialchars($selected_animal['etat_sante']); ?>"><br>

    <label for="type_alimentation">Alimentation:</label><br>
    <input type="text" id="type_alimentation" name="type_alimentation" value="<?php echo htmlspecialchars($selected_animal['type_alimentation']); ?>"><br>

    <input type="hidden" name="id_animal" value="<?php echo $selected_animal['id_animal']; ?>"><br>
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
