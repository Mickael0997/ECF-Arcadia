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
    $animalIds = [1, 2, 3, 4, 6];
    $animalMap = fetchDataAndMap($conn, 'animal', 'id_animal', $animalIds);

    // Récupération et mapping des habitats
    $habitatIds = [1, 2, 3];
    $habitatMap = fetchDataAndMap($conn, 'habitat', 'id_habitat', $habitatIds);

    // Récupération et mapping des parcs
    $parcIds = [1, 2, 3, 4, 6];
    $parcMap = fetchDataAndMap($conn, 'parc', 'id_parc', $parcIds);

    // Récupération des "view" pour les animaux
    $sql = "SELECT id_animal, nombre_view FROM `view`";
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
        ['id_animal' => 6, 'id_parc' => 6, 'id_habitat' => 1],
    ];

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
    <link rel="stylesheet" href="../CSS/animaux.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Les Mammifères</title>
</head>
<body>
    <header>           
        <?php include './header.php'; ?>  
    </header>
<main>
    <div>
        <h1>Les Mammifères</h1>
    </div>

    <div class="background-gradient"></div>

    <div class="infos">
        <?php foreach ($infos as $index => $assoc) : ?>
            <?php
                $animal = $animalMap[$assoc['id_animal']];
                $parc = $parcMap[$assoc['id_parc']];
                $habitat = $habitatMap[$assoc['id_habitat']];
                $class = $index % 2 == 0 ? 'info-left' : 'info-right';
            ?>

            <div class="info <?php echo $class; ?>">
                <img src="<?php echo htmlspecialchars($parc['image_animal']); ?>" 
                    alt="<?php echo htmlspecialchars($animal['espece']); ?>">
                <div class="informations">
                    <p class="title"><?php echo htmlspecialchars($animal['espece']); ?></p>
                    <p><strong>Surnom :</strong> <?php echo htmlspecialchars($animal['surnom']); ?></p>
                    <p><strong>Âge :</strong> <?php echo htmlspecialchars($animal['age']); ?></p>
                    <p><strong>Description :</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
                    <p><strong>Habitat :</strong> <?php echo htmlspecialchars($habitat['nom']); ?></p>
                    <p><strong>État :</strong> <?php echo htmlspecialchars($animal['etat_sante']); ?></p>
                </div>
                <i class="bi bi-heart-fill heart-icon" data-id="<?php echo htmlspecialchars($animal['id_animal']); ?>"></i>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <?php include './footer.php'; ?>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gérer le retournement des cartes
    const infos = document.querySelectorAll('.info');
    infos.forEach(info => {
        info.addEventListener('click', function() {
            this.classList.toggle('flipped');
        });
    });

    // Gestion des clics sur les icônes de cœur
    const hearts = document.querySelectorAll('.heart-icon');

    hearts.forEach((heart) => {
        heart.style.color = 'grey'; // Initialisation de la couleur du cœur

        // Gestionnaire d'événement au clic sur l'icône de cœur
        heart.addEventListener('click', function(event) {
            event.stopPropagation(); // Empêche le retournement de la carte lors du clic sur l'icône
            const idAnimal = this.dataset.id; // Récupère l'ID de l'animal cliqué
            updateLike(idAnimal, this); // Appelle la fonction pour mettre à jour le like

            // Ajout ou retrait de la classe 'liked' pour styliser l'icône
            this.classList.toggle('liked');
            
            // Change la couleur selon si la classe 'liked' est présente
            this.style.color = this.classList.contains('liked') ? 'red' : 'grey';
        });
    });

    // Fonction pour mettre à jour les likes
    function updateLike(idAnimal, heartIcon) {
        fetch('update_like.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_animal: idAnimal })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Like mis à jour avec succès.');
                heartIcon.style.color = 'red'; // Maintient la couleur rouge après le clic
            } else {
                console.error('Erreur lors de la mise à jour du like:', data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
});
</script>
</body>
</html>