<?php
// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=ecf;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupérer les données du formulaire
$pseudo = $_POST['pseudo'];
$message = $_POST['message'];
$rating = $_POST['rating'];

// Gérer l'upload de la photo
$photo = $_FILES['photo'];
$photoPath = '../uploads/' . basename($photo['name']);
move_uploaded_file($photo['tmp_name'], $photoPath);

// Insérer les données dans la base de données
$sql = 'INSERT INTO avis (photo, pseudo, message, rating) VALUES (:photo, :pseudo, :message, :rating)';
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'photo' => $photoPath,
    'pseudo' => $pseudo,
    'message' => $message,
    'rating' => $rating
]);

// Rediriger vers une page de confirmation ou afficher un message de succès
header('Location: ../PHP/confirmation.php');
exit;
?>