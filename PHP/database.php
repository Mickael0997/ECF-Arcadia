<?php

// Création d'une connexion

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "arcadia";

// Tentative pour établir une connexion


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// Si connexion échoué, un message s'affiche
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();

}
?>

