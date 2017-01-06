-- MySQL dump 10.11
--
-- Host: localhost    Database: cubberley
-- ------------------------------------------------------
-- Server version	5.0.95

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `date` date NOT NULL,
  `dance1` varchar(30) default NULL,
  `dance2` varchar(30) default NULL,
  `html` varchar(200) default NULL,
  `position` varchar(1) default NULL,
  PRIMARY KEY  (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar`
--

LOCK TABLES `calendar` WRITE;
/*!40000 ALTER TABLE `calendar` DISABLE KEYS */;
INSERT INTO `calendar` VALUES ('2017-01-04','Salsa',NULL,NULL,NULL),('2016-12-02','Foxtrot',NULL,'CHRISTMAS PARTY<br>Admission: $12.00','B'),('2016-12-09','Salsa Rueda',NULL,NULL,NULL),('2016-12-16','Tango',NULL,NULL,NULL),('2016-12-23','Country Two Step',NULL,NULL,NULL),('2016-12-30','Nightclub Two Step',NULL,NULL,NULL),('2016-12-31','Waltz',NULL,'NEW YEAR\'S EVE PARTY','B'),('2016-12-10','Viennese Waltz',NULL,'CHRISTMAS PARTY<br>Admission: $12.00','B'),('2016-12-03','Cha Cha',NULL,NULL,NULL),('2016-12-17','East Coast Swing',NULL,NULL,NULL),('2016-12-24',NULL,NULL,'NO DANCE',NULL),('2016-12-28',NULL,NULL,'NO DANCE',NULL),('2016-12-07','Foxtrot','Quickstep',NULL,NULL),('2016-12-14','Foxtrot','Quickstep',NULL,NULL),('2016-12-21','Foxtrot','Quickstep',NULL,NULL);
/*!40000 ALTER TABLE `calendar` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-06 13:54:34
