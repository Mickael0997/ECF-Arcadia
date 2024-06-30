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



<!--Accueil-->
<h1 class="titreindex">Bienvenue au Zoo D'Arcadia</h1> 

        <img class="alignementLeft" src="./ASSETS/leparc.jpg" alt="Le zoo" id="Le zoo"><br><br>
            <div class="texteindexLeftU">

                <p>Bienvenue au Zoo D'Arcadia situé en France, à proximité de la majestueuse forêt de Brocéliande en Bretagne, Arcadia accueille les visiteurs depuis 1960.
                Le Zoo Arcadia et la forêt de Brocéliande forment un duo enchanteur, offrant aux visiteurs une expérience unique où la magie des légendes bretonnes rencontre la splendeur de la nature sauvage.<br>
                En visitant Arcadia, vous serez transporté des profondeurs mystérieuses de Brocéliande aux vastes étendues de la savane africaine, en passant par la dense jungle tropicale et les marais luxuriants,transcendant le concept traditionnel de parc animalier.
                </p><br><br><br> 
            </div>
        
        <img class="alignementRight" src="./ASSETS/foretbroceliande.jpg" alt="Forêt" id="Forêt"><br><br><br>
            <div class="texteindexCenter">

                <p>Ce havre de biodiversité offre un cadre naturel exceptionnel où les animaux vivent dans des environnements soigneusement créés pour refléter leurs habitats d'origine.
                Nos installations écologiques</a> couplées à nos équipes de spécialistes dévoués veillent avec une responsabilité intransigeante à la santé physique et mentale de nos résidents, assurant un cadre de vie respectueux et enrichissant.
                </p><br><br><br>
            </div> 
        
        <img class="alignementLeft" src="./ASSETS/singe.jpg" alt="un singe" id="un singe"><br><br>
            <div class="texteindexLeftU">

                <p>En explorant le Zoo D'Arcadia, vous serez amené à rencontrer des animaux merveilleux et fascinants, découvrez notre engagement pour la conservation des espèces et de leur milieu d'habitat naturel.
                Partagez, votre expérience ainsi que vos souvenirs à votre entourage afin de participer directement à la préservation et protection de la vie sauvage.  
                Nature et découverte, une expérience touchante avec des animaux mis en avant pour une aventure inoubliable.<br> 
                Bienvenue au Zoo D'Arcadia.        
                </p><br><br><br>       
            </div>









            <!-- Habitats -->
<h2 class="habitat-titre">Les Habitats</h2>
    <divider class="divider"></divider>

<h3 class="soustitreIhab1">La Jungle</h3>
<article class="containerJungle">
    <div>           
        <img class="container-imageJ" src="./ASSETS/Sanctuaire-des-okapis--Jungle.jpg" alt="Jungle">
        <p class="p-hab1">La jungle, dense et luxuriante, abrite une biodiversité incroyable tels que :<br> 
        de majestueux tigres, d'habiles singes et de perroquets colorés.<br> 
        C'est un monde vibrant de vie et de mystères.</p>
    </div>
</article>


<h3 class="soustitreIhab2">Le Marais</h3>
<article class="containerMarais">  
    <div>             
        <img class="container-imageM" src="./ASSETS/crocodile-marais.jpg" alt="Marais">
        <p class="p-hab1">Le marais, écosystème riche et varié, abrite des animaux sauvages emblématiques tels que :<br> 
        les alligators, les hérons et les tortues.<br> 
        Chacun contribuant à l'équilibre délicat de cet habitat fascinant.</p>
    </div>
</article>


<h3 class="soustitreIhab3">La Savane</h3>
<article class="containerSavane">    
    <div>        
        <img class="container-imageS" src="./ASSETS/Vallee-des-rhinoceros-Savane.jpg" alt="Savanne">
        <p class="p-hab1">La savane, vaste étendue herbeuse parsemée d'acacias, abrite des animaux emblématiques tels que :
        les lions majestueux, les éléphants imposants, les girafes élancées et les zèbres rayés.</p>
    </div>
</article>   



<!-- Activités -->

<h2 class="activite-titre">Les Activitées</h2>
<divider class="divider"></divider>

<article class="f-act">
    
