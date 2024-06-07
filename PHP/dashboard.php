<?php
require 'auth.php';
require 'database.php';

$employe_id = $_SESSION['id'];
$sql = "SELECT * FROM employes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $employe_id);
$stmt->execute();
$result = $stmt->get_result();
$employe = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="/CSS/styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($employe['prenom']); ?> !</h1>
        <nav>
            <ul>
                <li><a href="./logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Journal de bord</h2>
        <!-- Formulaire pour le journal de bord -->
        <form action="submit_log.php" method="post">
            <label for="date">Date :</label>
            <input type="text" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" readonly>
            <label for="employe">Employé :</label>
            <input type="text" id="employe" name="employe" value="<?php echo htmlspecialchars($employe['prenom'] . ' ' . $employe['nom']); ?>" readonly>
            <label for="fonction">Fonction :</label>
            <input type="text" id="fonction" name="fonction" value="<?php echo htmlspecialchars($employe['fonction']); ?>" readonly>
            <label for="commentaire">Commentaire :</label>
            <textarea id="commentaire" name="commentaire" required></textarea>
            <button type="submit">Soumettre</button>
        </form>
    </main>
</body>
</html>
