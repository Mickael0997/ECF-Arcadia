<?php
// Connexion à la base de données
require 'database.php';

// Récupération des données du formulaire
$sql = "SELECT * FROM habitats WHERE id = ?";
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
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">               
        </a>
    <div class="navbar">                                        
        <ul class="links">
            <li><a href="./animaux.php">Les Animaux</a></li>
            <li><a href="#">Leurs Habitats</a></li>    
            <li><a href="./activites.php">Les Activités</a></li>                
        </ul>  
        <div class="buttons">
            <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
            <a href="./PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
        </div>
        <div class="burger-menu-button">
            <i class="fas fa-bars"></i>
        </div>
    </div>
                        <!--- RESPONSIVE --->
    <div class="burger-menu">
        <ul class="links">
        <li><a href="./animaux.php">Les Animaux</a></li>
            <li><a href="#">Leurs Habitats</a></li>    
            <li><a href="./activites.php">Les Activités</a></li>            
                <div class="buttons-burger-menu">
                    <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
                    <a href="./PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
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
    <h2>Leurs Habitats</h2>
    <p class="titre-p">Les animaux d'Arcadia sont répartis dans les différents habitats présentés ci-dessous.<br>
    Nous nous sommes efforcé de représenter au mieux leur milieu naturel afin qu'ils puissent y vivre le plus paisiblement possible. </p>
</div>    

<divider class="divider-hab"></divider>

<section class="articles">
        
<div class="article">
    <div class="left">   
    <img src="<?php echo htmlspecialchars($habitat1['images_habitats']); ?>" alt="Une Jungle">
    </div>
    <div class="right">    
        <h3><?php echo htmlspecialchars($habitat1['habitats']); ?></h3>
        <p><?php echo htmlspecialchars($habitat1['description']); ?></p>
    </div>
</div>

<div class="article">    
    <div class="left">  
    <img src="<?php echo htmlspecialchars($habitat2['images_habitats']); ?>" alt="Une Savanne">
    </div>
    <div class="right">   
        h3><?php echo htmlspecialchars($habitat2['habitats']); ?></h3>
        <p><?php echo htmlspecialchars($habitat2['description']); ?></p>
    </div>
</div>

<div class="article">
    <div class="left">       
    <img src="<?php echo htmlspecialchars($habitat3['images_habitats']); ?>" alt="Un Marais">
    </div>
    <div class="right">
        <h3><?php echo htmlspecialchars($habitat3['habitats']); ?></h3>
        <p><?php echo htmlspecialchars($habitat3['description']); ?></p>
    </div> 
</div>

</section>
    </main>    
<script src="../JAVASCRIPT/scripts.js"></script>
<footer>
    <div class="footindex">
        <p>© 2024 Le Zoo D'Arcadia, Website non promotionnel</p>
        <p>Site réalisé dans le cadre d'un ECF à destination de STUDI</p>
        <p>Diverses sources proviennent d'un générateur IA et de différents sites.</p>
    </div>
    <div class="navbar">                                        
        <ul class="links">
        <li><a href="./animaux.php">Les Animaux</a></li>
            <li><a href="#">Leurs Habitats</a></li>    
            <li><a href="./activites.php">Les Activités</a></li>                
        </ul>  
        <div class="buttons">
            <a href="HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
            <a href="./PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
        </div>
        <div class="burger-menu-button">
            <i class="fas fa-bars"></i>
        </div>
    </div>
                    <!--- RESPONSIVE --->
    <div class="burger-menu">
        <ul class="links">
        <li><a href="./animaux.php">Les Animaux</a></li>
            <li><a href="#">Leurs Habitats</a></li>    
            <li><a href="./activites.php">Les Activités</a></li>            
            <div class="divider"></div>
            <div class="buttons-burger-menu">
                <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
                <a href="./PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
            </div>
        </ul>
    </div>   
</footer>  
</body> 
</html>
