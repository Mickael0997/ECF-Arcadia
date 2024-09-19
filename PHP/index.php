<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/historique.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Accueil</title>
</head>

<body>
    <header>           
        <?php include './header.php'; ?>  
        <?php include './avis.php';?>
    </header>

<main>
            <!------ ACCUEIL------>
<div>
    <h1>Bienvenue au Zoo D'Arcadia</h1>
</div>

<divider class="divider"></divider>

            <!------ LE PARC ------>

<div onclick="toggleParc()">           
    <h2>Le Parc</h2>
</div>


<section class="articles" id="parc-section" style="display: none;">
    
    <div class="article">
        <div>
            <img src="../ASSETS/leparc.jpg" alt="Le zoo" onclick="toggleDescription(this)" id="Le zoo"><br><br>
        </div>
        <div>
            <h3>Le Zoo D'Arcadia</h3>
        </div>
        <div>
            <p class="description">
            Bienvenue au Zoo D'Arcadia situé en France, à proximité de la majestueuse forêt de Brocéliande en Bretagne, Arcadia accueille les visiteurs depuis 1960.
            <br>Le Zoo Arcadia et la forêt de Brocéliande forment un duo enchanteur, offrant aux visiteurs une expérience unique où la magie des légendes bretonnes rencontre la splendeur de la nature sauvage.<br>
            </p>
        </div>
    </div>

    <div class="article">
        <div>
            <img src="../ASSETS/foretbroceliande.jpg" alt="Forêt" onclick="toggleDescription(this)" id="Forêt"><br><br>
        </div>
        <div>
            <h3>Notre Mission</h3>
        </div>
        <div>
            <p class="description">
            Ce havre de biodiversité offre un cadre naturel exceptionnel où les animaux vivent dans des environnements soigneusement créés pour refléter leurs habitats d'origine.
            <br>Nos installations écologiques</a> couplées à nos équipes de spécialistes dévoués veillent avec une responsabilité intransigeante à la santé physique et mentale de nos résidents, assurant un cadre de vie respectueux.
            </p>
        </div> 
    </div>

    <div class="article">
        <div>
            <img src="../ASSETS/singe.jpg" alt="un singe" onclick="toggleDescription(this)" id="un singe"><br><br>
        </div>    
        <div>
            <h3>Notre Engagement</h3>
        </div>
        <div>
            <p class="description">
            En explorant le Zoo D'Arcadia, vous serez amené à rencontrer des animaux merveilleux et fascinants, découvrez notre engagement pour la conservation des espèces et de leur milieu d'habitat naturel.
            <br><br>Partagez, votre expérience ainsi que vos souvenirs à votre entourage afin de participer directement à la préservation et protection de la vie sauvage.     
            </p>       
        </div>
    </div>
</section>


            <!------ HABITATS ------>

    <div onclick="toggleHabitats()">            
        <h2>Les Habitats</h2>
    </div>    


    <section class="articles" id="habitats-section" style="display: none;">
        <div class="article">
            <div>    
                <img src="../ASSETS/Sanctuaire-des-okapis--Jungle.jpg" alt="Jungle" onclick="toggleDescription(this)">
            </div>    
            <div>
                <h3>La Jungle</h3>
            </div>
            <div>
                <p class="description">La jungle, dense et luxuriante, abrite une biodiversité incroyable tels que :
                    <br> des tigres majestueux tigres 
                    <br> des singes mâlins 
                    <br> des perroquets colorés
                    <br> C'est un monde vibrant de vie et de mystères.</p>
            </div>
        </div>

        <div class="article">      
            <div>
                <img src="../ASSETS/crocodile-marais.jpg" alt="Marais" onclick="toggleDescription(this)">
            </div>
            <div>
                <h3>Le Marais</h3>
            </div>
            <div> 
                <p class="description">Le marais, écosystème riche et varié, abrite des animaux sauvages emblématiques tels que :
                    <br> les alligators 
                    <br> les hérons 
                    <br> des tortues
                    <br> Chacun contribuant à l'équilibre délicat de cet habitat fascinant.</p>
            </div>
        </div>

        <div class="article">                
            <div>
                <img src="../ASSETS/Vallee-des-rhinoceros-Savane.jpg" alt="Savanne" onclick="toggleDescription(this)">
            </div>    
            <div>
                <h3>La Savane</h3>
            </div>
            <div>
                <p class="description">La savane, vaste étendue herbeuse parsemée d'acacias, abrite des animaux emblématiques tels que :
                    <br> des magnifiques lions 
                    <br> des éléphants imposants 
                    <br> des girafes élancées 
                    <br> des zèbres rayés.
                    <br> La savane vous séduira</p>
            </div>
        </div>
    </section>


