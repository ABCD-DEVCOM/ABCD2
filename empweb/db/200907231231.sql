-- MySQL dump 10.11
--
-- Host: localhost    Database: transa
-- ------------------------------------------------------
-- Server version	5.0.51b-community-nt

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
-- Table structure for table `calendars`
--

DROP TABLE IF EXISTS `calendars`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `calendars` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `calendar_id` varchar(18) default NULL,
  `year` varchar(5) default NULL,
  `historic` varchar(5) default NULL,
  `xml` text,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `calendar_id` (`calendar_id`),
  KEY `calendar_id_idx` (`calendar_id`),
  KEY `year_idx` (`year`),
  KEY `historic_idx` (`historic`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `calendars`
--

LOCK TABLES `calendars` WRITE;
/*!40000 ALTER TABLE `calendars` DISABLE KEYS */;
INSERT INTO `calendars` VALUES (1,'20090202_0C4290','2009','true','<calendar historic=\"false\"\n          id=\"20090202_0C4290\"\n          xmlns=\"http://kalio.net/empweb/schema/calendar/v1\">\n  <year value=\"2009\">\n    <month value=\"1\">\n      <day dow=\"5\"\n           value=\"1\" />\n      <day dow=\"6\"\n           value=\"2\" />\n      <day dow=\"7\"\n           value=\"3\" />\n      <day dow=\"1\"\n           value=\"4\" />\n      <day dow=\"2\"\n           value=\"5\" />\n      <day dow=\"3\"\n           value=\"6\" />\n      <day dow=\"4\"\n           value=\"7\" />\n      <day dow=\"5\"\n           value=\"8\" />\n      <day dow=\"6\"\n           value=\"9\" />\n      <day dow=\"7\"\n           value=\"10\" />\n      <day dow=\"1\"\n           value=\"11\" />\n      <day dow=\"2\"\n           value=\"12\" />\n      <day dow=\"3\"\n           value=\"13\" />\n      <day dow=\"4\"\n           value=\"14\" />\n      <day dow=\"5\"\n           value=\"15\" />\n      <day dow=\"6\"\n           value=\"16\" />\n      <day dow=\"7\"\n           value=\"17\" />\n      <day dow=\"1\"\n           value=\"18\" />\n      <day dow=\"2\"\n           value=\"19\" />\n      <day dow=\"3\"\n           value=\"20\" />\n      <day dow=\"4\"\n           value=\"21\" />\n      <day dow=\"5\"\n           value=\"22\" />\n      <day dow=\"6\"\n           value=\"23\" />\n      <day dow=\"7\"\n           value=\"24\" />\n      <day dow=\"1\"\n           value=\"25\" />\n      <day dow=\"2\"\n           value=\"26\" />\n      <day dow=\"3\"\n           value=\"27\" />\n      <day dow=\"4\"\n           value=\"28\" />\n      <day dow=\"5\"\n           value=\"29\" />\n      <day dow=\"6\"\n           value=\"30\" />\n      <day dow=\"7\"\n           value=\"31\" />\n    </month>\n    <month value=\"2\">\n      <day dow=\"1\"\n           value=\"1\" />\n      <day dow=\"2\"\n           value=\"2\" />\n      <day dow=\"3\"\n           value=\"3\" />\n      <day dow=\"4\"\n           value=\"4\" />\n      <day dow=\"5\"\n           value=\"5\" />\n      <day dow=\"6\"\n           value=\"6\" />\n      <day dow=\"7\"\n           value=\"7\" />\n      <day dow=\"1\"\n           value=\"8\" />\n      <day dow=\"2\"\n           value=\"9\" />\n      <day dow=\"3\"\n           value=\"10\" />\n      <day dow=\"4\"\n           value=\"11\" />\n      <day dow=\"5\"\n           value=\"12\" />\n      <day dow=\"6\"\n           value=\"13\" />\n      <day dow=\"7\"\n           value=\"14\" />\n      <day dow=\"1\"\n           value=\"15\" />\n      <day dow=\"2\"\n           value=\"16\" />\n      <day dow=\"3\"\n           value=\"17\" />\n      <day dow=\"4\"\n           value=\"18\" />\n      <day dow=\"5\"\n           value=\"19\" />\n      <day dow=\"6\"\n           value=\"20\" />\n      <day dow=\"7\"\n           value=\"21\" />\n      <day dow=\"1\"\n           value=\"22\" />\n      <day dow=\"2\"\n           value=\"23\" />\n      <day dow=\"3\"\n           value=\"24\" />\n      <day dow=\"4\"\n           value=\"25\" />\n      <day dow=\"5\"\n           value=\"26\" />\n      <day dow=\"6\"\n           value=\"27\" />\n      <day dow=\"7\"\n           value=\"28\" />\n    </month>\n    <month value=\"3\">\n      <day dow=\"1\"\n           value=\"1\" />\n      <day dow=\"2\"\n           value=\"2\" />\n      <day dow=\"3\"\n           value=\"3\" />\n      <day dow=\"4\"\n           value=\"4\" />\n      <day dow=\"5\"\n           value=\"5\" />\n      <day dow=\"6\"\n           value=\"6\" />\n      <day dow=\"7\"\n           value=\"7\" />\n      <day dow=\"1\"\n           value=\"8\" />\n      <day dow=\"2\"\n           value=\"9\" />\n      <day dow=\"3\"\n           value=\"10\" />\n      <day dow=\"4\"\n           value=\"11\" />\n      <day dow=\"5\"\n           value=\"12\" />\n      <day dow=\"6\"\n           value=\"13\" />\n      <day dow=\"7\"\n           value=\"14\" />\n      <day dow=\"1\"\n           value=\"15\" />\n      <day dow=\"2\"\n           value=\"16\" />\n      <day dow=\"3\"\n           value=\"17\" />\n      <day dow=\"4\"\n           value=\"18\" />\n      <day dow=\"5\"\n           value=\"19\" />\n      <day dow=\"6\"\n           value=\"20\" />\n      <day dow=\"7\"\n           value=\"21\" />\n      <day dow=\"1\"\n           value=\"22\" />\n      <day dow=\"2\"\n           value=\"23\" />\n      <day dow=\"3\"\n           value=\"24\" />\n      <day dow=\"4\"\n           value=\"25\" />\n      <day dow=\"5\"\n           value=\"26\" />\n      <day dow=\"6\"\n           value=\"27\" />\n      <day dow=\"7\"\n           value=\"28\" />\n      <day dow=\"1\"\n           value=\"29\" />\n      <day dow=\"2\"\n           value=\"30\" />\n      <day dow=\"3\"\n           value=\"31\" />\n    </month>\n    <month value=\"4\">\n      <day dow=\"4\"\n           value=\"1\" />\n      <day dow=\"5\"\n           value=\"2\" />\n      <day dow=\"6\"\n           value=\"3\" />\n      <day dow=\"7\"\n           value=\"4\" />\n      <day dow=\"1\"\n           value=\"5\" />\n      <day dow=\"2\"\n           value=\"6\" />\n      <day dow=\"3\"\n           value=\"7\" />\n      <day dow=\"4\"\n           value=\"8\" />\n      <day dow=\"5\"\n           value=\"9\" />\n      <day dow=\"6\"\n           value=\"10\" />\n      <day dow=\"7\"\n           value=\"11\" />\n      <day dow=\"1\"\n           value=\"12\" />\n      <day dow=\"2\"\n           value=\"13\" />\n      <day dow=\"3\"\n           value=\"14\" />\n      <day dow=\"4\"\n           value=\"15\" />\n      <day dow=\"5\"\n           value=\"16\" />\n      <day dow=\"6\"\n           value=\"17\" />\n      <day dow=\"7\"\n           value=\"18\" />\n      <day dow=\"1\"\n           value=\"19\" />\n      <day dow=\"2\"\n           value=\"20\" />\n      <day dow=\"3\"\n           value=\"21\" />\n      <day dow=\"4\"\n           value=\"22\" />\n      <day dow=\"5\"\n           value=\"23\" />\n      <day dow=\"6\"\n           value=\"24\" />\n      <day dow=\"7\"\n           value=\"25\" />\n      <day dow=\"1\"\n           value=\"26\" />\n      <day dow=\"2\"\n           value=\"27\" />\n      <day dow=\"3\"\n           value=\"28\" />\n      <day dow=\"4\"\n           value=\"29\" />\n      <day dow=\"5\"\n           value=\"30\" />\n    </month>\n    <month value=\"5\">\n      <day dow=\"6\"\n           value=\"1\" />\n      <day dow=\"7\"\n           value=\"2\" />\n      <day dow=\"1\"\n           value=\"3\" />\n      <day dow=\"2\"\n           value=\"4\" />\n      <day dow=\"3\"\n           value=\"5\" />\n      <day dow=\"4\"\n           value=\"6\" />\n      <day dow=\"5\"\n           value=\"7\" />\n      <day dow=\"6\"\n           value=\"8\" />\n      <day dow=\"7\"\n           value=\"9\" />\n      <day dow=\"1\"\n           value=\"10\" />\n      <day dow=\"2\"\n           value=\"11\" />\n      <day dow=\"3\"\n           value=\"12\" />\n      <day dow=\"4\"\n           value=\"13\" />\n      <day dow=\"5\"\n           value=\"14\" />\n      <day dow=\"6\"\n           value=\"15\" />\n      <day dow=\"7\"\n           value=\"16\" />\n      <day dow=\"1\"\n           value=\"17\" />\n      <day dow=\"2\"\n           value=\"18\" />\n      <day dow=\"3\"\n           value=\"19\" />\n      <day dow=\"4\"\n           value=\"20\" />\n      <day dow=\"5\"\n           value=\"21\" />\n      <day dow=\"6\"\n           value=\"22\" />\n      <day dow=\"7\"\n           value=\"23\" />\n      <day dow=\"1\"\n           value=\"24\" />\n      <day dow=\"2\"\n           value=\"25\" />\n      <day dow=\"3\"\n           value=\"26\" />\n      <day dow=\"4\"\n           value=\"27\" />\n      <day dow=\"5\"\n           value=\"28\" />\n      <day dow=\"6\"\n           value=\"29\" />\n      <day dow=\"7\"\n           value=\"30\" />\n      <day dow=\"1\"\n           value=\"31\" />\n    </month>\n    <month value=\"6\">\n      <day dow=\"2\"\n           value=\"1\" />\n      <day dow=\"3\"\n           value=\"2\" />\n      <day dow=\"4\"\n           value=\"3\" />\n      <day dow=\"5\"\n           value=\"4\" />\n      <day dow=\"6\"\n           value=\"5\" />\n      <day dow=\"7\"\n           value=\"6\" />\n      <day dow=\"1\"\n           value=\"7\" />\n      <day dow=\"2\"\n           value=\"8\" />\n      <day dow=\"3\"\n           value=\"9\" />\n      <day dow=\"4\"\n           value=\"10\" />\n      <day dow=\"5\"\n           value=\"11\" />\n      <day dow=\"6\"\n           value=\"12\" />\n      <day dow=\"7\"\n           value=\"13\" />\n      <day dow=\"1\"\n           value=\"14\" />\n      <day dow=\"2\"\n           value=\"15\" />\n      <day dow=\"3\"\n           value=\"16\" />\n      <day dow=\"4\"\n           value=\"17\" />\n      <day dow=\"5\"\n           value=\"18\" />\n      <day dow=\"6\"\n           value=\"19\" />\n      <day dow=\"7\"\n           value=\"20\" />\n      <day dow=\"1\"\n           value=\"21\" />\n      <day dow=\"2\"\n           value=\"22\" />\n      <day dow=\"3\"\n           value=\"23\" />\n      <day dow=\"4\"\n           value=\"24\" />\n      <day dow=\"5\"\n           value=\"25\" />\n      <day dow=\"6\"\n           value=\"26\" />\n      <day dow=\"7\"\n           value=\"27\" />\n      <day dow=\"1\"\n           value=\"28\" />\n      <day dow=\"2\"\n           value=\"29\" />\n      <day dow=\"3\"\n           value=\"30\" />\n    </month>\n    <month value=\"7\">\n      <day dow=\"4\"\n           value=\"1\" />\n      <day dow=\"5\"\n           value=\"2\" />\n      <day dow=\"6\"\n           value=\"3\" />\n      <day dow=\"7\"\n           value=\"4\" />\n      <day dow=\"1\"\n           value=\"5\" />\n      <day dow=\"2\"\n           value=\"6\" />\n      <day dow=\"3\"\n           value=\"7\" />\n      <day dow=\"4\"\n           value=\"8\" />\n      <day dow=\"5\"\n           value=\"9\" />\n      <day dow=\"6\"\n           value=\"10\" />\n      <day dow=\"7\"\n           value=\"11\" />\n      <day dow=\"1\"\n           value=\"12\" />\n      <day dow=\"2\"\n           value=\"13\" />\n      <day dow=\"3\"\n           value=\"14\" />\n      <day dow=\"4\"\n           value=\"15\" />\n      <day dow=\"5\"\n           value=\"16\" />\n      <day dow=\"6\"\n           value=\"17\" />\n      <day dow=\"7\"\n           value=\"18\" />\n      <day dow=\"1\"\n           value=\"19\" />\n      <day dow=\"2\"\n           value=\"20\" />\n      <day dow=\"3\"\n           value=\"21\" />\n      <day dow=\"4\"\n           value=\"22\" />\n      <day dow=\"5\"\n           value=\"23\" />\n      <day dow=\"6\"\n           value=\"24\" />\n      <day dow=\"7\"\n           value=\"25\" />\n      <day dow=\"1\"\n           value=\"26\" />\n      <day dow=\"2\"\n           value=\"27\" />\n      <day dow=\"3\"\n           value=\"28\" />\n      <day dow=\"4\"\n           value=\"29\" />\n      <day dow=\"5\"\n           value=\"30\" />\n      <day dow=\"6\"\n           value=\"31\" />\n    </month>\n    <month value=\"8\">\n      <day dow=\"7\"\n           value=\"1\" />\n      <day dow=\"1\"\n           value=\"2\" />\n      <day dow=\"2\"\n           value=\"3\" />\n      <day dow=\"3\"\n           value=\"4\" />\n      <day dow=\"4\"\n           value=\"5\" />\n      <day dow=\"5\"\n           value=\"6\" />\n      <day dow=\"6\"\n           value=\"7\" />\n      <day dow=\"7\"\n           value=\"8\" />\n      <day dow=\"1\"\n           value=\"9\" />\n      <day dow=\"2\"\n           value=\"10\" />\n      <day dow=\"3\"\n           value=\"11\" />\n      <day dow=\"4\"\n           value=\"12\" />\n      <day dow=\"5\"\n           value=\"13\" />\n      <day dow=\"6\"\n           value=\"14\" />\n      <day dow=\"7\"\n           value=\"15\" />\n      <day dow=\"1\"\n           value=\"16\" />\n      <day dow=\"2\"\n           value=\"17\" />\n      <day dow=\"3\"\n           value=\"18\" />\n      <day dow=\"4\"\n           value=\"19\" />\n      <day dow=\"5\"\n           value=\"20\" />\n      <day dow=\"6\"\n           value=\"21\" />\n      <day dow=\"7\"\n           value=\"22\" />\n      <day dow=\"1\"\n           value=\"23\" />\n      <day dow=\"2\"\n           value=\"24\" />\n      <day dow=\"3\"\n           value=\"25\" />\n      <day dow=\"4\"\n           value=\"26\" />\n      <day dow=\"5\"\n           value=\"27\" />\n      <day dow=\"6\"\n           value=\"28\" />\n      <day dow=\"7\"\n           value=\"29\" />\n      <day dow=\"1\"\n           value=\"30\" />\n      <day dow=\"2\"\n           value=\"31\" />\n    </month>\n    <month value=\"9\">\n      <day dow=\"3\"\n           value=\"1\" />\n      <day dow=\"4\"\n           value=\"2\" />\n      <day dow=\"5\"\n           value=\"3\" />\n      <day dow=\"6\"\n           value=\"4\" />\n      <day dow=\"7\"\n           value=\"5\" />\n      <day dow=\"1\"\n           value=\"6\" />\n      <day dow=\"2\"\n           value=\"7\" />\n      <day dow=\"3\"\n           value=\"8\" />\n      <day dow=\"4\"\n           value=\"9\" />\n      <day dow=\"5\"\n           value=\"10\" />\n      <day dow=\"6\"\n           value=\"11\" />\n      <day dow=\"7\"\n           value=\"12\" />\n      <day dow=\"1\"\n           value=\"13\" />\n      <day dow=\"2\"\n           value=\"14\" />\n      <day dow=\"3\"\n           value=\"15\" />\n      <day dow=\"4\"\n           value=\"16\" />\n      <day dow=\"5\"\n           value=\"17\" />\n      <day dow=\"6\"\n           value=\"18\" />\n      <day dow=\"7\"\n           value=\"19\" />\n      <day dow=\"1\"\n           value=\"20\" />\n      <day dow=\"2\"\n           value=\"21\" />\n      <day dow=\"3\"\n           value=\"22\" />\n      <day dow=\"4\"\n           value=\"23\" />\n      <day dow=\"5\"\n           value=\"24\" />\n      <day dow=\"6\"\n           value=\"25\" />\n      <day dow=\"7\"\n           value=\"26\" />\n      <day dow=\"1\"\n           value=\"27\" />\n      <day dow=\"2\"\n           value=\"28\" />\n      <day dow=\"3\"\n           value=\"29\" />\n      <day dow=\"4\"\n           value=\"30\" />\n    </month>\n    <month value=\"10\">\n      <day dow=\"5\"\n           value=\"1\" />\n      <day dow=\"6\"\n           value=\"2\" />\n      <day dow=\"7\"\n           value=\"3\" />\n      <day dow=\"1\"\n           value=\"4\" />\n      <day dow=\"2\"\n           value=\"5\" />\n      <day dow=\"3\"\n           value=\"6\" />\n      <day dow=\"4\"\n           value=\"7\" />\n      <day dow=\"5\"\n           value=\"8\" />\n      <day dow=\"6\"\n           value=\"9\" />\n      <day dow=\"7\"\n           value=\"10\" />\n      <day dow=\"1\"\n           value=\"11\" />\n      <day dow=\"2\"\n           value=\"12\" />\n      <day dow=\"3\"\n           value=\"13\" />\n      <day dow=\"4\"\n           value=\"14\" />\n      <day dow=\"5\"\n           value=\"15\" />\n      <day dow=\"6\"\n           value=\"16\" />\n      <day dow=\"7\"\n           value=\"17\" />\n      <day dow=\"1\"\n           value=\"18\" />\n      <day dow=\"2\"\n           value=\"19\" />\n      <day dow=\"3\"\n           value=\"20\" />\n      <day dow=\"4\"\n           value=\"21\" />\n      <day dow=\"5\"\n           value=\"22\" />\n      <day dow=\"6\"\n           value=\"23\" />\n      <day dow=\"7\"\n           value=\"24\" />\n      <day dow=\"1\"\n           value=\"25\" />\n      <day dow=\"2\"\n           value=\"26\" />\n      <day dow=\"3\"\n           value=\"27\" />\n      <day dow=\"4\"\n           value=\"28\" />\n      <day dow=\"5\"\n           value=\"29\" />\n      <day dow=\"6\"\n           value=\"30\" />\n      <day dow=\"7\"\n           value=\"31\" />\n    </month>\n    <month value=\"11\">\n      <day dow=\"1\"\n           value=\"1\" />\n      <day dow=\"2\"\n           value=\"2\" />\n      <day dow=\"3\"\n           value=\"3\" />\n      <day dow=\"4\"\n           value=\"4\" />\n      <day dow=\"5\"\n           value=\"5\" />\n      <day dow=\"6\"\n           value=\"6\" />\n      <day dow=\"7\"\n           value=\"7\" />\n      <day dow=\"1\"\n           value=\"8\" />\n      <day dow=\"2\"\n           value=\"9\" />\n      <day dow=\"3\"\n           value=\"10\" />\n      <day dow=\"4\"\n           value=\"11\" />\n      <day dow=\"5\"\n           value=\"12\" />\n      <day dow=\"6\"\n           value=\"13\" />\n      <day dow=\"7\"\n           value=\"14\" />\n      <day dow=\"1\"\n           value=\"15\" />\n      <day dow=\"2\"\n           value=\"16\" />\n      <day dow=\"3\"\n           value=\"17\" />\n      <day dow=\"4\"\n           value=\"18\" />\n      <day dow=\"5\"\n           value=\"19\" />\n      <day dow=\"6\"\n           value=\"20\" />\n      <day dow=\"7\"\n           value=\"21\" />\n      <day dow=\"1\"\n           value=\"22\" />\n      <day dow=\"2\"\n           value=\"23\" />\n      <day dow=\"3\"\n           value=\"24\" />\n      <day dow=\"4\"\n           value=\"25\" />\n      <day dow=\"5\"\n           value=\"26\" />\n      <day dow=\"6\"\n           value=\"27\" />\n      <day dow=\"7\"\n           value=\"28\" />\n      <day dow=\"1\"\n           value=\"29\" />\n      <day dow=\"2\"\n           value=\"30\" />\n    </month>\n    <month value=\"12\">\n      <day dow=\"3\"\n           value=\"1\" />\n      <day dow=\"4\"\n           value=\"2\" />\n      <day dow=\"5\"\n           value=\"3\" />\n      <day dow=\"6\"\n           value=\"4\" />\n      <day dow=\"7\"\n           value=\"5\" />\n      <day dow=\"1\"\n           value=\"6\" />\n      <day dow=\"2\"\n           value=\"7\" />\n      <day dow=\"3\"\n           value=\"8\" />\n      <day dow=\"4\"\n           value=\"9\" />\n      <day dow=\"5\"\n           value=\"10\" />\n      <day dow=\"6\"\n           value=\"11\" />\n      <day dow=\"7\"\n           value=\"12\" />\n      <day dow=\"1\"\n           value=\"13\" />\n      <day dow=\"2\"\n           value=\"14\" />\n      <day dow=\"3\"\n           value=\"15\" />\n      <day dow=\"4\"\n           value=\"16\" />\n      <day dow=\"5\"\n           value=\"17\" />\n      <day dow=\"6\"\n           value=\"18\" />\n      <day dow=\"7\"\n           value=\"19\" />\n      <day dow=\"1\"\n           value=\"20\" />\n      <day dow=\"2\"\n           value=\"21\" />\n      <day dow=\"3\"\n           value=\"22\" />\n      <day dow=\"4\"\n           value=\"23\" />\n      <day dow=\"5\"\n           value=\"24\" />\n      <day dow=\"6\"\n           value=\"25\" />\n      <day dow=\"7\"\n           value=\"26\" />\n      <day dow=\"1\"\n           value=\"27\" />\n      <day dow=\"2\"\n           value=\"28\" />\n      <day dow=\"3\"\n           value=\"29\" />\n      <day dow=\"4\"\n           value=\"30\" />\n      <day dow=\"5\"\n           value=\"31\" />\n    </month>\n  </year>\n</calendar>\n'),(2,'20090205_121510','2009','false','<calendar historic=\"false\"\n          id=\"20090205_121510\"\n          xmlns=\"http://kalio.net/empweb/schema/calendar/v1\">\n  <year value=\"2009\">\n    <month value=\"1\">\n      <day dow=\"5\"\n           value=\"1\" />\n      <day dow=\"6\"\n           value=\"2\" />\n      <day dow=\"7\"\n           value=\"3\" />\n      <day dow=\"1\"\n           value=\"4\" />\n      <day dow=\"2\"\n           value=\"5\" />\n      <day dow=\"3\"\n           value=\"6\" />\n      <day dow=\"4\"\n           value=\"7\" />\n      <day dow=\"5\"\n           value=\"8\" />\n      <day dow=\"6\"\n           value=\"9\" />\n      <day dow=\"7\"\n           value=\"10\" />\n      <day dow=\"1\"\n           value=\"11\" />\n      <day dow=\"2\"\n           value=\"12\" />\n      <day dow=\"3\"\n           value=\"13\" />\n      <day dow=\"4\"\n           value=\"14\" />\n      <day dow=\"5\"\n           value=\"15\" />\n      <day dow=\"6\"\n           value=\"16\" />\n      <day dow=\"7\"\n           value=\"17\" />\n      <day dow=\"1\"\n           value=\"18\" />\n      <day dow=\"2\"\n           value=\"19\" />\n      <day dow=\"3\"\n           value=\"20\" />\n      <day dow=\"4\"\n           value=\"21\" />\n      <day dow=\"5\"\n           value=\"22\" />\n      <day dow=\"6\"\n           value=\"23\" />\n      <day dow=\"7\"\n           value=\"24\" />\n      <day dow=\"1\"\n           value=\"25\" />\n      <day dow=\"2\"\n           value=\"26\" />\n      <day dow=\"3\"\n           value=\"27\" />\n      <day dow=\"4\"\n           value=\"28\" />\n      <day dow=\"5\"\n           value=\"29\" />\n      <day dow=\"6\"\n           value=\"30\" />\n      <day dow=\"7\"\n           value=\"31\" />\n    </month>\n    <month value=\"2\">\n      <day dow=\"1\"\n           value=\"1\" />\n      <day dow=\"2\"\n           value=\"2\" />\n      <day dow=\"3\"\n           value=\"3\" />\n      <day dow=\"4\"\n           value=\"4\" />\n      <day dow=\"5\"\n           value=\"5\" />\n      <day dow=\"6\"\n           value=\"6\" />\n      <day dow=\"7\"\n           value=\"7\" />\n      <day dow=\"1\"\n           value=\"8\" />\n      <day dow=\"2\"\n           value=\"9\" />\n      <day dow=\"3\"\n           value=\"10\" />\n      <day dow=\"4\"\n           value=\"11\" />\n      <day dow=\"5\"\n           value=\"12\" />\n      <day dow=\"6\"\n           value=\"13\">\n        <skipDay />\n      </day>\n      <day dow=\"7\"\n           value=\"14\">\n        <skipDay />\n      </day>\n      <day dow=\"1\"\n           value=\"15\" />\n      <day dow=\"2\"\n           value=\"16\" />\n      <day dow=\"3\"\n           value=\"17\" />\n      <day dow=\"4\"\n           value=\"18\" />\n      <day dow=\"5\"\n           value=\"19\" />\n      <day dow=\"6\"\n           value=\"20\" />\n      <day dow=\"7\"\n           value=\"21\" />\n      <day dow=\"1\"\n           value=\"22\" />\n      <day dow=\"2\"\n           value=\"23\" />\n      <day dow=\"3\"\n           value=\"24\" />\n      <day dow=\"4\"\n           value=\"25\" />\n      <day dow=\"5\"\n           value=\"26\" />\n      <day dow=\"6\"\n           value=\"27\" />\n      <day dow=\"7\"\n           value=\"28\" />\n    </month>\n    <month value=\"3\">\n      <day dow=\"1\"\n           value=\"1\" />\n      <day dow=\"2\"\n           value=\"2\" />\n      <day dow=\"3\"\n           value=\"3\" />\n      <day dow=\"4\"\n           value=\"4\" />\n      <day dow=\"5\"\n           value=\"5\" />\n      <day dow=\"6\"\n           value=\"6\" />\n      <day dow=\"7\"\n           value=\"7\" />\n      <day dow=\"1\"\n           value=\"8\" />\n      <day dow=\"2\"\n           value=\"9\" />\n      <day dow=\"3\"\n           value=\"10\" />\n      <day dow=\"4\"\n           value=\"11\" />\n      <day dow=\"5\"\n           value=\"12\" />\n      <day dow=\"6\"\n           value=\"13\" />\n      <day dow=\"7\"\n           value=\"14\" />\n      <day dow=\"1\"\n           value=\"15\" />\n      <day dow=\"2\"\n           value=\"16\" />\n      <day dow=\"3\"\n           value=\"17\" />\n      <day dow=\"4\"\n           value=\"18\" />\n      <day dow=\"5\"\n           value=\"19\" />\n      <day dow=\"6\"\n           value=\"20\" />\n      <day dow=\"7\"\n           value=\"21\" />\n      <day dow=\"1\"\n           value=\"22\" />\n      <day dow=\"2\"\n           value=\"23\" />\n      <day dow=\"3\"\n           value=\"24\" />\n      <day dow=\"4\"\n           value=\"25\" />\n      <day dow=\"5\"\n           value=\"26\" />\n      <day dow=\"6\"\n           value=\"27\" />\n      <day dow=\"7\"\n           value=\"28\" />\n      <day dow=\"1\"\n           value=\"29\" />\n      <day dow=\"2\"\n           value=\"30\" />\n      <day dow=\"3\"\n           value=\"31\" />\n    </month>\n    <month value=\"4\">\n      <day dow=\"4\"\n           value=\"1\" />\n      <day dow=\"5\"\n           value=\"2\" />\n      <day dow=\"6\"\n           value=\"3\" />\n      <day dow=\"7\"\n           value=\"4\" />\n      <day dow=\"1\"\n           value=\"5\" />\n      <day dow=\"2\"\n           value=\"6\" />\n      <day dow=\"3\"\n           value=\"7\" />\n      <day dow=\"4\"\n           value=\"8\" />\n      <day dow=\"5\"\n           value=\"9\" />\n      <day dow=\"6\"\n           value=\"10\" />\n      <day dow=\"7\"\n           value=\"11\" />\n      <day dow=\"1\"\n           value=\"12\" />\n      <day dow=\"2\"\n           value=\"13\" />\n      <day dow=\"3\"\n           value=\"14\" />\n      <day dow=\"4\"\n           value=\"15\" />\n      <day dow=\"5\"\n           value=\"16\" />\n      <day dow=\"6\"\n           value=\"17\" />\n      <day dow=\"7\"\n           value=\"18\" />\n      <day dow=\"1\"\n           value=\"19\" />\n      <day dow=\"2\"\n           value=\"20\" />\n      <day dow=\"3\"\n           value=\"21\" />\n      <day dow=\"4\"\n           value=\"22\" />\n      <day dow=\"5\"\n           value=\"23\" />\n      <day dow=\"6\"\n           value=\"24\" />\n      <day dow=\"7\"\n           value=\"25\" />\n      <day dow=\"1\"\n           value=\"26\" />\n      <day dow=\"2\"\n           value=\"27\" />\n      <day dow=\"3\"\n           value=\"28\" />\n      <day dow=\"4\"\n           value=\"29\" />\n      <day dow=\"5\"\n           value=\"30\" />\n    </month>\n    <month value=\"5\">\n      <day dow=\"6\"\n           value=\"1\" />\n      <day dow=\"7\"\n           value=\"2\" />\n      <day dow=\"1\"\n           value=\"3\" />\n      <day dow=\"2\"\n           value=\"4\" />\n      <day dow=\"3\"\n           value=\"5\" />\n      <day dow=\"4\"\n           value=\"6\" />\n      <day dow=\"5\"\n           value=\"7\" />\n      <day dow=\"6\"\n           value=\"8\" />\n      <day dow=\"7\"\n           value=\"9\" />\n      <day dow=\"1\"\n           value=\"10\" />\n      <day dow=\"2\"\n           value=\"11\" />\n      <day dow=\"3\"\n           value=\"12\" />\n      <day dow=\"4\"\n           value=\"13\" />\n      <day dow=\"5\"\n           value=\"14\" />\n      <day dow=\"6\"\n           value=\"15\" />\n      <day dow=\"7\"\n           value=\"16\" />\n      <day dow=\"1\"\n           value=\"17\" />\n      <day dow=\"2\"\n           value=\"18\" />\n      <day dow=\"3\"\n           value=\"19\" />\n      <day dow=\"4\"\n           value=\"20\" />\n      <day dow=\"5\"\n           value=\"21\" />\n      <day dow=\"6\"\n           value=\"22\" />\n      <day dow=\"7\"\n           value=\"23\" />\n      <day dow=\"1\"\n           value=\"24\" />\n      <day dow=\"2\"\n           value=\"25\" />\n      <day dow=\"3\"\n           value=\"26\" />\n      <day dow=\"4\"\n           value=\"27\" />\n      <day dow=\"5\"\n           value=\"28\" />\n      <day dow=\"6\"\n           value=\"29\" />\n      <day dow=\"7\"\n           value=\"30\" />\n      <day dow=\"1\"\n           value=\"31\" />\n    </month>\n    <month value=\"6\">\n      <day dow=\"2\"\n           value=\"1\" />\n      <day dow=\"3\"\n           value=\"2\" />\n      <day dow=\"4\"\n           value=\"3\" />\n      <day dow=\"5\"\n           value=\"4\" />\n      <day dow=\"6\"\n           value=\"5\" />\n      <day dow=\"7\"\n           value=\"6\" />\n      <day dow=\"1\"\n           value=\"7\" />\n      <day dow=\"2\"\n           value=\"8\" />\n      <day dow=\"3\"\n           value=\"9\" />\n      <day dow=\"4\"\n           value=\"10\" />\n      <day dow=\"5\"\n           value=\"11\" />\n      <day dow=\"6\"\n           value=\"12\" />\n      <day dow=\"7\"\n           value=\"13\" />\n      <day dow=\"1\"\n           value=\"14\" />\n      <day dow=\"2\"\n           value=\"15\" />\n      <day dow=\"3\"\n           value=\"16\" />\n      <day dow=\"4\"\n           value=\"17\" />\n      <day dow=\"5\"\n           value=\"18\" />\n      <day dow=\"6\"\n           value=\"19\" />\n      <day dow=\"7\"\n           value=\"20\" />\n      <day dow=\"1\"\n           value=\"21\" />\n      <day dow=\"2\"\n           value=\"22\" />\n      <day dow=\"3\"\n           value=\"23\" />\n      <day dow=\"4\"\n           value=\"24\" />\n      <day dow=\"5\"\n           value=\"25\" />\n      <day dow=\"6\"\n           value=\"26\" />\n      <day dow=\"7\"\n           value=\"27\" />\n      <day dow=\"1\"\n           value=\"28\" />\n      <day dow=\"2\"\n           value=\"29\" />\n      <day dow=\"3\"\n           value=\"30\" />\n    </month>\n    <month value=\"7\">\n      <day dow=\"4\"\n           value=\"1\" />\n      <day dow=\"5\"\n           value=\"2\" />\n      <day dow=\"6\"\n           value=\"3\" />\n      <day dow=\"7\"\n           value=\"4\" />\n      <day dow=\"1\"\n           value=\"5\" />\n      <day dow=\"2\"\n           value=\"6\" />\n      <day dow=\"3\"\n           value=\"7\" />\n      <day dow=\"4\"\n           value=\"8\" />\n      <day dow=\"5\"\n           value=\"9\" />\n      <day dow=\"6\"\n           value=\"10\" />\n      <day dow=\"7\"\n           value=\"11\" />\n      <day dow=\"1\"\n           value=\"12\" />\n      <day dow=\"2\"\n           value=\"13\" />\n      <day dow=\"3\"\n           value=\"14\" />\n      <day dow=\"4\"\n           value=\"15\" />\n      <day dow=\"5\"\n           value=\"16\" />\n      <day dow=\"6\"\n           value=\"17\" />\n      <day dow=\"7\"\n           value=\"18\" />\n      <day dow=\"1\"\n           value=\"19\" />\n      <day dow=\"2\"\n           value=\"20\" />\n      <day dow=\"3\"\n           value=\"21\" />\n      <day dow=\"4\"\n           value=\"22\" />\n      <day dow=\"5\"\n           value=\"23\" />\n      <day dow=\"6\"\n           value=\"24\" />\n      <day dow=\"7\"\n           value=\"25\" />\n      <day dow=\"1\"\n           value=\"26\" />\n      <day dow=\"2\"\n           value=\"27\" />\n      <day dow=\"3\"\n           value=\"28\" />\n      <day dow=\"4\"\n           value=\"29\" />\n      <day dow=\"5\"\n           value=\"30\" />\n      <day dow=\"6\"\n           value=\"31\" />\n    </month>\n    <month value=\"8\">\n      <day dow=\"7\"\n           value=\"1\" />\n      <day dow=\"1\"\n           value=\"2\" />\n      <day dow=\"2\"\n           value=\"3\" />\n      <day dow=\"3\"\n           value=\"4\" />\n      <day dow=\"4\"\n           value=\"5\" />\n      <day dow=\"5\"\n           value=\"6\" />\n      <day dow=\"6\"\n           value=\"7\" />\n      <day dow=\"7\"\n           value=\"8\" />\n      <day dow=\"1\"\n           value=\"9\" />\n      <day dow=\"2\"\n           value=\"10\" />\n      <day dow=\"3\"\n           value=\"11\" />\n      <day dow=\"4\"\n           value=\"12\" />\n      <day dow=\"5\"\n           value=\"13\" />\n      <day dow=\"6\"\n           value=\"14\" />\n      <day dow=\"7\"\n           value=\"15\" />\n      <day dow=\"1\"\n           value=\"16\" />\n      <day dow=\"2\"\n           value=\"17\" />\n      <day dow=\"3\"\n           value=\"18\" />\n      <day dow=\"4\"\n           value=\"19\" />\n      <day dow=\"5\"\n           value=\"20\" />\n      <day dow=\"6\"\n           value=\"21\" />\n      <day dow=\"7\"\n           value=\"22\" />\n      <day dow=\"1\"\n           value=\"23\" />\n      <day dow=\"2\"\n           value=\"24\" />\n      <day dow=\"3\"\n           value=\"25\" />\n      <day dow=\"4\"\n           value=\"26\" />\n      <day dow=\"5\"\n           value=\"27\" />\n      <day dow=\"6\"\n           value=\"28\" />\n      <day dow=\"7\"\n           value=\"29\" />\n      <day dow=\"1\"\n           value=\"30\" />\n      <day dow=\"2\"\n           value=\"31\" />\n    </month>\n    <month value=\"9\">\n      <day dow=\"3\"\n           value=\"1\" />\n      <day dow=\"4\"\n           value=\"2\" />\n      <day dow=\"5\"\n           value=\"3\" />\n      <day dow=\"6\"\n           value=\"4\" />\n      <day dow=\"7\"\n           value=\"5\" />\n      <day dow=\"1\"\n           value=\"6\" />\n      <day dow=\"2\"\n           value=\"7\" />\n      <day dow=\"3\"\n           value=\"8\" />\n      <day dow=\"4\"\n           value=\"9\" />\n      <day dow=\"5\"\n           value=\"10\" />\n      <day dow=\"6\"\n           value=\"11\" />\n      <day dow=\"7\"\n           value=\"12\" />\n      <day dow=\"1\"\n           value=\"13\" />\n      <day dow=\"2\"\n           value=\"14\" />\n      <day dow=\"3\"\n           value=\"15\" />\n      <day dow=\"4\"\n           value=\"16\" />\n      <day dow=\"5\"\n           value=\"17\" />\n      <day dow=\"6\"\n           value=\"18\" />\n      <day dow=\"7\"\n           value=\"19\" />\n      <day dow=\"1\"\n           value=\"20\" />\n      <day dow=\"2\"\n           value=\"21\" />\n      <day dow=\"3\"\n           value=\"22\" />\n      <day dow=\"4\"\n           value=\"23\" />\n      <day dow=\"5\"\n           value=\"24\" />\n      <day dow=\"6\"\n           value=\"25\" />\n      <day dow=\"7\"\n           value=\"26\" />\n      <day dow=\"1\"\n           value=\"27\" />\n      <day dow=\"2\"\n           value=\"28\" />\n      <day dow=\"3\"\n           value=\"29\" />\n      <day dow=\"4\"\n           value=\"30\" />\n    </month>\n    <month value=\"10\">\n      <day dow=\"5\"\n           value=\"1\" />\n      <day dow=\"6\"\n           value=\"2\" />\n      <day dow=\"7\"\n           value=\"3\" />\n      <day dow=\"1\"\n           value=\"4\" />\n      <day dow=\"2\"\n           value=\"5\" />\n      <day dow=\"3\"\n           value=\"6\" />\n      <day dow=\"4\"\n           value=\"7\" />\n      <day dow=\"5\"\n           value=\"8\" />\n      <day dow=\"6\"\n           value=\"9\" />\n      <day dow=\"7\"\n           value=\"10\" />\n      <day dow=\"1\"\n           value=\"11\" />\n      <day dow=\"2\"\n           value=\"12\" />\n      <day dow=\"3\"\n           value=\"13\" />\n      <day dow=\"4\"\n           value=\"14\" />\n      <day dow=\"5\"\n           value=\"15\" />\n      <day dow=\"6\"\n           value=\"16\" />\n      <day dow=\"7\"\n           value=\"17\" />\n      <day dow=\"1\"\n           value=\"18\" />\n      <day dow=\"2\"\n           value=\"19\" />\n      <day dow=\"3\"\n           value=\"20\" />\n      <day dow=\"4\"\n           value=\"21\" />\n      <day dow=\"5\"\n           value=\"22\" />\n      <day dow=\"6\"\n           value=\"23\" />\n      <day dow=\"7\"\n           value=\"24\" />\n      <day dow=\"1\"\n           value=\"25\" />\n      <day dow=\"2\"\n           value=\"26\" />\n      <day dow=\"3\"\n           value=\"27\" />\n      <day dow=\"4\"\n           value=\"28\" />\n      <day dow=\"5\"\n           value=\"29\" />\n      <day dow=\"6\"\n           value=\"30\" />\n      <day dow=\"7\"\n           value=\"31\" />\n    </month>\n    <month value=\"11\">\n      <day dow=\"1\"\n           value=\"1\" />\n      <day dow=\"2\"\n           value=\"2\" />\n      <day dow=\"3\"\n           value=\"3\" />\n      <day dow=\"4\"\n           value=\"4\" />\n      <day dow=\"5\"\n           value=\"5\" />\n      <day dow=\"6\"\n           value=\"6\" />\n      <day dow=\"7\"\n           value=\"7\" />\n      <day dow=\"1\"\n           value=\"8\" />\n      <day dow=\"2\"\n           value=\"9\" />\n      <day dow=\"3\"\n           value=\"10\" />\n      <day dow=\"4\"\n           value=\"11\" />\n      <day dow=\"5\"\n           value=\"12\" />\n      <day dow=\"6\"\n           value=\"13\" />\n      <day dow=\"7\"\n           value=\"14\" />\n      <day dow=\"1\"\n           value=\"15\" />\n      <day dow=\"2\"\n           value=\"16\" />\n      <day dow=\"3\"\n           value=\"17\" />\n      <day dow=\"4\"\n           value=\"18\" />\n      <day dow=\"5\"\n           value=\"19\" />\n      <day dow=\"6\"\n           value=\"20\" />\n      <day dow=\"7\"\n           value=\"21\" />\n      <day dow=\"1\"\n           value=\"22\" />\n      <day dow=\"2\"\n           value=\"23\" />\n      <day dow=\"3\"\n           value=\"24\" />\n      <day dow=\"4\"\n           value=\"25\" />\n      <day dow=\"5\"\n           value=\"26\" />\n      <day dow=\"6\"\n           value=\"27\" />\n      <day dow=\"7\"\n           value=\"28\" />\n      <day dow=\"1\"\n           value=\"29\" />\n      <day dow=\"2\"\n           value=\"30\" />\n    </month>\n    <month value=\"12\">\n      <day dow=\"3\"\n           value=\"1\" />\n      <day dow=\"4\"\n           value=\"2\" />\n      <day dow=\"5\"\n           value=\"3\" />\n      <day dow=\"6\"\n           value=\"4\" />\n      <day dow=\"7\"\n           value=\"5\" />\n      <day dow=\"1\"\n           value=\"6\" />\n      <day dow=\"2\"\n           value=\"7\" />\n      <day dow=\"3\"\n           value=\"8\" />\n      <day dow=\"4\"\n           value=\"9\" />\n      <day dow=\"5\"\n           value=\"10\" />\n      <day dow=\"6\"\n           value=\"11\" />\n      <day dow=\"7\"\n           value=\"12\" />\n      <day dow=\"1\"\n           value=\"13\" />\n      <day dow=\"2\"\n           value=\"14\" />\n      <day dow=\"3\"\n           value=\"15\" />\n      <day dow=\"4\"\n           value=\"16\" />\n      <day dow=\"5\"\n           value=\"17\" />\n      <day dow=\"6\"\n           value=\"18\" />\n      <day dow=\"7\"\n           value=\"19\" />\n      <day dow=\"1\"\n           value=\"20\" />\n      <day dow=\"2\"\n           value=\"21\" />\n      <day dow=\"3\"\n           value=\"22\" />\n      <day dow=\"4\"\n           value=\"23\" />\n      <day dow=\"5\"\n           value=\"24\" />\n      <day dow=\"6\"\n           value=\"25\" />\n      <day dow=\"7\"\n           value=\"26\" />\n      <day dow=\"1\"\n           value=\"27\" />\n      <day dow=\"2\"\n           value=\"28\" />\n      <day dow=\"3\"\n           value=\"29\" />\n      <day dow=\"4\"\n           value=\"30\" />\n      <day dow=\"5\"\n           value=\"31\" />\n    </month>\n  </year>\n</calendar>\n');
/*!40000 ALTER TABLE `calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ew_test_table`
--

DROP TABLE IF EXISTS `ew_test_table`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ew_test_table` (
  `a` char(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ew_test_table`
--

LOCK TABLES `ew_test_table` WRITE;
/*!40000 ALTER TABLE `ew_test_table` DISABLE KEYS */;
/*!40000 ALTER TABLE `ew_test_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fines`
--

DROP TABLE IF EXISTS `fines`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `fines` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `trans_id` varchar(18) default NULL,
  `user_id` varchar(30) default NULL,
  `user_db` varchar(30) default NULL,
  `date` varchar(14) default NULL,
  `type` varchar(30) default NULL,
  `amount` float default '0',
  `obs` varchar(300) default NULL,
  `copy_id` varchar(30) default NULL,
  `record_id` varchar(30) default NULL,
  `object_db` varchar(30) default NULL,
  `profile_id` varchar(30) default NULL,
  `user_class` varchar(30) default NULL,
  `object_category` varchar(30) default NULL,
  `loan_start_date` varchar(14) default NULL,
  `loan_end_date` varchar(14) default NULL,
  `days_overdue` smallint(5) unsigned default NULL,
  `date_paid` varchar(14) default NULL,
  `amount_paid` float default '0',
  `ref_id` varchar(18) default NULL,
  `operator_id` varchar(30) default NULL,
  `location` varchar(30) default NULL,
  `historic` varchar(5) default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `trans_id` (`trans_id`),
  KEY `trans_id_idx` (`trans_id`),
  KEY `user_db_idx` (`user_db`),
  KEY `user_id_idx` (`user_id`),
  KEY `date_idx` (`date`),
  KEY `copy_id_idx` (`copy_id`),
  KEY `record_id_idx` (`record_id`),
  KEY `object_db_idx` (`object_db`),
  KEY `date_paid_idx` (`date_paid`),
  KEY `location_idx` (`location`),
  KEY `historic_idx` (`historic`),
  KEY `ref_id_idx` (`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `fines`
--

LOCK TABLES `fines` WRITE;
/*!40000 ALTER TABLE `fines` DISABLE KEYS */;
/*!40000 ALTER TABLE `fines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loans`
--

DROP TABLE IF EXISTS `loans`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `loans` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `trans_id` varchar(18) default NULL,
  `user_id` varchar(30) default NULL,
  `user_db` varchar(30) default NULL,
  `copy_id` varchar(30) default NULL,
  `record_id` varchar(30) default NULL,
  `object_db` varchar(30) default NULL,
  `profile_id` varchar(30) default NULL,
  `user_class` varchar(30) default NULL,
  `object_category` varchar(30) default NULL,
  `start_date` varchar(14) default NULL,
  `end_date` varchar(14) default NULL,
  `operator_id` varchar(30) default NULL,
  `location` varchar(30) default NULL,
  `ref_id` varchar(18) default NULL,
  `reservation_id` varchar(18) default NULL,
  `historic` varchar(5) default NULL,
  `ord_renewal` varchar(8) NOT NULL,
  `ord_renewal_desk` varchar(8) NOT NULL,
  `ord_renewal_mysite` varchar(8) NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `trans_id` (`trans_id`),
  KEY `trans_id_idx` (`trans_id`),
  KEY `start_date_idx` (`start_date`),
  KEY `object_db_idx` (`object_db`),
  KEY `record_id_idx` (`record_id`),
  KEY `copy_id_idx` (`copy_id`),
  KEY `user_db_idx` (`user_db`),
  KEY `user_id_idx` (`user_id`),
  KEY `ref_id_idx` (`ref_id`),
  KEY `reservation_id_idx` (`reservation_id`),
  KEY `end_date_idx` (`end_date`),
  KEY `location_idx` (`location`),
  KEY `historic_idx` (`historic`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `loans`
--

LOCK TABLES `loans` WRITE;
/*!40000 ALTER TABLE `loans` DISABLE KEYS */;
INSERT INTO `loans` VALUES (1,'20090721_145C90','01','isis','10012','4','objetos','20090718_0D8F00','Coordinadores','LBH','20090721231001','20090721235900','abcd','AGR','',NULL,'true','0','0','0'),(2,'20090721_146610','01','isis','10013','5','objetos','20090718_0D8F00','Coordinadores','LBH','20090721231233','20090721235900','abcd','AGR','',NULL,'true','0','0','0'),(3,'20090721_14C6E0','02','isis','10013','5','objetos','20090718_0D8F00','Directores','LBH','20090721233822','20090721235900','abcd','AGR','',NULL,'true','0','0','0'),(4,'20090721_14CBD0','01','isis','10013','5','objetos','20090718_0D8F00','Coordinadores','LBH','20090721233941','20090721235900','abcd','AGR','',NULL,'true','0','0','0'),(5,'20090721_14CEA0','01','isis','10013','5','objetos','20090718_0D8F00','Coordinadores','LBH','20090721234026','20090721235900','abcd','AGR','',NULL,'true','0','0','0'),(6,'20090721_14D260','01','isis','10012','4','objetos','20090718_0D8F00','Coordinadores','LBH','20090721234126','20090721235900','abcd','AGR','',NULL,'true','0','0','0'),(7,'20090721_14FE90','01','isis','10032','24','objetos','20090316_0E7F00','Coordinadores','CD','20090721235313','20090726150000','abcd','AGR','',NULL,'true','0','0','0'),(8,'20090721_150120','01','isis','10012','4','objetos','20090718_0D8F00','Coordinadores','LBH','20090721235354','20090721235900','abcd','AGR','',NULL,'true','0','0','0'),(9,'20090722_000E30','01','isis','10012','4','objetos','20090718_0D8F00','Coordinadores','LBH','20090722000347','20090722020347','abcd','AGR','',NULL,'false','0','0','0');
/*!40000 ALTER TABLE `loans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `policies`
--

DROP TABLE IF EXISTS `policies`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `policies` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `policy_id` varchar(18) default NULL,
  `active` varchar(5) default NULL,
  `historic` varchar(5) default NULL,
  `name` varchar(30) default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `policy_id` (`policy_id`),
  KEY `policy_id_idx` (`policy_id`),
  KEY `active_idx` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `policies`
--

LOCK TABLES `policies` WRITE;
/*!40000 ALTER TABLE `policies` DISABLE KEYS */;
INSERT INTO `policies` VALUES (1,'20090127_0A6C20','true','false','default'),(2,'20090205_115850','false','false','general');
/*!40000 ALTER TABLE `policies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `profiles` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `profile_id` varchar(18) default NULL,
  `user_class` varchar(30) default NULL,
  `object_category` varchar(30) default NULL,
  `policy_id` varchar(18) default NULL,
  `historic` varchar(5) default NULL,
  `xml` text,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `profile_id` (`profile_id`),
  KEY `profile_id_idx` (`profile_id`),
  KEY `user_class_idx` (`user_class`),
  KEY `object_category_idx` (`object_category`),
  KEY `policy_id_idx` (`policy_id`),
  KEY `historic_idx` (`historic`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (2,'20090308_01AB70','*','*','20090127_0A6C20','true','<profile historic=\"true\"\r\n         id=\"20090308_01AB70\"\r\n         xmlns=\"http://kalio.net/empweb/schema/profile/v1\">\r\n  <userClass>*</userClass>\r\n  <objectCategory>*</objectCategory>\r\n  <policy>20090127_0A6C20</policy>\r\n  <limits>\r\n    <limit name=\"maxReservationsIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameCategory\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"loanDays\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxFineAmountForLoan\">\r\n      <value>12</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredNormal\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"fineAmountIfExpiredReserved\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"fineAmountIfExpiredNormal\">\r\n      <value>1</value>\r\n    </limit>\r\n    <limit name=\"createFineIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxLoansTotal\">\r\n      <value>10</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameRecord\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"expirationDays\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfLate\">\r\n      <value>true</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredReserved\">\r\n      <value>4</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createFineIfLate\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameRecord\">\r\n      <value>1</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameCategory\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"minRemainingCopies\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfFine\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountReserved\">\r\n      <value>30</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForReservation\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysReserved\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsTotal\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewals\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountNormal\">\r\n      <value>20</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysNormal\">\r\n      <value>4</value>\r\n    </limit>\r\n  </limits>\r\n  <timestamp>20090308015359</timestamp>\r\n</profile>\r\n'),(4,'20090308_1298A0','*','*','20090127_0A6C20','true','<profile historic=\"true\"\r\n         id=\"20090308_1298A0\"\r\n         xmlns=\"http://kalio.net/empweb/schema/profile/v1\">\r\n  <userClass>*</userClass>\r\n  <objectCategory>*</objectCategory>\r\n  <policy>20090127_0A6C20</policy>\r\n  <limits>\r\n    <limit name=\"maxReservationsIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameCategory\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"loanDays\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxFineAmountForLoan\">\r\n      <value>12</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredNormal\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"fineAmountIfExpiredReserved\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"fineAmountIfExpiredNormal\">\r\n      <value>1</value>\r\n    </limit>\r\n    <limit name=\"createFineIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxLoansTotal\">\r\n      <value>10</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameRecord\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"expirationDays\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfLate\">\r\n      <value>true</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredReserved\">\r\n      <value>4</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewalsFromMySite\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"createFineIfLate\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameRecord\">\r\n      <value>1</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameCategory\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"minRemainingCopies\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfFine\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountReserved\">\r\n      <value>30</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForReservation\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysReserved\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsTotal\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewals\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountNormal\">\r\n      <value>20</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysNormal\">\r\n      <value>4</value>\r\n    </limit>\r\n  </limits>\r\n  <timestamp>20090308210930</timestamp>\r\n</profile>\r\n'),(5,'20090316_0E7F00','*','*','20090127_0A6C20','false','<profile historic=\"false\"\r\n         id=\"20090316_0E7F00\"\r\n         xmlns=\"http://kalio.net/empweb/schema/profile/v1\">\r\n  <userClass>*</userClass>\r\n  <objectCategory>*</objectCategory>\r\n  <policy>20090127_0A6C20</policy>\r\n  <limits>\r\n    <limit name=\"maxReservationsIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameCategory\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"loanDays\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxFineAmountForLoan\">\r\n      <value>12</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredNormal\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"fineAmountIfExpiredReserved\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"fineAmountIfExpiredNormal\">\r\n      <value>1</value>\r\n    </limit>\r\n    <limit name=\"createFineIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxLoansTotal\">\r\n      <value>10</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameRecord\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"expirationDays\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfLate\">\r\n      <value>true</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredReserved\">\r\n      <value>4</value>\r\n    </limit>\r\n    <limit name=\"fineAmountIfConfirmedReserveIsCancelled\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewalsFromMySite\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"createFineIfLate\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameRecord\">\r\n      <value>1</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameCategory\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"minRemainingCopies\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfFine\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountReserved\">\r\n      <value>30</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForReservation\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createFineIfReservationConfirmedIsCancelled\">\r\n      <value>true</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysReserved\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsTotal\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountNormal\">\r\n      <value>20</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewals\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysNormal\">\r\n      <value>4</value>\r\n    </limit>\r\n  </limits>\r\n  <timestamp>20090316162936</timestamp>\r\n</profile>\r\n'),(7,'20090718_010960','*','LBH','20090127_0A6C20','true','<profile historic=\"true\"\r\n         id=\"20090718_010960\"\r\n         xmlns=\"http://kalio.net/empweb/schema/profile/v1\">\r\n  <userClass>*</userClass>\r\n  <objectCategory>LBH</objectCategory>\r\n  <policy>20090127_0A6C20</policy>\r\n  <limits>\r\n    <limit name=\"maxReservationsIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameCategory\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"loanDays\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxFineAmountForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredNormal\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansTotal\">\r\n      <value>10</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameRecord\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"expirationDays\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfLate\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredReserved\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewalsFromMySite\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createFineIfLate\">\r\n      <value>true</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameRecord\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameCategory\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"fineAmountReserved\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForReservation\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysReserved\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsTotal\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewals\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountNormal\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"loanHours\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysNormal\">\r\n      <value>0</value>\r\n    </limit>\r\n  </limits>\r\n  <timestamp>20090718011046</timestamp>\r\n</profile>\r\n'),(9,'20090718_011010','*','LBH','20090127_0A6C20','true','<profile historic=\"true\"\r\n         id=\"20090718_011010\"\r\n         xmlns=\"http://kalio.net/empweb/schema/profile/v1\">\r\n  <userClass>*</userClass>\r\n  <objectCategory>LBH</objectCategory>\r\n  <policy>20090127_0A6C20</policy>\r\n  <limits>\r\n    <limit name=\"maxReservationsIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameCategory\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"loanDays\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxFineAmountForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredNormal\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansTotal\">\r\n      <value>10</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameRecord\">\r\n      <value>1</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"expirationDays\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfLate\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredReserved\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewalsFromMySite\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createFineIfLate\">\r\n      <value>true</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameRecord\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameCategory\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"fineAmountReserved\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForReservation\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysReserved\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsTotal\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewals\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountNormal\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"loanHours\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysNormal\">\r\n      <value>0</value>\r\n    </limit>\r\n  </limits>\r\n  <timestamp>20090718011233</timestamp>\r\n</profile>\r\n'),(10,'20090718_0D8F00','*','LBH','20090127_0A6C20','false','<profile historic=\"false\"\r\n         id=\"20090718_0D8F00\"\r\n         xmlns=\"http://kalio.net/empweb/schema/profile/v1\">\r\n  <userClass>*</userClass>\r\n  <objectCategory>LBH</objectCategory>\r\n  <policy>20090127_0A6C20</policy>\r\n  <limits>\r\n    <limit name=\"maxReservationsIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameCategory\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"loanDays\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxFineAmountForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredNormal\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansTotal\">\r\n      <value>10</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameRecord\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForLoan\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"expirationDays\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfLate\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysIfExpiredReserved\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfLate\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewalsFromMySite\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"createFineIfLate\">\r\n      <value>true</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsSameRecord\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansSameCategory\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxLoansIfFine\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"fineAmountReserved\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"createSuspensionIfReservationExpired\">\r\n      <value>false</value>\r\n    </limit>\r\n    <limit name=\"maxFinesForReservation\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysReserved\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsTotal\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"maxNumberOfRenewals\">\r\n      <value>3</value>\r\n    </limit>\r\n    <limit name=\"fineAmountNormal\">\r\n      <value>5</value>\r\n    </limit>\r\n    <limit name=\"loanHours\">\r\n      <value>2</value>\r\n    </limit>\r\n    <limit name=\"maxReservationsIfSuspension\">\r\n      <value>0</value>\r\n    </limit>\r\n    <limit name=\"suspensionDaysNormal\">\r\n      <value>0</value>\r\n    </limit>\r\n  </limits>\r\n  <timestamp>20090718152536</timestamp>\r\n</profile>\r\n');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reservations` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `trans_id` varchar(18) default NULL,
  `user_id` varchar(30) default NULL,
  `user_db` varchar(30) default NULL,
  `record_id` varchar(30) default NULL,
  `object_db` varchar(30) default NULL,
  `volume_id` varchar(30) default NULL,
  `object_location` varchar(30) default NULL,
  `date` varchar(14) default NULL,
  `start_date` varchar(14) default NULL,
  `end_date` varchar(14) default NULL,
  `expiration_date` varchar(14) default NULL,
  `cancel_id` varchar(18) default NULL,
  `obs` varchar(300) default NULL,
  `profile_id` varchar(18) default NULL,
  `user_class` varchar(30) default NULL,
  `object_category` varchar(30) default NULL,
  `location` varchar(30) default NULL,
  `operator_id` varchar(30) default NULL,
  `historic` varchar(5) default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `trans_id` (`trans_id`),
  KEY `trans_id_idx` (`trans_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `user_db_idx` (`user_db`),
  KEY `record_id_idx` (`record_id`),
  KEY `volume_id_idx` (`volume_id`),
  KEY `object_db_idx` (`object_db`),
  KEY `object_location_idx` (`object_location`),
  KEY `date_idx` (`date`),
  KEY `start_date_idx` (`start_date`),
  KEY `end_date_idx` (`end_date`),
  KEY `expiration_date_idx` (`expiration_date`),
  KEY `location_idx` (`location`),
  KEY `historic_idx` (`historic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `returns`
--

DROP TABLE IF EXISTS `returns`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `returns` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `trans_id` varchar(18) default NULL,
  `user_id` varchar(30) default NULL,
  `user_db` varchar(30) default NULL,
  `copy_id` varchar(30) default NULL,
  `record_id` varchar(30) default NULL,
  `object_db` varchar(30) default NULL,
  `loan_id` varchar(18) default NULL,
  `profile_id` varchar(18) default NULL,
  `user_class` varchar(30) default NULL,
  `object_category` varchar(30) default NULL,
  `loan_date` varchar(14) default NULL,
  `return_date` varchar(14) default NULL,
  `operator_id` varchar(30) default NULL,
  `location` varchar(30) default NULL,
  `historic` varchar(5) default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `trans_id` (`trans_id`),
  KEY `trans_id_idx` (`trans_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `user_db_idx` (`user_db`),
  KEY `copy_id_idx` (`copy_id`),
  KEY `record_id_idx` (`record_id`),
  KEY `object_db_idx` (`object_db`),
  KEY `loan_date_idx` (`loan_date`),
  KEY `return_date_idx` (`return_date`),
  KEY `location_idx` (`location`),
  KEY `historic_idx` (`historic`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `returns`
--

LOCK TABLES `returns` WRITE;
/*!40000 ALTER TABLE `returns` DISABLE KEYS */;
INSERT INTO `returns` VALUES (1,'20090721_1467D0','01','isis','10012','4','objetos','20090721_145C90','20090718_0D8F00','Coordinadores','LBH','20090721231001','20090721231301','abcd','AGR','true'),(2,'20090721_146850','01','isis','10013','5','objetos','20090721_146610','20090718_0D8F00','Coordinadores','LBH','20090721231233','20090721231309','abcd','AGR','true'),(3,'20090721_14CB20','02','isis','10013','5','objetos','20090721_14C6E0','20090718_0D8F00','Directores','LBH','20090721233822','20090721233930','abcd','AGR','true'),(4,'20090721_14CE20','01','isis','10013','5','objetos','20090721_14CBD0','20090718_0D8F00','Coordinadores','LBH','20090721233941','20090721234018','abcd','AGR','true'),(5,'20090721_14D820','01','isis','10012','4','objetos','20090721_14D260','20090718_0D8F00','Coordinadores','LBH','20090721234126','20090721234258','abcd','AGR','true'),(6,'20090721_1500A0','01','isis','10013','5','objetos','20090721_14CEA0','20090718_0D8F00','Coordinadores','LBH','20090721234026','20090721235346','abcd','AGR','true'),(7,'20090722_000D80','01','isis','10012','4','objetos','20090721_150120','20090718_0D8F00','Coordinadores','LBH','20090721235354','20090722000336','abcd','AGR','true'),(8,'20090722_000D90','01','isis','10032','24','objetos','20090721_14FE90','20090316_0E7F00','Coordinadores','CD','20090721235313','20090722000337','abcd','AGR','true');
/*!40000 ALTER TABLE `returns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suspensions`
--

DROP TABLE IF EXISTS `suspensions`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `suspensions` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `trans_id` varchar(18) default NULL,
  `user_id` varchar(30) default NULL,
  `user_db` varchar(30) default NULL,
  `date` varchar(14) default NULL,
  `start_date` varchar(14) default NULL,
  `end_date` varchar(14) default NULL,
  `days_suspended` smallint(5) unsigned default NULL,
  `type` varchar(30) default NULL,
  `obs` varchar(300) default NULL,
  `copy_id` varchar(30) default NULL,
  `record_id` varchar(30) default NULL,
  `object_db` varchar(30) default NULL,
  `profile_id` varchar(18) default NULL,
  `user_class` varchar(30) default NULL,
  `object_category` varchar(30) default NULL,
  `loan_start_date` varchar(14) default NULL,
  `loan_end_date` varchar(14) default NULL,
  `days_overdue` smallint(5) unsigned default NULL,
  `cancel_id` varchar(18) default NULL,
  `location` varchar(30) default NULL,
  `operator_id` varchar(30) default NULL,
  `historic` varchar(5) default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `trans_id` (`trans_id`),
  KEY `trans_id_idx` (`trans_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `user_db_idx` (`user_db`),
  KEY `date_idx` (`date`),
  KEY `start_date_idx` (`start_date`),
  KEY `end_date_idx` (`end_date`),
  KEY `copy_id_idx` (`copy_id`),
  KEY `object_db_idx` (`object_db`),
  KEY `location_idx` (`location`),
  KEY `historic_idx` (`historic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `suspensions`
--

LOCK TABLES `suspensions` WRITE;
/*!40000 ALTER TABLE `suspensions` DISABLE KEYS */;
/*!40000 ALTER TABLE `suspensions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waits`
--

DROP TABLE IF EXISTS `waits`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `waits` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `trans_id` varchar(18) default NULL,
  `user_id` varchar(30) default NULL,
  `user_db` varchar(30) default NULL,
  `record_id` varchar(30) default NULL,
  `volume_id` varchar(30) default NULL,
  `object_db` varchar(30) default NULL,
  `date` varchar(14) default NULL,
  `confirmed_date` varchar(14) default NULL,
  `expiration_date` varchar(14) default NULL,
  `cancel_id` varchar(18) default NULL,
  `cancel_date` varchar(14) default NULL,
  `obs` varchar(300) default NULL,
  `profile_id` varchar(18) default NULL,
  `user_class` varchar(30) default NULL,
  `object_category` varchar(30) default NULL,
  `location` varchar(30) default NULL,
  `operator_id` varchar(30) default NULL,
  `historic` varchar(5) default NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `trans_id` (`trans_id`),
  KEY `trans_id_idx` (`trans_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `user_db_idx` (`user_db`),
  KEY `record_id_idx` (`record_id`),
  KEY `object_db_idx` (`object_db`),
  KEY `location_idx` (`location`),
  KEY `historic_idx` (`historic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `waits`
--

LOCK TABLES `waits` WRITE;
/*!40000 ALTER TABLE `waits` DISABLE KEYS */;
/*!40000 ALTER TABLE `waits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-07-23 15:31:53
