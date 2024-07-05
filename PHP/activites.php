<?php
// Connexion à la base de données
require 'database.php';

// Récupération des données du formulaire
$sql = "SELECT * FROM parc_activites WHERE id = ?";
$stmt = $conn->prepare($sql);

$stmt->execute([1]);
$activite1 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([2]);
$activite2 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([3]);
$activite3 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([4]);
$activite4 = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
<!--pour adapter le format à l'écran utilisé-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!---Stylisation des caractères--->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styles.css">
 <!-- Titre de l'onglet-->
    <title>Le Zoo D'Arcadia</title>
</head>
<body>
    <header>
        <a href="../index.php" id="logo-link">
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo Écologique" id="logo">
        </a>
        <div class="navbar">
            <ul class="links">
                <li><a href="../PHP/animaux.php">Les Animaux</a></li>
                <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
                <li><a href="#">Les Activités</a></li>
            </ul>
            <div class="buttons">
            <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
            <a href="../PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
            </div>
            <div class="burger-menu-button">
            <i class="fas fa-bars"></i>
            </div>
        </div>
                        <!--- RESPONSIVE --->
        <div class="burger-menu">
            <ul class="links">
                <li><a href="../PHP/animaux.php">Les Animaux</a></li>
                <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
                <li><a href="#">Les Activités</a></li>
                <div class="buttons-burger-menu">
                    <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
                    <a href="../PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
                </div>
            </ul>
        </div>
    </header>

<main>

             <!-- Avis des visiteurs -->
<!--- Création d'une fenêtre  popup --->
<button id="open-popup-btn" class="openpopup"> Avis</button>
<div id="popup" class="popup">
    <!-- Utilisation de &times; pour afficher une croix-->
        <span id="close-popup-btn" class="closepopup" >&times;</span>
            <div class="avis", id="avis">
                <!--<h3 class="avis">Avis Clients :</h3>-->
                <ul id="avis-list"></ul>
            </div>
        </div>
    </div>

<div class="titre">
        <h1>Les Activités</h1>
</div>
    <section class="articles" id="activites">
        <div class="titre-p">
            <p>Venez découvrir les activités du Zoo D'Arcadia<br></p>
        </div>
    </section>

        <divider class="divider-act"></divider>

<section class="articles">

    <div class="article">
        <div class="left">
            <img src="<?php echo htmlspecialchars($activite1['activites_images']); ?>" alt="Image de l'activité">
        </div>
        <div class="right">
            <h3><?php echo htmlspecialchars($activite1['nom']); ?></h3>
            <p><?php echo htmlspecialchars($activite1['description']); ?></p>
        </div>
    </div>

    <div class="article">
        <div class="left">
            <img src="<?php echo htmlspecialchars($activite2['activites_images']); ?>" alt="Image de l'activité">
        </div>
        <div class="right">
            <h3><?php echo htmlspecialchars($activite2['nom']); ?></h3>
            <p><?php echo htmlspecialchars($activite2['description']); ?></p>
        </div>
    </div>

    <div class="article">
        <div class="left">
            <img src="<?php echo htmlspecialchars($activite3['activites_images']); ?>" alt="Image de l'activité">
        </div>
        <div class="right">
            <h3><?php echo htmlspecialchars($activite3['nom']); ?></h3>
            <p><?php echo htmlspecialchars($activite3['description']); ?></p>
        </div>
    </div>

    <div class="article">
        <div class="left">
            <img src="<?php echo htmlspecialchars($activite4['activites_images']); ?>" alt="Image de l'activité">
        </div>
        <div class="right">
            <h3><?php echo htmlspecialchars($activite4['nom']); ?></h3>
            <p><?php echo htmlspecialchars($activite4['description']); ?></p>
        </div>
    </div>

</section>
</main>
<footer>
    <div class="footindex">
        <p>© 2024 Le Zoo D'Arcadia, Website non promotionnel</p>
        <p>Site réalisé dans le cadre d'un ECF à destination de STUDI</p>
        <p>Diverses sources proviennent d'un générateur IA et de différents sites.</p>
    </div>
    <div class="navbar">
        <ul class="links">
            <li><a href="../PHP/animaux.php">Les Animaux</a></li>
            <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
            <li><a href="#">Les Activités</a></li>
        </ul>
        <div class="buttons">
            <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
            <a href="../PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
        </div>
        <div class="burger-menu-button">
            <i class="fas fa-bars"></i>
        </div>
    </div>
                    <!--- RESPONSIVE --->
    <div class="burger-menu">
        <ul class="links">
            <li><a href="../PHP/animaux.php">Les Animaux</a></li>
            <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
            <li><a href="#">Les Activités</a></li>
            <div class="divider"></div>
            <div class="buttons-burger-menu">
                <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
                <a href="../PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
            </div>
        </ul>
    </div>
</footer>
            </div>
        </ul>
    </div> 
</footer>  
<script src="../JAVASCRIPT/scripts.js"></script>
</body> 
</html>




