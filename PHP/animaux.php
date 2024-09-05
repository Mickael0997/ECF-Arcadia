<?php
// Connexion à la base de données
require 'database.php';

try {
    // Récupération des parcs
    $parcIds = [1, 2, 3, 4, 5, 6];
    $inQuery = implode(',', array_fill(0, count($parcIds), '?'));
    $sql = "SELECT * FROM parc_animaux WHERE id IN ($inQuery)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($parcIds);
    $parcs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mapping des données pour accès rapide
    $parcMap = [];
    foreach ($parcs as $parc) {
        $parcMap[$parc['id']] = $parc;
    }

    // Récupération des animaux
    $animalIds = [1, 15, 2, 4, 20, 11];
    $inQuery = implode(',', array_fill(0, count($animalIds), '?'));
    $sql = "SELECT * FROM animaux WHERE id IN ($inQuery)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($animalIds);
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mapping des données pour accès rapide
    $animalMap = [];
    foreach ($animaux as $animal) {
        $animalMap[$animal['id']] = $animal;
    }

    // Récupération des habitats
    $habitatIds = [1, 2, 3];
    $inQuery = implode(',', array_fill(0, count($habitatIds), '?'));
    $sql = "SELECT * FROM habitats WHERE id IN ($inQuery)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($habitatIds);
    $habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mapping des données pour accès rapide
    $habitatMap = [];
    foreach ($habitats as $habitat) {
        $habitatMap[$habitat['id']] = $habitat;
    }

    // Mapping des associations entre animaux, parcs et habitats
    $associations = [
        ['animal_id' => 1, 'parc_id' => 1, 'habitat_id' => 2],
        ['animal_id' => 15, 'parc_id' => 2, 'habitat_id' => 1],
        ['animal_id' => 2, 'parc_id' => 3, 'habitat_id' => 2],
        ['animal_id' => 4, 'parc_id' => 4, 'habitat_id' => 2],
        ['animal_id' => 20, 'parc_id' => 5, 'habitat_id' => 3],
        ['animal_id' => 11, 'parc_id' => 6, 'habitat_id' => 3]
    ];

    // Initialisation des variables
    $infos = [];

    foreach ($associations as $assoc) {
        $animal = $animalMap[$assoc['animal_id']];
        $parc = $parcMap[$assoc['parc_id']];
        $habitat = $habitatMap[$assoc['habitat_id']];

        // Mise à jour du compteur de vues
        // ... (reste du code)
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

        <?php foreach ($associations as $assoc) : ?>
            <?php
                $animal = $animalMap[$assoc['animal_id']];
                $parc = $parcMap[$assoc['parc_id']];
                $habitat = $habitatMap[$assoc['habitat_id']];
            ?>

            <div class="info">
                <a href="?view=<?php echo htmlspecialchars($animal['id']); ?>">
                    <img src="<?php echo htmlspecialchars($parc['images_animaux']); ?>" 
                    alt="<?php echo htmlspecialchars($animal['espece']); ?>">
                    <i class="bi bi-heart-fill heart-icon" data-id="<?php echo htmlspecialchars($animal['id']); ?>"></i>
                </a>
                <div class="informations">
                    <p class="title"><?php echo htmlspecialchars($animal['espece']); ?></p>
                    <p><strong>Surnom :</strong> <?php echo htmlspecialchars($animal['surnom']); ?></p>
                    <p><strong>Âge :</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
                    <p><strong>Description :</strong> <?php echo htmlspecialchars($parc['description']); ?></p>
                    <p><strong>Habitat :</strong> <?php echo htmlspecialchars($habitat['nom']); ?></p>
                    <p><strong>État :</strong> <?php echo htmlspecialchars($animal['etat']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</main>

<footer>
        <?php include'./footer.php';?>
</footer>
<script src="../JAVASCRIPT/scripts.js"></script>

</body>
</html>


