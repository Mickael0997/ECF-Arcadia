<?php
session_start();
if (!isset($_SESSION['employe_id']) && !isset($_SESSION['veterinaire_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $espece = $_POST['espece'];
    $surnom = $_POST['surnom'];
    $type_alimentation = $_POST['type_alimentation'];
    $grammes = $_POST['grammes'];
    $commentaire = $_POST['commentaire'];

    $sql = "INSERT INTO nourriture (date, heure, espece, surnom, type_alimentation, grammes, commentaire) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$date, $heure, $espece, $surnom, $type_alimentation, $grammes, $commentaire]);

    header('Location: nourriture.php');
    exit;
}

// Récupérer les espèces et les surnoms d'animaux pour les sélectionner dans le formulaire
$sql_animaux = "SELECT id, espece, surnom FROM animaux";
$stmt_animaux = $conn->query($sql_animaux);
$animaux = $stmt_animaux->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer la Nourriture</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <header>
        <h1>Enregistrer la Nourriture</h1>
    </header>
    <main>
        <form method="post" action="nourriture.php">
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" required><br>
            
            <label for="heure">Heure :</label>
            <input type="time" id="heure" name="heure" required><br>
            
            <label for="espece">Espèce :</label>
            <select id="espece" name="espece" required>
                <?php foreach ($animaux as $animal) { ?>
                    <option value="<?php echo htmlspecialchars($animal['espece']); ?>">
                        <?php echo htmlspecialchars($animal['espece']); ?>
                    </option>
                <?php } ?>
            </select><br>
            
            <label for="surnom">Surnom :</label>
            <select id="surnom" name="surnom" required>
                <?php foreach ($animaux as $animal) { ?>
                    <option value="<?php echo htmlspecialchars($animal['surnom']); ?>">
                        <?php echo htmlspecialchars($animal['surnom']); ?>
                    </option>
                <?php } ?>
            </select><br>
            
            <label for="type_alimentation">Type d'alimentation :</label>
            <select id="type_alimentation" name="type_alimentation" required>
                <option value="Viandes">Viandes</option>
                <option value="Fruits/légumes">Fruits/légumes</option>
                <option value="Tous">Tous</option>
            </select><br>
            
            <label for="grammes">Grammes :</label>
            <input type="number" id="grammes" name="grammes" required><br>
            
            <label for="commentaire">Commentaire :</label>
            <textarea id="commentaire" name="commentaire"></textarea><br>
            
            <input type="submit" value="Soumettre">
        </form>
    </main>
</body>
</html>
