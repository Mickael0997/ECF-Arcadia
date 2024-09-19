<?php

// Création d'une connexion

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecf";
$charset = "utf8";

// Tentative pour établir une connexion

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=$charset";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// Si connexion échoue, un message s'affiche
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

