<?php
// Connexion à la base de données
require 'database.php';

// Récupération des données des animaux et des parcs
try {
    // Récupération des parcs
    $parcIds = [1, 2, 3, 4, 5, 6];
    $inQuery = implode(',', array_fill(0, count($parcIds), '?'));
    $sql = "SELECT * FROM parc_animaux WHERE id IN ($inQuery)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($parcIds);
    $parcs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des animaux
    $animalIds = [1, 15, 2, 4, 20, 11];
    $inQuery = implode(',', array_fill(0, count($animalIds), '?'));
    $sql = "SELECT * FROM animaux WHERE id IN ($inQuery)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($animalIds);
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des habitats
    $habitatIds = [1, 2, 3];
    $inQuery = implode(',', array_fill(0, count($habitatIds), '?'));
    $sql = "SELECT * FROM habitats WHERE id IN ($inQuery)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($habitatIds);
    $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mapping des données pour accès rapide
    $parcMap = [];
    foreach ($parcs as $parc) {
        $parcMap[$parc['id']] = $parc;
    }

    $animalMap = [];
    foreach ($animaux as $animal) {
        $animalMap[$animal['id']] = $animal;
    }

    $habitatMap = [];
    foreach ($habitats as $habitat) {
        $habitatMap[$habitat['id']] = $habitat;
    }
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/styles.css">
    <title>Le Zoo D'Arcadia/Animaux</title>
</head>
<body>

<?php include './header.php'; ?>
<?php include './avis.php'; ?>

<main>
    <div>
        <h1>Les Animaux</h1>
    </div>

    <divider class="divider"></divider>

    <div class="infos">
        <?php        
        // Mapping des associations entre animaux, parcs et habitats
        $associations = [
            ['animal_id' => 1, 'parc_id' => 1, 'habitat_id' => 2],
            ['animal_id' => 15, 'parc_id' => 2, 'habitat_id' => 1],
            ['animal_id' => 2, 'parc_id' => 3, 'habitat_id' => 2],
            ['animal_id' => 4, 'parc_id' => 4, 'habitat_id' => 2],
            ['animal_id' => 20, 'parc_id' => 5, 'habitat_id' => 3],
            ['animal_id' => 11, 'parc_id' => 6, 'habitat_id' => 3]
        ];

        foreach ($associations as $assoc) {
            $animal = $animalMap[$assoc['animal_id']];
            $parc = $parcMap[$assoc['parc_id']];
            $habitat = $habitatMap[$assoc['habitat_id']];

            // Mise à jour du compteur de vues
            if (isset($_GET['view']) && $_GET['view'] == $animal['id']) {
                $sql = "INSERT INTO record_view (image_id, views) VALUES (?, 1)
                        ON DUPLICATE KEY UPDATE views = views + 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$animal['id']]);
                
                // Récupération des vues mises à jour
                $sql = "SELECT views FROM record_view WHERE image_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$animal['id']]);
                $views = $stmt->fetchColumn();
            } else {
                // Récupération des vues initiales
                $sql = "SELECT views FROM record_view WHERE image_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$animal['id']]);
                $views = $stmt->fetchColumn();
                if ($views === false) {
                    $views = 0; // Si aucune vue n'a encore été enregistrée
                }
            }
        ?>
        <div class="info">
            <a href="?view=<?php echo htmlspecialchars($animal['id']); ?>">
                <img src="<?php echo htmlspecialchars($parc['images_animaux']); ?>" 
                alt="<?php echo htmlspecialchars($animal['espece']); ?>">
            </a>
            <div class="informations">
                <p class="title"><?php echo htmlspecialchars($animal['espece']); ?></p>
                <p><strong>Surnom :</strong> <?php echo htmlspecialchars($animal['surnom']); ?></p>
                <p><strong>Âge :</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
                <p><strong>Description :</strong> <?php echo htmlspecialchars($parc['description']); ?></p>
                <p><strong>Habitat :</strong> <?php echo htmlspecialchars($habitat['habitats']); ?></p>
                <p><strong>État :</strong> <?php echo htmlspecialchars($animal['etat']); ?></p>
                <p><strong>Vues :</strong> <?php echo htmlspecialchars($views); ?></p>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</main>

<script src="../JAVASCRIPT/scripts.js"></script>
<?php include './footer.php'; ?>

</body>
</html>


