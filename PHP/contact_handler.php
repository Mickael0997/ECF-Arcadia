<?php
// Connexion à la base de données
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['adresse_mail']);
    $message = htmlspecialchars($_POST['message']);
    $rating = intval($_POST['rating']);  // Note sélectionnée
    $date = date('Y-m-d H:i:s');  // Date actuelle

    try {
        // Connexion à la base de données
        $conn = new PDO("mysql:host=localhost;dbname=ecf", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insérer les données dans la table 'question' avec la note
        $sql = "INSERT INTO question (pseudo, adresse_mail, date_commentaire, statut, message, rating) 
                VALUES (:pseudo, :email, :date_commentaire, 'en_attente', :message, :rating)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':date_commentaire', $date);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':rating', $rating);

        $stmt->execute();

        // Redirection après l'enregistrement avec un message de succès
        header('Location: ../HTML/contact.htm?success=true');
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>