<h3  class="s-t-Iact1">Visite guidée</h3>
    <article class="indactiv1">
        <img class="container-imAct1" src="./ASSETS/petittrainvisiteguidé.jpg" alt="petit train">
        <p class="p-act1">Embarquez pour une aventure captivante, à travers des habitats variés <br>où vous découvrirez des animaux fascinants 
        tout en profitant d'une visite guidée immersive et éducative.</p>
</article>

<h3  class="s-t-Iact2">Ateliers pédagogiques</h3>
    <article class="indactiv2">
        <img class="container-imAct2" src="./ASSETS/ferme.jpg" alt="ferme">
        <p class="p-act1">Participez à des ateliers pédagogiques interactifs et ludiques,<br> 
        où vous pourrez en apprendre davantage sur la faune et la flore.</p>
</article>

<h3  class="s-t-Iact3">Restauration</h3>
    <article class="indactiv3">
        <img class="container-imAct3" src="./ASSETS/point-restauration.jpg" alt="restaurant">
        <p class="p-act1">Profitez d'une pause gourmande en pleine nature avec notre service de restauration, où vous pourrez savourer des mets délicieux tout en observant les animaux. 
        <br>Une expérience unique pour petits et grands, combinant plaisir culinaire et découverte animalière.</p>
</article>


<h3 class="s-t-Iact4">Pour les Kid's</h3>
    <article class="indactiv4">
        <img class="container-imAct4" src="./ASSETS/airejeux.jpg" alt="jeux">
        <p class="p-act1">Les nouveaux airs de jeux pour tout-petits offrent un espace de détente où les enfants peuvent s'amuser tout en découvrant les animaux. 
        <br>Venez profiter d'une journée en famille, alliant découverte et divertissement pour les plus jeunes.</p>
</arcticle>
</article>


<!-- Ecologie -->
<article class="f-eco">
<h2 class="ecologie-titre">Arcadia est écologique</h2>
<divider class="divider"></divider>


<h3 class="s-t-Ieco1">Bornes solaires</h3>
<article class="indeco1">
    <img class="container-imEco1" src="./ASSETS/borne-solaire-bois.jpg" alt="borne solaire">
    <p class="p-eco1">Au cours de votre aventure, vous serez amené à découvrir nos bornes solaires qui fournissent une énergie renouvelable pour les infrastructures, contribuant à la protection de l'environnement tout en améliorant l'expérience des visiteurs.     
    <br>Elles démontrent notre engagement envers des pratiques durables et respectueuses de la nature. </p>
</article>


<h3 class="s-t-Ieco2">Structures photovoltaiques</h3>
<article class="indeco2">
    <img class="container-imEco2" src="./ASSETS/ombriere-solaire-bois-.jpg" alt="ombrière solaire">
    <p class="p-eco1">Toutes nos infrastructures sont équipées de panneaux photovoltaiques afin de garantir une électrité verte en continue</p>
</article>


<h3 class="s-t-Ieco3">Récupérateur d'eaux</h3>
<article class="indeco3">
    <img class="container-imEco3" src="./ASSETS/graf-cuveretention-platineXL.webp" alt="cuve à eaux pluie">
    <p class="p-eco1">Afin de garantir l'eau la plus naturel au possible, nous avons placés dans l'ensemble du parc, des bassins récupérateur d'eaux.<br>
    L'eau de pluie et même la rosé est récupérée dans les bassins et filtré avant d'être utilisée.
    </p>
</article>


<h3 class="s-t-Ieco4">L'électricité par la rivière</h3>
<article class="indeco4">
    <img class="container-imEco4" src="./ASSETS/turbine-riviere.jpg" alt="turbine rivière">
    <p class="p-eco1">L'électricité du parc est aussi fournie par une turbine placée dans la rivière qui traverse l'ensemble du zoo d'Arcadia.</p>
</article>

</article>

</main>

<script src="./JAVASCRIPT/scripts.js"></script>
    <footer>
        <div class="footindex">
            <p>© 2024 Le Zoo D'Arcadia, Website non promotionnel</p>
            <p>Site réalisé dans le cadre d'un ECF à destination de STUDI</p>
            <p>Diverses sources proviennent d'un générateur IA et de différents sites.</p>
        </div>
        <div class="navbar">                                        
            <ul class="links">
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
    </footer>
</body> 
</html>
