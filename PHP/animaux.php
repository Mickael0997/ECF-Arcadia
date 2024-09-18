<?php
// Connexion à la base de données
require 'database.php';

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=localhost;dbname=ecf", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fonction générique pour récupérer et mapper les données
    function fetchDataAndMap($conn, $table, $idColumn, $ids) {
        $inQuery = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM $table WHERE $idColumn IN ($inQuery)";
        $stmt = $conn->prepare($sql);
        $stmt->execute($ids);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dataMap = [];
        foreach ($data as $row) {
            $dataMap[$row[$idColumn]] = $row;
        }
        return $dataMap;
    }

    // Récupération et mapping des animaux
    $animalIds = [1, 2, 3, 4, 5, 6];
    $animalMap = fetchDataAndMap($conn, 'animal', 'id_animal', $animalIds);

    // Récupération et mapping des habitats
    $habitatIds = [1, 2, 3];
    $habitatMap = fetchDataAndMap($conn, 'habitat', 'id_habitat', $habitatIds);

    // Récupération et mapping des parcs
    $parcIds = [1, 2, 3, 4, 5, 6];
    $parcMap = fetchDataAndMap($conn, 'parc', 'id_parc', $parcIds);

    // Récupération des "view" pour les animaux
    $sql = "SELECT id_animal, COUNT(*) as nombre_view FROM `view` GROUP BY id_animal";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $view = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mapping des vues pour accès rapide
    $viewMap = [];
    foreach ($view as $view) {
        $viewMap[$view['id_animal']] = $view['nombre_view'];
    }

    // Initialisation des variables pour affichage
    $infos = [
        ['id_animal' => 1, 'id_parc' => 1, 'id_habitat' => 2],
        ['id_animal' => 2, 'id_parc' => 2, 'id_habitat' => 2],
        ['id_animal' => 3, 'id_parc' => 3, 'id_habitat' => 1],
        ['id_animal' => 4, 'id_parc' => 4, 'id_habitat' => 2],
        ['id_animal' => 5, 'id_parc' => 5, 'id_habitat' => 3],
        ['id_animal' => 6, 'id_parc' => 6, 'id_habitat' => 1],
    ];

    // Mise à jour des vues dans la table "view"
    foreach ($infos as $info) {
        $sql = "INSERT INTO `view` (id_animal, nombre_view) VALUES (:id_animal, 1)
                ON DUPLICATE KEY UPDATE nombre_view = nombre_view + 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id_animal' => $info['id_animal']]);
    }


} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header>           
        <?php include './header.php'; ?>  
        <?php include './avis.php';?>
    </header>
<main>
    <div>
        <h1>Les Animaux</h1>
    </div>

        <divider class="divider"></divider>

<div class="infos">
    <?php foreach ($infos as $assoc) : ?>
        <?php
            $animal = $animalMap[$assoc['id_animal']];
            $parc = $parcMap[$assoc['id_parc']];
            $habitat = $habitatMap[$assoc['id_habitat']];
        ?>

        <div class="info">
        <a href="?view=<?php echo htmlspecialchars($animal['id_animal']); ?>">
    <img src="<?php echo htmlspecialchars($parc['image_animal']); ?>" 
        alt="<?php echo htmlspecialchars($animal['espece']); ?>">
    <i class="bi bi-heart-fill heart-icon" data-id="<?php echo htmlspecialchars($animal['id_animal']); ?>"></i>
</a>

            <div class="informations">
                <p class="title"><?php echo htmlspecialchars($animal['espece']); ?></p>
                <p><strong>Surnom :</strong> <?php echo htmlspecialchars($animal['surnom']); ?></p>
                <p><strong>Âge :</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
                <p><strong>Description :</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
                <p><strong>Habitat :</strong> <?php echo htmlspecialchars($habitat['nom']); ?></p>
                <p><strong>État :</strong> <?php echo htmlspecialchars($animal['etat_sante']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</main>

<footer>
    <?php include './footer.php'; ?>
</footer>

<script src="../JAVASCRIPT/scripts.js"></script>
</body>
</html>