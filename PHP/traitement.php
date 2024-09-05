<?php
require 'auth.php';
require 'database.php';

// Fait appel à la table employes
$employe_id = $_SESSION['id'];
$sql = "SELECT * FROM employes WHERE id = ?";
$stmt_employe = $conn->prepare($sql);

// Fait appel à la tabe vétérinaires
$veterinaire_id = $_SESSION['id'];
$sql = "SELECT * FROM veterinaires WHERE id = ?";
$stmt_veterinaire = $conn->prepare($sql);

if (!$stmt_employe || !$stmt_veterinaire) {
    die($conn->errorInfo());
}

$stmt_employe->execute([$employe_id]);
$employe = $stmt_employe->fetch(PDO::FETCH_ASSOC);

$stmt_veterinaire->execute([$veterinaire_id]);
$veterinaire = $stmt_veterinaire->fetch(PDO::FETCH_ASSOC);

// Fait appel à la table animaux
$query = $conn->query('SELECT animaux.*, habitats.nom AS habitat_nom FROM animaux INNER JOIN habitats ON animaux.habitats_id = habitats.id');
$animaux = $query->fetchAll(PDO::FETCH_ASSOC);

// Fait appel à la table habitats
$query = $conn->query('SELECT * FROM habitats');
$habitats = $query->fetchAll(PDO::FETCH_ASSOC);

// Fait appel à la table nourriture
$query = $conn->prepare('SELECT * FROM nourriture');
$query->execute();
$nourriture = $query->fetchAll(PDO::FETCH_ASSOC);

//Fait appel à la table regime_alimentaire
$query = $conn->query('SELECT * FROM regime_alimentaires');
$regime_alimentaires = $query->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['animal_selected'])) {
    // Trouver l'animal sélectionné dans le tableau $animaux
    $selected_animal = array_filter($animaux, function($animal) {
        return $animal['id'] == $_POST['animal_selected'];
    });
    $selected_animal = reset($selected_animal); // Prendre le premier élément du tableau filtré

    // Trouver l'habitat de l'animal sélectionné
    if ($selected_animal) {
        $selected_habitat = array_filter($habitats, function($habitat) use ($selected_animal) {
            return $habitat['id'] == $selected_animal['habitats_id'];
        });
        $selected_habitat = reset($selected_habitat); // Prendre le premier élément du tableau filtré
    }
}
if (isset($_POST['update'])) {
    // Récupérer l'ID de l'animal et le nouvel état à partir de $_POST
    $animal_id = $_POST['animal_id'];
    $new_etat = $_POST['etat'];

    // Préparer la requête SQL pour mettre à jour l'état de l'animal
    $sql = "UPDATE animaux SET etat = :etat WHERE id = :id";

    // Préparer et exécuter la requête
    $stmt = $conn->prepare($sql);
    $stmt->execute(['etat' => $new_etat, 'id' => $animal_id]);

    // Recharger les données de l'animal pour afficher les modifications
    $selected_animal = $conn->query("SELECT * FROM animaux WHERE id = $animal_id")->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/historique.css">
    <link rel="stylesheet" href="../CSS/employes.css">
    <link rel="stylesheet" href="../CSS/veterinaires.css">
    <link rel="stylesheet" href="../CSS/ges_animaux.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<header>
    <a href="../PHP/dashboard.php" id="logo-link">
        <img src="../ASSETS/LogoArcadia2.png" alt="Logo du Zoo Écologique" id="logo">
    </a>
    <div class="admin-title">  
        <h1 class="titre">Bonjour <?php echo htmlspecialchars($employe['prenom']); ?> !</h1>
    </div> 
    <div class="admin-navbar">
        <ul class="links">
            <li><a href="./nourriture.php">Enregistrer la Nourriture</a></li>
        </ul>
        <div class="admin-buttons">
            <a href="./logout.php" class="action-button">Déconnexion</a>
        </div>
        <div class="burger-menu-button">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <div class="burger-menu">
        <ul class="links">
            <li><a href="./nourriture.php">Enregistrer la Nourriture</a></li>
            <div class="burger-divider"></div>
            <div class="admin-buttons">
                <a href="./logout.php" class="admin-action-button">Déconnexion</a>
            </div>
        </ul>
    </div>
</header>
<main>
    <form method="post">
        <select name="animal_selected">
            <option value="">Sélectionner</option>
            <?php foreach ($animaux as $animal): ?>
                <option value="<?php echo $animal['id']; ?>" <?php echo isset($selected_animal) && $animal['id'] == $selected_animal['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($animal['surnom']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="info" value="Afficher les informations">
        <button class="gest-animaux-button" href="add_animal.php">Ajouter un nouvel animal</button>
    </form>

        <?php if (isset($selected_animal)): ?>
    <section class="gest-animaux">   
        <form method="post" class="gest-animaux-form">            
            <label for="surnom">Surnom:</label><br>
            <input type="text" id="surnom" name="surnom" value="<?php echo htmlspecialchars($selected_animal['surnom']); ?>" ><br>
            
            <label for="espece">Espèce:</label><br>
            <input type="text" id="espece" name="espece" value="<?php echo htmlspecialchars($selected_animal['espece']); ?>" ><br>

            <label for="date_naissance">Date de naissance:</label><br>
            <input type="date" name="date_naissance" value="<?php echo htmlspecialchars($selected_animal['date_naissance']); ?>" ><br>

            <label for="age">Age:</label><br>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($selected_animal['age']); ?>" ><br>

            <label for="taille">Taille:</label><br>
            <input type="number" id="taille" name="taille" value="<?php echo htmlspecialchars($selected_animal['taille']); ?>" ><br>

            <label for="poids">Poids:</label><br>
            <input type="number" id="poids" name="poids" value="<?php echo htmlspecialchars($selected_animal['poids']); ?>" ><br>

            <label for="sexe">Sexe:</label><br>
            <input type="text" id="sexe" name="sexe" value="<?php echo htmlspecialchars($selected_animal['sexe']); ?>" ><br>

            <label for="etat">Etat:</label><br>
            <input type="text" id="etat" name="etat" value="<?php echo htmlspecialchars($selected_animal['etat']); ?>"><br>

            <label for="habitats_id">Habitat:</label><br>
            <input type="text" id="habitats_id" name="habitats_id" value="<?php echo htmlspecialchars($selected_habitat['nom']); ?>" ><br>

            <label for="id_RegimeAlimentaires">Types:</label><br>
            <input type="text" id="id_RegimeAlimentaires" name="id_RegimeAlimentaires" value="<?php echo htmlspecialchars($selected_animal['id_RegimeAlimentaires']); ?>" ><br>

            <label for="nourriture">Aliments</label><br>
<select id="nourriture" name="nourriture">
    <?php foreach ($nourriture as $Nourritures): ?>
        <option value="<?php echo htmlspecialchars($Nourritures['id']); ?>" <?php echo $selected_nourriture && $Nourritures['Nourritures'] == $selected_nourriture['Nourritures'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($Nourritures['Nourritures']); ?>
        </option>
    <?php endforeach; ?>
</select><br>

            <input type="hidden" name="animal_id" value="<?php echo $selected_animal['id']; ?>"><br>
            <input type="submit" name="update" value="Mettre à jour">
            <input type="submit" name="delete" value="Supprimer">
        </form>
    </section>
    <?php endif; ?>
</main>
<script src="../JAVASCRIPT/scripts.js"></script>   
</body>
</html>
