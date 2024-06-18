/* Reset Style*/
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/*Personnalisation du corp*/

/*Mise en forme de l'image background*/
body {
        background-image: url(../ASSETS/pexels-pixabay-33045.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

/*Mise en forme du logo img*/
img {
    width: 200px;
    height: 200px;
}
/*Mise en forme de la liste*/
li{
    list-style-type: none;
    margin: 0;
    padding: 0;
}

/*Mise en forme des éléments de la liste*/
a{
    text-decoration: none;
    color: rgb(255, 255, 255);
    font-size: 20px;
}

/*Application du Hover*/
a:hover{
    color: #cdf80b;
}

/*Mise en forme du header*/
header{
    display: flex;
    align-items: center;
    position: relative;
    padding: 0 2rem;
    background-color: rgba(0, 0, 0, 0.466)
}

/*Mise en forme de la navbar*/
.navbar{
    width: 100%;
    max-width: 1200px;
    height: 60px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/*Mise en forme de la liste*/
.navbar .links{
    display: flex;
    gap: 2rem;
}

/*Mise en place d'un sélécteur pour agir sur les premiers parents*/
header > ul{
    display: flex;
    cursor: pointer;
    color: white;
    list-style: none;
}

.sousmenu li a{
    text-decoration:none;
    color: white;
    display: block;
    padding: 20px;
}

/*Mise en forme du burger menu*/

.navbar .burger-menu-button{
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: none;
}

/*Mise en forme des boutons*/
.buttons {
    display: flex;
    gap: 10px;
}

/*Stylisation du bouton contacte*/
.action-button{
    background-color: greenyellow;
    color: black;
    border: 1px solid greenyellow;
    padding: 0.5rem 1.2rem;
    border-radius: 5px;
    outline: none;
    font-size: 0.9rem;
    font-weight: bold;
    cursor: pointer;
}

/*Mise en place du survole pour le bouton contacte */
.action-button:hover {
    color: white;
    border: 1px solid white;
}

/*Mise en place du bouton connexion*/
.connexion{
    background-color: transparent;
    color: white;
    border: 1px solid white;
}

/*Mise ne place du survole pour le bouton connexion*/
.connexion:hover{
    background-color: white;
    color: black;
}

/*Mise en forme du texte avis*/
.avis{
    color: aliceblue;
    position: relative; /* Position fixe par rapport à la fenêtre de visualisation */
    right: 0; /* Aligné à droite */
    top: 50%; /* Centré verticalement */
    transform: translateY(-50%); /* Décale le titre vers le haut de sa propre hauteur pour le centrer parfaitement */    
    border: 1px solid;
    border-radius: 20px;
    background-color: green;
    display: flex;
    width: max-content; 
}


/*Mise en formes des pages*/
.parc{
    background-image: url(../ASSETS/beau-ciel-plein-etoiles-trona-californie.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

.animaux{
    background-image: url(../ASSETS/lionpandagorille.png);
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

.activity{
    background-image: url(../ASSETS/fdactivite.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;

}

.billeterie{
    background-image: url(../ASSETS/fdbilleterie.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

.souvenirs{
    background-image: url(../ASSETS/fdsouvenirs.jpg);
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}



/*---------------------Burger Menu-----------------*/

/*Mise en forme du burger menu*/
.burger-menu{
    display: none;
    height: 0;
    position: absolute;
    right: 1rem;
    top: 90px;
    width: 160px;
    background: black(0,0,0,0.2);
    backdrop-filter: blur(10px);
    border-radius: 110px;
    overflow: hidden;
    transition: height 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275)
}

/*Mise en place de l'ouverture du menu burger*/
.burger-menu.open{
    height: 260px;
}
/*Mise en forme de la liste du burger menu*/
.burger-menu li{
    padding: 0,7rem;
    display: flex;
    align-items: center;
    justify-content: center;    
}

/*Mise en forme de divider*/
.divider{
    height: 1px;
    background-color: white;
    width: 80%;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 1rem;
}

/*Mise en forme des buttons*/
.burger-menu .action-button{
    display: flex;
    justify-content: center;
    align-items: center;
}

/*Mise en forme de la liste du burger menu*/
.button-burger-menu{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 10px;
}
/*---------------------RESPONSIVE-----------------*/
/*Les @Medias*/

/*Mise en forme des éléments de la liste en fonction de la taille de l'écran*/
@media (max-width: 1004px) {
    header {
        background: none;
    }
    
    .navbar .links,
    .navbar .action-button {
        display: none;
    }

    .navbar .burger-menu-button{
        display: block;
    }

    .burger-menu{
        display: block;

    }
}
@media (max-width: 576px) {

    .burger-menu{
        display: flex;
        align-items: center;
        width: auto;
        font-size: 10px;
    }
}