<?php
// Connexion à la base de données
require 'database.php';

// Récupération des données du formulaire
$sql = "SELECT * FROM habitat WHERE id_habitat = ?";
$stmt = $conn->prepare($sql);
//jungle
$stmt->execute([1]);
$habitat1 = $stmt->fetch(PDO::FETCH_ASSOC);
//savane
$stmt->execute([2]);
$habitat2 = $stmt->fetch(PDO::FETCH_ASSOC);
//marais
$stmt->execute([3]);
$habitat3 = $stmt->fetch(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/dash_admin.css">
    <link rel="stylesheet" href="../CSS/historique.css">
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
    <h1>LEURS HABITATS</h1>
</div>

<divider class="divider"></divider>

<div> 
    <h2>Habitats</h2>
</div>    


<section class="habitats">
        
<div class="habitat">
    <div>   
        <img src="<?php echo htmlspecialchars($habitat1['image_habitat']); ?>" alt="Une Jungle">
    </div>
    <div>
        <h3><?php echo htmlspecialchars($habitat1['nom']); ?></h3>
    </div>
    <div>    
        <p class="descriptifs"><?php echo htmlspecialchars($habitat1['description']); ?></p>
    </div>
</div>

<div class="habitat">    
    <div>  
        <img src="<?php echo htmlspecialchars($habitat2['image_habitat']); ?>" alt="Une Savanne">
    </div>
    <div>
        <h3><?php echo htmlspecialchars($habitat2['nom']); ?></h3>
    </div>
    <div>   
        <p class="descriptifs"><?php echo htmlspecialchars($habitat2['description']); ?></p>
    </div>
</div>

<div class="habitat">
    <div>       
        <img src="<?php echo htmlspecialchars($habitat3['image_habitat']); ?>" alt="Un Marais">
    </div>
    <div>
        <h3><?php echo htmlspecialchars($habitat3['nom']); ?></h3>
    </div>
    <div>
        <p class="descriptifs"><?php echo htmlspecialchars($habitat3['description']); ?></p>
    </div> 
</div>

</section>
</main>

<footer>
        <?php include'./footer.php';?>
</footer>

<script src="../JAVASCRIPT/scripts.js"></script>
</body> 
</html>