<?php
require 'auth.php';
require 'database.php';

// Fait appel à la table employes
$employe_id = $_SESSION['id'];
$sql = "SELECT * FROM employes WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$stmt->execute([$employe_id]);
$employe = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupère la table ANIMAUX
$sql = "SELECT * FROM animaux";
$stmt = $conn->query($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les commentaires de la base de données pour les animaux
$sql = "SELECT commentaires.commentaire, animaux.espece FROM commentaires INNER JOIN animaux ON commentaires.animal_id = animaux.id";
$stmt = $conn->query($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$commentaires_animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère la table HABITATS
$sql = "SELECT * FROM habitats";
$stmt = $conn->query($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les commentaires de la base de données pour les habitats
$sql = "SELECT commentaires.commentaire, habitats.habitats FROM commentaires INNER JOIN habitats ON commentaires.habitat_id = habitats.id";
$stmt = $conn->query($sql);

if (!$stmt) {
    die($conn->errorInfo());
}

$commentaires_habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../CSS/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <div>    
            <a href="./index.php" id="logo-link">
            <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo Écologique" id="logo"></a>
        </div>
        <nav>
<div>            
    <ul>
        <li><a href="./nourriture.php">Enregistrer la Nourriture</a></li>
    </ul>
</div>
</nav>
  <div>  
    <h1 class="titre">Bonjour <?php echo htmlspecialchars($employe['prenom']); ?> !</h1>
       </div> 
        
 
    </header>
    <main>
    <div class="btn-historique"><a href="./historique.php">Consulter la main courante</a>
        </div>
       <div>
       <nav>
            <ul>
                <li class="deco"><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </div>

        <h2 class="titre">Journal de bord</h2>

       
<!--Enregistrer les commentaires ANIMAUX-->
<table class="tables-dash">
    <thead>
        <tr class="table-dash">
            <form id="animalForm" method="post">
                <th><label for="animal">Animal :</label></th>
                <th><label for="comment">Commentaire :</label></th>
                <th><label for="valid"></label>Valider :</label></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> <select id="animal" name="animal_id" required>
                    <?php foreach ($animaux as $animal) { ?>
                    <option value="<?php echo $animal['id']; ?>"><?php echo $animal['espece']; ?></option>
                    <?php } ?>
            </select><br></td>
            <td><textarea id="comment" name="commentaire" required></textarea></td>
            <td><input type="submit" value="Soumettre"></td>
            </form>
        </tr>
    </tbody>
</table>


<!--Enregistrer les commentaires HABITATS-->

<table class="tables-dash">
    <thead>
        <tr class="table-dash">
            <form id="habitatForm" method="post">
                <th><label for="habitat">Habitat :</label></th>
                <th><label for="comment">Commentaire :</label></th>
                <th><label for="valid"></label>Valider :</label></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> <select id="habitat" name="habitat_id" required>
                    <?php foreach ($habitats as $habitat) { ?>
                    <option value="<?php echo $habitat['id']; ?>"><?php echo $habitat['nom']; ?></option>
                    <?php } ?>
            </select><br></td>
            <td><textarea id="comment" name="commentaire" required></textarea></td>
            <td><input type="submit" value="Soumettre"></td>
            </form>
        </tr>
    </tbody>
</table>

</main>


    <footer>

    </footer>
    <!-- JAVASCRIPT  -->
    <script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>
