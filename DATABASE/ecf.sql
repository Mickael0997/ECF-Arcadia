-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 20 sep. 2024 à 12:01
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecf`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

CREATE TABLE `activite` (
  `id_activite` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_activite` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `activite`
--

INSERT INTO `activite` (`id_activite`, `nom`, `description`, `image_activite`) VALUES
(1, 'Visite guidée en petit train', 'Embarquez pour un tour en petit train à travers le zoo, idéal pour découvrir le parc tout en profitant d\'une vue panoramique. Le trajet permet de passer par les différents enclos des animaux tout en écoutant des informations sur les espèces que vous apercevez. Un moment de détente parfait pour petits et grands.', '../ASSETS/petittrainvisiteguide.jpg'),
(2, 'Restauration', 'Après avoir exploré le zoo, profitez des différentes zones de restauration. Que vous souhaitiez un repas rapide ou un déjeuner en famille, vous trouverez des collations, des plats chauds, et des options végétariennes, le tout dans des espaces de pique-nique agréables avec vue sur la nature environnante.', '../ASSETS/point-restauration.jpg'),
(3, 'La Ferme', 'Visitez la ferme du zoo où vous pouvez approcher, nourrir et caresser des animaux domestiques comme les chèvres, les moutons et les lapins. C\'est une activité interactive et ludique pour les enfants, leur permettant d\'apprendre sur les animaux de la ferme tout en s\'amusant. Les soigneurs sont présents pour répondre aux questions et encadrer les interactions.', '../ASSETS/ferme.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id_admin` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse_mail` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_admin`, `nom`, `prenom`, `adresse_mail`, `mot_de_passe`) VALUES
(1, 'Garcia', 'José', 'jose.garcia@example.com', '12345');

-- --------------------------------------------------------

--
-- Structure de la table `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `surnom` varchar(50) DEFAULT NULL,
  `espece` varchar(50) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `etat_sante` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `id_habitat` int(11) DEFAULT NULL,
  `sexe` enum('M','F') DEFAULT NULL,
  `race` varchar(50) DEFAULT NULL,
  `poids` decimal(5,2) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `type_alimentation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `animal`
--

INSERT INTO `animal` (`id_animal`, `surnom`, `espece`, `age`, `etat_sante`, `description`, `id_habitat`, `sexe`, `race`, `poids`, `date_naissance`, `type_alimentation`) VALUES
(1, 'Leo', 'Lion', 1, 'Bon', 'Un jeune lion curieux et doux.', 2, 'M', 'Panthera leo', 20.50, '2023-08-01', 'carnivore'),
(2, 'Mel', 'Girafe', 5, 'Excellent', 'Une girafe intelligente et joueuse.', 2, 'F', 'Giraffa camelopardalis', 800.00, '2018-05-10', 'herbivore'),
(3, 'Tiger', 'Tigre', 3, 'Bon', 'Un tigre heureux qui aime les caresses.', 1, 'M', 'Panthera tigris', 220.00, '2021-02-20', 'carnivore'),
(4, 'Dumbo', 'Éléphant', 8, 'Excellent', 'Dumbo le magnifique avec de grandes oreilles.', 2, 'M', 'Loxodonta africana', 999.99, '2016-09-15', 'herbivore'),
(5, 'Croco', 'Crocodile', 12, 'Bon', 'Croco l\'albinos, difficile de l oublier.', 3, 'M', 'Crocodylus niloticus', 400.00, '2012-04-05', 'carnivore'),
(6, 'Pong', 'Panda', 4, 'Bon', 'Un panda adorable qui aime les bambous.', 1, 'F', 'Ailuropoda melanoleuca', 100.00, '2020-07-21', 'herbivore'),
(7, 'Vin', 'Koala', 2, 'Excellent', 'Un koala mignon qui dort beaucoup.', 1, 'F', 'Phascolarctos cinereus', 8.00, '2022-01-15', 'herbivore'),
(8, 'Zebra', 'Zèbre', 6, 'Bon', 'Un zèbre avec des rayures distinctives.', 2, 'M', 'Equus zebra', 350.00, '2017-10-30', 'herbivore'),
(9, 'Pelican', 'Pélican', 7, 'Bon', 'Un pélican avec un grand bec et des ailes puissantes.', 3, 'F', 'Pelecanus onocrotalus', 15.00, '2016-12-25', 'omnivore'),
(10, 'Eagle', 'Aigle', 9, 'Bon', 'Un aigle majestueux avec une vue perçante.', 1, 'M', 'Aquila nipalensis', 6.00, '2014-11-10', 'carnivore'),
(21, 'Nala', 'Lionne', 2, 'Bon', 'Une jeune lionne curieuse.', 2, 'F', 'Panthera leo', 18.00, '2021-07-15', 'carnivore'),
(22, 'Bambi', 'Cerf', 3, 'Excellent', 'Un cerf gracieux et rapide.', 3, 'M', 'Cervus elaphus', 150.00, '2020-05-20', 'herbivore');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id_employe` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `fonction` varchar(50) NOT NULL,
  `adresse_mail` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id_employe`, `nom`, `prenom`, `fonction`, `adresse_mail`, `mot_de_passe`, `telephone`) VALUES
