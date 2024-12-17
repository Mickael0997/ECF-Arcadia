<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/video.css">
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
    </header>

<main>
        <!------ ACCUEIL ------>
        <div class="video-background">
            <video autoplay muted loop id="background-video">
                <source src="../ASSETS/clipzooarcadia.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="background-gradient"></div>
        <!------ DESCRIPTION DU ZOO ------>
        <section class="description-zoo">
            <h2>Bienvenue au Zoo d'Arcadia</h2>
            <p>
                Situé au cœur de la majestueuse forêt de Brocéliande en Bretagne, le Zoo d'Arcadia est un havre de paix pour les animaux et un lieu d'émerveillement pour les visiteurs. Depuis 1960, notre mission est de préserver la biodiversité et de sensibiliser le public à l'importance de la conservation des espèces.
            </p>
            <p>
                Notre zoo abrite une grande variété d'animaux provenant des quatre coins du monde, chacun vivant dans des environnements soigneusement recréés pour refléter leurs habitats naturels. Nous nous engageons à offrir à nos résidents les meilleurs soins possibles, en veillant à leur bien-être physique et mental.
            </p>
            <p>
                La préservation des animaux et l'écologie sont au cœur de nos préoccupations. Nous collaborons avec des organisations de conservation pour protéger les espèces menacées et restaurer leurs habitats naturels. Nos installations écologiques sont conçues pour minimiser notre empreinte environnementale, en utilisant des énergies renouvelables et des pratiques durables.
            </p>
            <p>
                En visitant le Zoo d'Arcadia, vous contribuez à nos efforts de conservation et à la protection de la faune mondiale. Nous vous invitons à découvrir la beauté et la diversité de la nature, tout en apprenant comment chacun de nous peut faire une différence pour un avenir plus durable.
            </p>
        </section>
    </section>
</main>

<footer>
        <?php include'./footer.php';?>
        <?php include '../PHP/avis.php';?> 
</footer>

<script src="../JAVASCRIPT/scripts.js"></script>
</body> 
</html>
