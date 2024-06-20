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
    <link rel="stylesheet" href="CSS/styles.css">
 <!-- Titre de l'onglet-->    
    <title>Le Zoo D'Arcadia</title>
   
</head>
<body>            
    <header> 
            <img src="ASSETS/LogoArcadia2.png" alt="Logo du Zoo D'Arcadia" id="logo">               
        <div class="navbar">                                        
            <ul class="links">
                <li><a href="../ECF-Arcadia/HTML/parc.htm">Le Zoo</a></li>
                <li><a href="../ECF-Arcadia/HTML/animaux.htm">Les Animaux</a></li>
                <li><a href="../ECF-Arcadia/HTML/habitats.htm">Leurs Habitats</a></li>
                <li><a href="../ECF-Arcadia/HTML/activites.htm">Les Activités</a></li>                
            </ul>  
            <div class="buttons">
            <a href="HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
            <a href="PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
            </div>
            <div class="burger-menu-button">
            <i class="fas fa-bars"></i>
            </div>
        </div>
                        <!--- RESPONSIVE --->
        <div class="burger-menu">
            <ul class="links">
                <li><a href="../ECF-Arcadia/HTML/parc.htm">Le Zoo</a></li>
                <li><a href="../ECF-Arcadia/HTML/animaux.htm">Les Animaux</a></li>
                <li><a href="../ECF-Arcadia/HTML/habitats.htm">Leurs Habitats</a></li>
                <li><a href="../ECF-Arcadia/HTML/activites.htm">Les Activités</a></li>             
                <div class="divider"></div>
                <div class="buttons-burger-menu">
                    <a href="HTML/contact.htm" class="action-button" id="contacte">Contacts</a>
                    <a href="PHP/login.php" class="action-button connexion" id="connexion">Connexion</a>
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
        
    <h1>Bienvenue au Zoo D'Arcadia</h1>
      <img class="alignementLeft" src="./ASSETS/leparc.jpg" alt="Le zoo" id="Le zoo">
    <div>
        <p class="alinetexteLeft">Le Zoo D'Arcadia est un parc zoologique situé en Bretagne, plus précisément dans la région de Brocéliande.<br></p> 
    </div>
    <div>
        <p>Il est ouvert toute l'année et propose de nombreuses activités pour les petits et les grands.<br></p>
    </div> 
    <div>
        <p>Venez découvrir nos animaux et leurs habitats naturels.</p>       
    </div>


    </main>

         
    
<script src="./JAVASCRIPT/scripts.js"></script>
<footer>
    <div class="footextindex">
        <p>© 2024 Le Zoo D'Arcadia</p>
        <p>Site réalisé dans le cadre d'un ECF pour destination STUDI</p>
        <p>Diverses sources proviennent d'un générateur IA et de la région de Brocéliande en Bretagne</p>
      </div>
</footer>  
</body> 
</html>
