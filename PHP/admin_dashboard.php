<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require 'database.php';

try {
    //Récupération de la table employées
    $sql = "SELECT * FROM employes";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Récupération de la table veterinaires
    $sql = "SELECT * FROM veterinaires";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $veterinaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération de la table animaux
    $sql = "SELECT * FROM animaux";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération de la table parc_animaux
    $sql = "SELECT * FROM parc_animaux";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $parc_animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupération de la table parc_activites
    $sql = "SELECT * FROM parc_activites";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $parc_activites = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administrateur</title>
    <link rel="stylesheet" href="../CSS/styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?> !</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="tritre">
            <h2>Gestion des Employées</h2>
        </div>
        <table class="admin_tableaux">
            <thead>
                <tr class="admin_tableau">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Portable</th>
                    <th>Fonction</th>
                    <th>E-mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employes as $employe): ?>
                    <tr class="admin_tableau">
                        <td><?php echo htmlspecialchars($employe['nom']); ?></td>
                        <td><?php echo htmlspecialchars($employe['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($employe['telephone_portable']); ?></td>
                        <td><?php echo htmlspecialchars($employe['fonction']); ?></td>
                        <td><?php echo htmlspecialchars($employe['email']); ?></td>
                        <td>
                        <a href="edit_employes.php?id=<?php echo $employe['id']; ?>">Modifier</a>
                        <a href="delete_employes.php?id=<?php echo $employe['id']; ?>">Supprimer</a>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_employes.php">Ajouter un employé</a>

        <table class="admin_tableaux">
            <thead>
                <tr class="admin_tableau">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>E-mail</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veterinaires as $veterinaire): ?>
                    <tr class="admin_tableau">
                        <td><?php echo htmlspecialchars($veterinaire['nom']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['telephone']); ?></td>
                        <td><?php echo htmlspecialchars($veterinaire['email']); ?></td>
                        <td>
                        <a href="edit_employes.php?id=<?php echo $veterinaire['id']; ?>">Modifier</a>
                        <a href="delete_employes.php?id=<?php echo $veterinaire['id']; ?>">Supprimer</a>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_veterinaires.php">Ajouter un vétérinaire</a>

        <div class="titre">
            <h2>Gestion des Animaux</h2>
        </div>
        <table class="admin_tableaux">
            <thead>
                <tr class="admin_tableau">
                    <th>Espèce</th>
                    <th>Surnom</th>
                    <th>Date de naissance</th>
                    <th>Âge</th>
                    <th>Taille</th>
                    <th>Poids</th>                    
                    <th>Sexe</th>
                    <th>Type Animal</th>
                    <th>Race</th>
                    <th>Nourriture</th>
                    <th>Habitat</th>
                    <th>Observations</th>
                    <th>Etat</th>
                    <th>Nourritures en grammes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animaux as $animal): ?>
                    <tr class="admin_tableau">
                        <td><?php echo htmlspecialchars($animal['espece']); ?></td>
                        <td><?php echo htmlspecialchars($animal['surnom']); ?></td>
                        <td><?php echo htmlspecialchars($animal['date_naissance']); ?></td>
                        <td><?php echo htmlspecialchars($animal['age']); ?></td>
                        <td><?php echo htmlspecialchars($animal['taille']); ?></td>
                        <td><?php echo htmlspecialchars($animal['poids']); ?></td>
                        <td><?php echo htmlspecialchars($animal['sexe']); ?></td>
                        <td><?php echo htmlspecialchars($animal['type_animal']); ?></td>
                        <td><?php echo htmlspecialchars($animal['race']); ?></td>
                        <td><?php echo htmlspecialchars($animal['nourriture_id']); ?></td>
                        <td><?php echo htmlspecialchars($animal['habitat_id']); ?></td>
                        <td><?php echo htmlspecialchars($animal['observations']); ?></td>
                        <td><?php echo htmlspecialchars($animal['etat']); ?></td>
                        <td><?php echo htmlspecialchars($animal['grammes_nourritures']); ?></td>
                        <td>
                            <a href="edit_animal.php?id=<?php echo $animal['id']; ?>">Modifier</a>
                            <a href="delete_animal.php?id=<?php echo $animal['id']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_animal.php">Ajouter un nouvel animal</a>

        <h2>Gestion des Activités</h2>
        <table class="admin_tableaux">
            <thead>
                <tr class="admin_table">
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parc_activites as $activite): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($activite['nom']); ?></td>
                        <td><?php echo htmlspecialchars($activite['description']); ?></td>
                        <td><?php echo htmlspecialchars($activite['activites_images']); ?></td>
                        <td>
                            <a href="edit_activity.php?id=<?php echo $activite['id']; ?>">Modifier</a>
                            <a href="delete_activity.php?id=<?php echo $activite['id']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="add_activity.php">Ajouter une nouvelle activité</a>
    </main>
</body>
</html>
