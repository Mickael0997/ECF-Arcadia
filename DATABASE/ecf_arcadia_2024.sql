-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: arcadia
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `animaux`
--

DROP TABLE IF EXISTS `animaux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `espece` varchar(50) NOT NULL,
  `surnom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `age` int(11) NOT NULL,
  `taille` decimal(5,2) NOT NULL,
  `poids` decimal(5,2) NOT NULL,
  `sexe` enum('M','F') NOT NULL,
  `type_animal` varchar(50) NOT NULL,
  `race` varchar(50) NOT NULL,
  `type_nourriture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animaux`
--

/*!40000 ALTER TABLE `animaux` DISABLE KEYS */;
INSERT INTO `animaux` VALUES (1,'Lion','Simba','2015-06-01',8,1.20,190.50,'M','Mammifère','Panthera leo','Carnivore'),(2,'Éléphant','Dumbo','2010-08-15',13,3.50,999.99,'M','Mammifère','Loxodonta','Herbivore'),(3,'Tigre','Shere Khan','2016-02-28',8,1.10,220.30,'M','Mammifère','Panthera tigris','Carnivore'),(4,'Girafe','Melman','2012-05-12',12,5.50,800.00,'M','Mammifère','Giraffa camelopardalis','Herbivore'),(5,'Zèbre','Marty','2018-11-23',6,1.40,380.00,'M','Mammifère','Equus quagga','Herbivore'),(6,'Panda','Po','2014-01-16',10,1.00,100.00,'M','Mammifère','Ailuropoda melanoleuca','Herbivore'),(7,'Koala','Koko','2017-03-07',7,0.80,14.00,'F','Mammifère','Phascolarctos cinereus','Herbivore'),(8,'Kangourou','Joey','2015-09-11',9,1.80,85.00,'M','Mammifère','Macropus','Herbivore'),(9,'Pingouin','Pingu','2018-04-19',6,0.60,27.00,'F','Oiseau','Spheniscidae','Carnivore'),(10,'Autruche','Ozzy','2013-07-14',11,2.70,130.00,'F','Oiseau','Struthio camelus','Herbivore'),(11,'Hippopotame','Gloria','2009-10-22',14,1.50,999.99,'F','Mammifère','Hippopotamus amphibius','Herbivore'),(12,'Rhinocéros','Rocky','2011-03-30',13,1.70,999.99,'M','Mammifère','Rhinocerotidae','Herbivore'),(13,'Chimpanzé','Cheeta','2012-12-02',12,1.20,50.00,'M','Mammifère','Pan troglodytes','Omnivore'),(14,'Léopard','Spot','2016-11-09',7,0.80,70.00,'F','Mammifère','Panthera pardus','Carnivore'),(15,'Orang-outan','Orang','2014-06-06',10,1.50,80.00,'M','Mammifère','Pongo','Omnivore'),(16,'Flamant','Pink','2017-01-25',7,1.20,3.50,'F','Oiseau','Phoenicopteridae','Herbivore'),(17,'Loup','Ghost','2015-11-11',9,0.90,45.00,'M','Mammifère','Canis lupus','Carnivore'),(18,'Ours polaire','Baloo','2013-02-13',11,2.40,450.00,'M','Mammifère','Ursus maritimus','Carnivore'),(19,'Tortue','Shelly','2007-05-22',17,0.50,80.00,'F','Reptile','Testudinidae','Herbivore'),(20,'Lémurien','King Julien','2018-08-17',6,0.40,3.20,'M','Mammifère','Lemuridae','Omnivore');
/*!40000 ALTER TABLE `animaux` ENABLE KEYS */;

--
-- Table structure for table `employes`
--

DROP TABLE IF EXISTS `employes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone_portable` varchar(15) NOT NULL,
  `fonction` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employes`
--

/*!40000 ALTER TABLE `employes` DISABLE KEYS */;
INSERT INTO `employes` VALUES (1,'Garcia','José','0601020304','Directeur','jose.garcia@arcadia.com','jose'),(2,'Martin','Josette','0602030405','Assistante','josette.martin@arcadia.com','josette'),(3,'Dupont','Alain','0603040506','Soigneur','alain.dupont@arcadia.com','alain'),(4,'Bernard','Camille','0604050607','Soigneuse','camille.bernard@arcadia.com','camille'),(5,'Petit','Marie','0605060708','Vétérinaire','marie.petit@arcadia.com','marie'),(6,'Roux','Pierre','0606070809','Agent de sécurité','pierre.roux@arcadia.com','pierre'),(7,'Moreau','Isabelle','0607080901','Guide','isabelle.moreau@arcadia.com','isabelle'),(8,'Fournier','Jean','0608090102','Caissier','jean.fournier@arcadia.com','jean'),(9,'Girard','Nathalie','0609010203','Technicienne','nathalie.girard@arcadia.com','nathalie'),(10,'Lemoine','Luc','0610203040','Responsable logistique','luc.lemoine@arcadia.com','luc'),(11,'Barbier','Steev','0611121314','Guide','steev.barbier@arcadia.com','steev'),(12,'Bouvier','Léa','0613111213','Caissière','lea.bouvier@arcadia.com','lea');
/*!40000 ALTER TABLE `employes` ENABLE KEYS */;

--
-- Table structure for table `veterinaires`
--

DROP TABLE IF EXISTS `veterinaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `veterinaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `veterinaires`
--

/*!40000 ALTER TABLE `veterinaires` DISABLE KEYS */;
INSERT INTO `veterinaires` VALUES (1,'Blanc','Michel','michel.blanc@arcadia.com','michel'),(2,'Verdi','Luigi','luigi.verdi@arcadia.com','luigi'),(3,'Smith','John','john.smith@arcadia.com','john');
/*!40000 ALTER TABLE `veterinaires` ENABLE KEYS */;

--
-- Dumping routines for database 'arcadia'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-07 15:08:14