(1, 'Dupont', 'Jean', 'Responsable', 'jean.dupont@example.com', '12345', '0612345678'),
(2, 'Durand', 'Marie', 'Guide', 'marie.durand@example.com', '$2y$10$Yu2nTNoXjv/k5E8rDXCwIuzAapZyAZnwJeo5nnlDBrOoyZ9JGu33y', '0623456789'),
(3, 'Martin', 'Sophie', 'Caissière', 'sophie.martin@example.com', '$2y$10$Bk8dodDHM2klafywpAtYOu1QkcDg4lyaPKm9ZJ.zO.Sx0TmAXUXKq', '0634567890'),
(4, 'Bernard', 'Paul', 'Vétérinaire', 'paul.bernard@example.com', '$2y$10$1H.x4J4XIVvYw7cLGokgo.dGmjTC95R/Y6x2P4Y3A5rNkThVcT.PK', '0645678901'),
(5, 'Petit', 'Julie', 'Animateur', 'julie.petit@example.com', '$2y$10$AxXsNiHk48J6h2eQMXrA3.F.rCk2Y0FsHkoymivstBYMSPD3VVDES', '0656789012'),
(6, 'Robert', 'Luc', 'Sécurité', 'luc.robert@example.com', '$2y$10$IZ69WZMv61v1xQalZKRPbusPjBjxXu/RmZD2WWLVPNd9Wz4THci6u', '0667890123'),
(7, 'Richard', 'Emma', 'Restauration', 'emma.richard@example.com', '$2y$10$XS3DmnEH/v26pzAwXDW1lesp686E3xmeJ8bpKnly74hcHjhVO2Gzm', '0678901234'),
(8, 'Garcia', 'Pierre', 'Technicien', 'pierre.garcia@example.com', '$2y$10$I8ZckuvZwSYM1CavtUiOPeh1KowMHUG3vxYQiVn4WJUFrMv.mjsyy', '0689012345'),
(9, 'Martinez', 'Laura', 'Agent de nettoyage', 'laura.martinez@example.com', '$2y$10$SlPZJoFjuMUMOyb4p/pQ1e89vni9xxukITAj/2wuPTp1.p1wMJMnq', '0690123456'),
(10, 'Lefevre', 'Thomas', 'Jardinier', 'thomas.lefevre@example.com', '$2y$10$FuZvCUWi/2CZznML8w7HXOdpFAN/W9jvv1v.ZFkdLIy9UlLsEsLau', '0601234567'),
(11, 'Lopez', 'Isabelle', 'Chargée de communication', 'isabelle.lopez@example.com', '$2y$10$b2Kz84bpOtNqZ6VaGuTD8OY3gAm4koETkeA1J58R8WzPTQW4czF0C', '0612345679'),
(12, 'Gonzalez', 'Nicolas', 'Technicien animalier', 'nicolas.gonzalez@example.com', '$2y$10$UbXVCzmubYk7nAY0SH41zen2wdqyt7xqj8BEF5CPD1T31/XdceWVy', '0623456780'),
(13, 'Moulin', 'Alice', 'Vendeur souvenirs', 'alice.moulin@example.com', '$2y$10$cTyRu0IHQY8LdQUbdMpoveuN0X9CvqjAD9AcF.fGM9DdwYkndcFa.', '0634567891'),
(14, 'Moreau', 'Antoine', 'Guide junior', 'antoine.moreau@example.com', '$2y$10$n9ver1U/jhLed.PxPFea7eKPue7ESqfkVbSxsxWvq8RiodvOtfBO.', '0645678902'),
(15, 'Rousseau', 'Claire', 'Gestionnaire de stock', 'claire.rousseau@example.com', '$2y$10$8DsWDpGlKO3nW3OvZ18mQ.fLBVxMKQONxBzbvAdf4G6W2FrdqPaKi', '0656789013');

