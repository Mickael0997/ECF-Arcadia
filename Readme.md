# ECF Projet Zoo Arcadia 2024/2025

Le Zoo D'Arcadia, est un site fictif en vue d'une évaluation pour le passage d'un examen afin d'acquérir une certification dans
le domaine de la création de site web et application mobile ( développeur angular).

# Installation 

Déploiement de l'application en local
Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

    XAMPP (inclut Apache, MySQL, PHP)
    Node.js (pour les paquets npm si nécessaire)
    phpMyAdmin pour gérer les bases de données SQL
    CouchDB ou MongoDB pour la base de données NoSQL
    Composer (pour la gestion des dépendances PHP)

Installation de XAMPP

    Téléchargez et installez XAMPP en suivant les instructions du site officiel.
    Lancez XAMPP Control Panel et démarrez les services Apache et MySQL.

Configuration de la base de données SQL
Avec phpMyAdmin

    Ouvrez votre navigateur et accédez à http://localhost/phpmyadmin.
    Créez une nouvelle base de données pour votre application.
    Importez les tables nécessaires via l'onglet "Importer" vous avez un fichier SQL disponible dans le dossier BDD.

Configuration de la base de données NoSQL
CouchDB

    Téléchargez et installez CouchDB.
    Ouvrez l'interface web de CouchDB via http://127.0.0.1:5984/_utils/.
    Créez une nouvelle base de données pour votre application.

MongoDB

    Téléchargez et installez MongoDB.
    Démarrez MongoDB en exécutant mongod.
    Utilisez un client MongoDB comme MongoDB Compass pour créer une nouvelle base de données.

Installation des dépendances PHP
Phponcouch pour CouchDB

    Assurez-vous d'avoir Composer installé.

    Naviguez dans le répertoire de votre projet.

    Exécutez la commande suivante pour installer phponcouch :

    composer require php-on-couch/php-on-couch

Exemple de configuration pour se connecter à CouchDB avec phponcouch :

require 'vendor/autoload.php';

use PHPOnCouch\CouchClient;
use PHPOnCouch\Exceptions;

$client = new CouchClient('http://localhost:5984', 'nom_de_votre_base_de_donnees'  array('username' => 'yourusername', 'password' => 'yourpassword'));

try {
    $doc = $client->getDoc('some_doc_id');
    print_r($doc);
} catch (Exceptions\CouchNotFoundException $e) {
    echo "Document non trouvé\n";
}

MongoDB pour PHP

    Assurez-vous d'avoir Composer installé.
    Naviguez dans le répertoire de votre projet.
    Exécutez la commande suivante pour installer le client MongoDB pour PHP :

composer require mongodb/mongodb
Exemple de configuration pour se connecter à MongoDB avec le client MongoDB pour PHP :

require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->nom_de_votre_base_de_donnees->nom_de_votre_collection;

$document = $collection->findOne(['some_field' => 'some_value']);
print_r($document);

Déploiement de l'application

    Placez votre application dans le répertoire htdocs de XAMPP, généralement situé à C:\xampp\htdocs\ sur Windows ou /Applications/XAMPP/htdocs/ sur macOS.
    Assurez-vous que votre fichier de configuration de base de données (par exemple config.php) contient les bonnes informations de connexion.

// Exemple de configuration pour MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nom_de_votre_base_de_donnees";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

Ouvrez votre navigateur et accédez à http://localhost/nom_de_votre_dossier pour voir votre application en action.
Technologies utilisées

    HTML : Pour la structure des pages web.
    CSS : Pour le style des pages web.
    Bootstrap : Pour un design réactif et des composants prêts à l'emploi.
    PHP : Pour le traitement côté serveur.
    JavaScript : Pour l'interactivité côté client.
    CouchDB ou MongoDB : Pour la base de données NoSQL.
    phpMyAdmin : Pour la gestion de la base de données SQL.

Support
Si vous rencontrez des problèmes ou avez des questions, n'hésitez pas à ouvrir une issue ou à me contacter par email.