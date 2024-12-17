<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Navbar Responsive</title>
</head>
<body>
    <header>
        <div  class="logo">
            <a href="./index.php" id="logo-link">
                <img src="../ASSETS/Logo.png" alt="Logo du Zoo D'Arcadia" id="logo">
            </a>
        </div> 
        <div class="navbar-toggle" id="navbar-toggle">
            <i class="fas fa-bars" id="navbar-icon"></i>
        </div>
        <nav class="navbar" id="navbar">
            <ul class="links">
                <li>
                    <a href="#" class="menu-title" data-target="animaux-menu">Les Animaux</a>
                    <ul class="submenu" id="animaux-menu">
                        <li><a href="./mammiferes.php">Mammifères</a></li>
                        <li><a href="./oiseaux.php">Oiseaux</a></li>
                        <li><a href="./reptiles.php">Reptiles</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-title" data-target="habitats-menu">Leurs Habitats</a>
                    <ul class="submenu" id="habitats-menu">
                        <li><a href="./jungle.php">La Jungle</a></li>
                        <li><a href="./marais.php">Le Marais</a></li>
                        <li><a href="./savane.php">La Savane</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="menu-title" data-target="services-menu">Nos Services</a>
                    <ul class="submenu" id="services-menu">
                        <li><a href="./guide.php">Visite Guidée</a></li>
                        <li><a href="./Restauration.php">Restauration</a></li>
                        <li><a href="./ferme.php">Activités</a></li>
                    </ul>
                </li>
                <li><a href="../ASSETS/planparc.jpg">Plan du Zoo</a></li>
                <li><a href="../HTML/contact.htm">Contact</a></li>
                <li><a href="./login.php">Se connecter</a></li>
            </ul>
        </nav>
    </header>

    <div id="image-modal" class="modal">
        <span class="close">&times;</span>
        <img id="modal-image" src="" alt="Plan du Zoo">
    </div>

    <script src="../JAVASCRIPT/header.js"></script>
</body>
</html>