-- --------------------------------------------------------

--
-- Structure de la table `habitat`
--

CREATE TABLE `habitat` (
  `id_habitat` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_habitat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `habitat`
--

INSERT INTO `habitat` (`id_habitat`, `nom`, `description`, `image_habitat`) VALUES
(1, 'Jungle', 'Cet habitat reproduit une forêt tropicale dense, avec une végétation luxuriante, des arbres imposants, et un climat humide. Les animaux comme les singes, les oiseaux tropicaux et les jaguars y évoluent, se cachant parmi les lianes et les feuillages épais. Un bassin d\'eau et une cascade ajoutent à l\'ambiance naturelle.', '../ASSETS/jungle.jpg'),
(2, 'Savane', ' Cet espace recrée les vastes plaines africaines avec des herbes hautes, des acacias et un terrain dégagé. Les animaux emblématiques comme les lions, les éléphants et les girafes peuvent se déplacer librement, imitant leur comportement naturel dans un environnement ensoleillé et aride.', '../ASSETS/savane.webp'),
(3, 'Marais', ' Avec ses zones humides et sa végétation aquatique, cet habitat marécageux abrite des crocodiles, des tortues et des oiseaux migrateurs. Des étangs stagnants, des roseaux et des plantes flottantes ajoutent une atmosphère mystérieuse et humide, propice à ces espèces.', '../ASSETS/Marais.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `nourriture`
--

CREATE TABLE `nourriture` (
  `id_nourriture` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `quantite` varchar(50) DEFAULT NULL,
  `heure_alimentation` time DEFAULT NULL,
  `id_animal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `nourriture`
--

INSERT INTO `nourriture` (`id_nourriture`, `type`, `quantite`, `heure_alimentation`, `id_animal`) VALUES
(8, '                  Boeuf                           ', '4kg', '12:30:00', 1),
(9, '                Boeufs                            ', '4KG', '13:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `observation_animal`
--

CREATE TABLE `observation_animal` (
  `id_observation_animal` int(11) NOT NULL,
  `observation` text DEFAULT NULL,
  `date_observation` datetime DEFAULT NULL,
  `id_animal` int(11) DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `observation_animal`
--

INSERT INTO `observation_animal` (`id_observation_animal`, `observation`, `date_observation`, `id_animal`, `id_utilisateur`) VALUES
(4, 'Léo c\'est bien intégré', '2024-09-16 13:00:00', 1, 1),
(5, 'Léo c\'est bien intégré', '2024-09-16 13:00:00', 1, 1),
(6, 'se porte très bien', '2024-09-16 13:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `observation_habitat`
--

CREATE TABLE `observation_habitat` (
  `id_observation_habitat` int(11) NOT NULL,
  `observation` text DEFAULT NULL,
  `date_observation` datetime DEFAULT NULL,
  `id_habitat` int(11) DEFAULT NULL,
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parc`
--

CREATE TABLE `parc` (
  `id_parc` int(11) NOT NULL,
  `id_animal` int(11) NOT NULL,
  `image_animal` varchar(255) NOT NULL,
  `id_view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `parc`
--

INSERT INTO `parc` (`id_parc`, `id_animal`, `image_animal`, `id_view`) VALUES
(1, 1, '../ASSETS/lion.jpg', 4),
(2, 2, '../ASSETS/girafe.jpg', 4),
(3, 3, '../ASSETS/tiger-500118_1280.jpg', 4),
(4, 4, '../ASSETS/dumboelephant.webp', 4),
(5, 5, '../ASSETS/alligator-baie-7-.jpg', 4),
(6, 6, '../ASSETS/panda.jpg', 4);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id_question` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `adresse_mail` varchar(100) DEFAULT NULL,
  `date_commentaire` datetime DEFAULT current_timestamp(),
  `statut` enum('en_attente','validé','archivé') DEFAULT 'en_attente',
  `message` text DEFAULT NULL,
  `rating` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id_question`, `pseudo`, `adresse_mail`, `date_commentaire`, `statut`, `message`, `rating`) VALUES
(1, 'Pomme', 'pomme09@hola.com', '2024-09-17 15:08:47', '', 'Superbe, journÃ©e, nous nous sommes bien amusez, les animaux sont magnifiques !! Les enfants sont heureux. Merci ', 0),
(5, 'Pommed&#039;am', 'pomme@hola.com', '2024-09-17 19:40:22', '', 'Excellente journÃ©e !! Les enfants sont heureux, pleins de rÃªves !! ', 5);

-- --------------------------------------------------------

--
-- Structure de la table `veterinaire`
--

CREATE TABLE `veterinaire` (
  `id_veterinaire` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `adresse_mail` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `veterinaire`
--

INSERT INTO `veterinaire` (`id_veterinaire`, `nom`, `prenom`, `adresse_mail`, `mot_de_passe`, `telephone`) VALUES
(1, 'Dupont', 'Jean', 'jean.dupont@example.com', 'motdepasse1', '0612345678'),
(2, 'Martin', 'Claire', 'claire.martin@example.com', 'motdepasse2', '0623456789'),
(3, 'Durand', 'Pierre', 'pierre.durand@example.com', 'motdepasse3', '0634567890'),
(4, 'Leroy', 'Sophie', 'sophie.leroy@example.com', 'motdepasse4', '0645678901');

-- --------------------------------------------------------

--
-- Structure de la table `view`
--

CREATE TABLE `view` (
  `id_view` int(11) NOT NULL,
  `id_animal` int(11) DEFAULT NULL,
  `nombre_view` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `view`
--

INSERT INTO `view` (`id_view`, `id_animal`, `nombre_view`) VALUES
(4, 1, 4),
(178, 1, 4),
(179, 2, 5),
(180, 3, 5),
(181, 4, 5),
(182, 5, 5),
(183, 6, 5),
(184, 1, 4),
(185, 2, 5),
(186, 3, 5),
(187, 4, 5),
(188, 5, 5),
(189, 6, 5),
(190, 1, 4),
(191, 2, 5),
(192, 3, 5),
(193, 4, 5),
(194, 5, 5),
(195, 6, 5),
(196, 1, 4),
(197, 2, 5),
(198, 3, 5),
(199, 4, 5),
(200, 5, 5),
(201, 6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE `visiteur` (
  `id_visiteur` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `adresse_mail` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`id_visiteur`, `pseudo`, `adresse_mail`) VALUES
(1, 'visiteur1', 'visiteur1@example.com'),
(2, 'visiteur2', 'visiteur2@example.com'),
(3, 'visiteur3', 'visiteur3@example.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`id_activite`);

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `adresse_mail` (`adresse_mail`);

--
-- Index pour la table `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id_animal`),
  ADD KEY `id_habitat` (`id_habitat`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id_employe`),
  ADD UNIQUE KEY `adresse_mail` (`adresse_mail`);

--
-- Index pour la table `habitat`
--
ALTER TABLE `habitat`
  ADD PRIMARY KEY (`id_habitat`);

--
-- Index pour la table `nourriture`
--
ALTER TABLE `nourriture`
  ADD PRIMARY KEY (`id_nourriture`),
  ADD KEY `fk_nourriture_animal` (`id_animal`);

--
-- Index pour la table `observation_animal`
--
ALTER TABLE `observation_animal`
  ADD PRIMARY KEY (`id_observation_animal`),
  ADD KEY `id_animal` (`id_animal`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `observation_habitat`
--
ALTER TABLE `observation_habitat`
  ADD PRIMARY KEY (`id_observation_habitat`),
  ADD KEY `id_habitat` (`id_habitat`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `parc`
--
ALTER TABLE `parc`
  ADD PRIMARY KEY (`id_parc`),
  ADD KEY `id_animal` (`id_animal`),
  ADD KEY `fk_parc_view` (`id_view`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id_question`);

--
-- Index pour la table `veterinaire`
--
ALTER TABLE `veterinaire`
  ADD PRIMARY KEY (`id_veterinaire`),
  ADD UNIQUE KEY `adresse_mail` (`adresse_mail`);

--
-- Index pour la table `view`
--
ALTER TABLE `view`
  ADD PRIMARY KEY (`id_view`),
  ADD KEY `id_animal` (`id_animal`);

--
-- Index pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD PRIMARY KEY (`id_visiteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activite`
--
ALTER TABLE `activite`
  MODIFY `id_activite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id_employe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `habitat`
--
ALTER TABLE `habitat`
  MODIFY `id_habitat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `nourriture`
--
ALTER TABLE `nourriture`
  MODIFY `id_nourriture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `observation_animal`
--
ALTER TABLE `observation_animal`
  MODIFY `id_observation_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `observation_habitat`
--
ALTER TABLE `observation_habitat`
  MODIFY `id_observation_habitat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `parc`
--
ALTER TABLE `parc`
  MODIFY `id_parc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `veterinaire`
--
ALTER TABLE `veterinaire`
  MODIFY `id_veterinaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `view`
--
ALTER TABLE `view`
  MODIFY `id_view` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT pour la table `visiteur`
--
ALTER TABLE `visiteur`
  MODIFY `id_visiteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `animal`
--
ALTER TABLE `animal`
  ADD CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`id_habitat`) REFERENCES `habitat` (`id_habitat`);

--
-- Contraintes pour la table `nourriture`
--
ALTER TABLE `nourriture`
  ADD CONSTRAINT `fk_nourriture_animal` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `observation_animal`
--
ALTER TABLE `observation_animal`
  ADD CONSTRAINT `observation_animal_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`),
  ADD CONSTRAINT `observation_animal_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `employe` (`id_employe`) ON DELETE CASCADE,
  ADD CONSTRAINT `observation_animal_ibfk_3` FOREIGN KEY (`id_utilisateur`) REFERENCES `veterinaire` (`id_veterinaire`) ON DELETE CASCADE;

--
-- Contraintes pour la table `observation_habitat`
--
ALTER TABLE `observation_habitat`
  ADD CONSTRAINT `observation_habitat_ibfk_1` FOREIGN KEY (`id_habitat`) REFERENCES `habitat` (`id_habitat`),
  ADD CONSTRAINT `observation_habitat_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `employe` (`id_employe`) ON DELETE CASCADE,
  ADD CONSTRAINT `observation_habitat_ibfk_3` FOREIGN KEY (`id_utilisateur`) REFERENCES `veterinaire` (`id_veterinaire`) ON DELETE CASCADE;

--
-- Contraintes pour la table `parc`
--
ALTER TABLE `parc`
  ADD CONSTRAINT `fk_parc_view` FOREIGN KEY (`id_view`) REFERENCES `view` (`id_view`),
  ADD CONSTRAINT `parc_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`) ON DELETE CASCADE;

--
-- Contraintes pour la table `view`
--
ALTER TABLE `view`
  ADD CONSTRAINT `view_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
