
<!-- Creation d'un administrateur via http://localhost/ECF-Arcadia/PHP/create_admin.php-->
<?php
require '../PHP/database.php';

// Détails de l'administrateur
$nom = 'Garcia';
$prenom = 'José';
$fonction = 'Directeur';
$email = 'jose.garcia@arcadia.com';
$password = password_hash('jose', PASSWORD_DEFAULT); // Hash du mot de passe

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO administrateurs (nom, prenom, fonction, email, password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $nom, PDO::PARAM_STR);
$stmt->bindValue(2, $prenom, PDO::PARAM_STR);
$stmt->bindValue(3, $fonction, PDO::PARAM_STR);
$stmt->bindValue(4, $email, PDO::PARAM_STR);
$stmt->bindValue(5, $password, PDO::PARAM_STR);
$stmt->execute();

// Vérifier si l'insertion a réussi
if ($stmt === false) {
    die($conn->errorInfo()[2]);
}

echo "Administrateur créé avec succès.";
?>