<!-- Activités -->

<div onclick="toggleActivity()"> 
    <h2>Nos Services</h2>
</div>
    

<section class="articles" id="activity-section" style="display: none;">

    <div class="article">
        <div>
            <img src="../ASSETS/petittrainvisiteguide.jpg" alt="petit train" onclick="toggleDescription(this)">
        </div>
        <div>
            <h3>Visite guidée</h3>
        </div>
        <div>
            <p class="description">Embarquez pour une aventure captivante, à travers des habitats variés <br>où vous découvrirez des animaux fascinants 
            tout en profitant d'une visite guidée immersive et éducative.</p>
        </div>
    </div>
    <div class="article">
        <div>
            <img src="../ASSETS/ferme.jpg" alt="ferme" onclick="toggleDescription(this)">
        </div>
        <div>
            <h3>Ateliers</h3>
        </div>
        <div>
            <p class="description">Participez à des ateliers pédagogiques interactifs et ludiques,<br> 
            où vous pourrez en apprendre davantage sur la faune et la flore.</p>
        </div>
    </div>

    <div class="article">
            <div>
                <img src="../ASSETS/point-restauration.jpg" alt="restaurant" onclick="toggleDescription(this)">
            </div>
            <div>
                <h3>Restaurations</h3>
            </div>
            <div>
                <p class="description">Profitez d'une pause gourmande en pleine nature avec notre service de restauration, où vous pourrez savourer des mets délicieux tout en observant les animaux. 
                <br>Une expérience unique pour petits et grands, combinant plaisir culinaire et découverte animalière.</p>
            </div>
    </div>
</section>

<!-- Ecologie -->

<div onclick="toggleEco()"> 
    <h2>L'écologique</h2>
</div>


<section class="articles" id="eco-section" style="display: none;">
    
    <div class="article">
        <div>
            <img src="../ASSETS/borne-solaire-bois.jpg" alt="borne solaire" onclick="toggleDescription(this)">
        </div>
        <div>
            <h3>Bornes solaires</h3>
        </div>
        <div>
            <p class="description">Au cours de votre aventure, vous serez amené à découvrir nos bornes solaires qui fournissent une énergie renouvelable pour les infrastructures, contribuant à la protection de l'environnement tout en améliorant l'expérience des visiteurs.     
            <br>Elles démontrent notre engagement envers des pratiques durables et respectueuses de la nature. </p>
        </div>
    </div>

            
<div class="article">
        <div>
            <img src="../ASSETS/ombriere-solaire-bois-.jpg" alt="ombrière solaire" onclick="toggleDescription(this)">
        </div>
        <div>
            <h3>Structures photovoltaiques</h3>
        </div>
        <div>
            <p class="description">Toutes nos infrastructures sont équipées de panneaux photovoltaiques afin de garantir une électrité verte en continue</p>

        </div>
</div>


    <div class="article">
        <div>
            <img src="../ASSETS/graf-cuveretention-platineXL.webp" alt="cuve à eaux pluie" onclick="toggleDescription(this)">
        </div>
        <div>
            <h3>Récupérateur d'eaux</h3>
        </div>
        <div>
            <p class="description">Afin de garantir l'eau la plus naturel au possible, nous avons placés dans l'ensemble du parc, des bassins récupérateur d'eaux.<br>
            L'eau de pluie et même la rosé est récupérée dans les bassins et filtré avant d'être utilisée.
            </p>
        </div>
    </div>
</section>
</main>

<footer>
        <?php include'./footer.php';?>
</footer>

<script src="../JAVASCRIPT/scripts.js"></script>
</body> 
</html>
