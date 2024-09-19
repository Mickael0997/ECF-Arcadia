<?php
require 'database.php';

// Fonction pour hacher les mots de passe d'une table donnée
function hashPasswords($table, $id_column) {
    global $conn;

    // Sélectionnez tous les enregistrements de la table
    $sql = "SELECT $id_column, mot_de_passe FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        // Vérifiez si le mot de passe est déjà haché
        if (strpos($user['mot_de_passe'], '$2y$') === 0) {
        // Si déjà haché, on passe au suivant
        continue;
        $hashed_password = password_hash($user['mot_de_passe'], PASSWORD_DEFAULT);

        // Mettez à jour le mot de passe haché dans la base de données
        $update_sql = "UPDATE $table SET mot_de_passe = ? WHERE $id_column = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->execute([$hashed_password, $user[$id_column]]);
        }
    }
}

// Hachez les mots de passe pour les administrateurs
hashPasswords('administrateur', 'id_admin');

// Hachez les mots de passe pour les employés
hashPasswords('employe', 'id_employe');

echo "Les mots de passe ont été hachés avec succès.";
?>

<!-- Exécutez ce script une seule fois en accédant à l'URL correspondante via votre navigateur, 
par exemple http://localhost/votre_projet/hash_passwords.php. --->

