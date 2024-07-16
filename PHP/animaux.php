<?php
// Connexion à la base de données
require 'database.php';

// Récupération des données du formulaire
$sql = "SELECT * FROM parc_animaux WHERE id = ?";
$stmt = $conn->prepare($sql);

$stmt->execute([1]);
$parc1 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([2]);
$parc2 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([3]);
$parc3 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([4]);
$parc4 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([5]);
$parc5 = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->execute([6]);
$parc6 = $stmt->fetch(PDO::FETCH_ASSOC);


$sql= "SELECT * FROM animaux WHERE id = ?";
$stmt = $conn->prepare($sql);
//lion
$stmt->execute([1]);
$animaux1 = $stmt->fetch(PDO::FETCH_ASSOC);
//perroquet
$stmt->execute([15]);
$animaux2 = $stmt->fetch(PDO::FETCH_ASSOC);
//elephant
$stmt->execute([2]);
$animaux3 = $stmt->fetch(PDO::FETCH_ASSOC);
//giraffe
$stmt->execute([4]);
$animaux4 = $stmt->fetch(PDO::FETCH_ASSOC);
//alligator
$stmt->execute([20]);
$animaux5 = $stmt->fetch(PDO::FETCH_ASSOC);
//hipopotam
$stmt->execute([11]);
$animaux6 = $stmt->fetch(PDO::FETCH_ASSOC);


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
        <title>Le Zoo D'Arcadia/Animaux</title>
</head>
<body>
<header> 
    <a href="../index.php" id="logo-link">
        <img class="survol" src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo Écologique" id="logo">
    </a>                  
    <div class="navbar">                                        
        <ul class="links">
            <li><a href="#">Les Animaux</a></li>
            <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
            <li><a href="../PHP/activites.php">Les Activités</a></li>               
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
            <li><a href="#">Les Animaux</a></li>
            <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
            <li><a href="../PHP/activites.php">Les Activités</a></li>               
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
        <h1>Les Animaux</h1>
</div>

<divider class="divider"></divider>

<table class="tableaux">
    <thead>
        <tr class="tableau">
            <th></th>
            <th>Animal</th>
            <th>Prénom</th>
            <th>Age</th>
            <th>Description</th>
            <th>Habitat</th>
            <th>Etat</th>
        </tr>
    </thead>
<tbody>
        <tr class="tableau">
            <td><img src="<?php echo htmlspecialchars($parc1['images_animaux']); ?>" onclick="recordView(1)" alt="Un lion"><p id="viewCount-1">Nombre de vues: 0</p> </td>
            <td><?php echo htmlspecialchars($animaux1['espece']); ?></td>
            <td><?php echo htmlspecialchars($animaux1['surnom']); ?></td>
            <td><?php echo htmlspecialchars($animaux1['age']); ?></td>
            <td><?php echo htmlspecialchars($parc1['description']); ?></td>
            <td><?php echo htmlspecialchars($habitat2['habitats']); ?></td>
            <td><?php echo htmlspecialchars($animaux1['etat']); ?></td>
    </tr>
        <tr class="tableau">
        <td><img src="<?php echo htmlspecialchars($parc2['images_animaux']); ?>" alt="Un perroquet"></td>
            <td><?php echo htmlspecialchars($animaux2['espece']); ?></td>
            <td><?php echo htmlspecialchars($animaux2['surnom']); ?></td>
            <td><?php echo htmlspecialchars($animaux2['age']); ?></td>
            <td><?php echo htmlspecialchars($parc2['description']); ?></td>
            <td><?php echo htmlspecialchars($habitat1['habitats']); ?></td>
            <td><?php echo htmlspecialchars($animaux2['etat']); ?></td>
    </tr>
        <tr class="tableau">
        <td><img src="<?php echo htmlspecialchars($parc3['images_animaux']); ?>" alt="Un éléphant"></td>
            <td><?php echo htmlspecialchars($animaux3['espece']); ?></td>
            <td><?php echo htmlspecialchars($animaux3['surnom']); ?></td>
            <td><?php echo htmlspecialchars($animaux3['age']); ?></td>
            <td><?php echo htmlspecialchars($parc3['description']); ?></td>
            <td><?php echo htmlspecialchars($habitat2['habitats']); ?></td>
            <td><?php echo htmlspecialchars($animaux1['etat']); ?></td>
        </tr>
        <tr class="tableau">
        <td><img src="<?php echo htmlspecialchars($parc4['images_animaux']); ?>" alt="Une giraffe"></td>
            <td><?php echo htmlspecialchars($animaux4['espece']); ?></td>
            <td><?php echo htmlspecialchars($animaux4['surnom']); ?></td>
            <td><?php echo htmlspecialchars($animaux4['age']); ?></td>
            <td><?php echo htmlspecialchars($parc4['description']); ?></td>
            <td><?php echo htmlspecialchars($habitat2['habitats']); ?></td>
            <td><?php echo htmlspecialchars($animaux4['etat']); ?></td>
        </tr>
        <tr class="tableau">
        <td><img src="<?php echo htmlspecialchars($parc5['images_animaux']); ?>" alt="Un alligator"></td>
            <td><?php echo htmlspecialchars($animaux5['espece']); ?></td>
            <td><?php echo htmlspecialchars($animaux5['surnom']); ?></td>
            <td><?php echo htmlspecialchars($animaux5['age']); ?></td>
            <td><?php echo htmlspecialchars($parc5['description']); ?></td>
            <td><?php echo htmlspecialchars($habitat3['habitats']); ?></td>
            <td><?php echo htmlspecialchars($animaux5['etat']); ?></td>
        </tr>
        <tr class="tableau">
        <td><img src="<?php echo htmlspecialchars($parc6['images_animaux']); ?>" alt="Un hipopotam"></td>
            <td><?php echo htmlspecialchars($animaux6['espece']); ?></td>
            <td><?php echo htmlspecialchars($animaux6['surnom']); ?></td>
            <td><?php echo htmlspecialchars($animaux6['age']); ?></td>
            <td><?php echo htmlspecialchars($parc6['description']); ?></td>
            <td><?php echo htmlspecialchars($habitat3['habitats']); ?></td>
            <td><?php echo htmlspecialchars($animaux6['etat']); ?></td>
        </tr>
    </tbody>
</table>
</main>

<footer>
    <div class="footindex">
        <p>© 2024 Le Zoo D'Arcadia, Website non promotionnel</p>
        <p>Site réalisé dans le cadre d'un ECF à destination de STUDI</p>
        <p>Diverses sources proviennent d'un générateur IA et de différents sites.</p>
    </div>
    <div class="navbar">                                        
        <ul class="links">
            <li><a href="#">Les Animaux</a></li>
            <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
            <li><a href="../PHP/activites.php">Les Activités</a></li>                
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
            <li><a href="#">Les Animaux</a></li>
            <li><a href="../PHP/habitats.php">Leurs Habitats</a></li>
            <li><a href="../PHP/activites.php">Les Activités</a></li>             
            <div class="divider"></div>
            <div class="buttons-burger-menu">
                <a href="../HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
                <a href="../PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
            </div>
        </ul>
    </div>  
</footer>
<script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>