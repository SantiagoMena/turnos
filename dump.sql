CREATE DATABASE  IF NOT EXISTS `turnos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `turnos`;
-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 206.189.221.160    Database: turnos
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.16.04.2

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
-- Table structure for table `administracion`
--

DROP TABLE IF EXISTS `administracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_secretaria_empresa1_idx` (`empresa_id`),
  KEY `fk_secretaria_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_secretaria_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administracion`
--

LOCK TABLES `administracion` WRITE;
/*!40000 ALTER TABLE `administracion` DISABLE KEYS */;
/*!40000 ALTER TABLE `administracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','21',1538743237),('administracion','23',1538747290),('administracion','25',1538751142),('administracion','33',1538757791),('administracion','36',1538974516),('administracion','38',1538974736),('administracion','48',1548935679),('administracion','49',1548936084),('administracion','61',1549684472),('empresa','14',1538743237),('empresa','24',1538751086),('empresa','26',1538754549),('empresa','28',1538754617),('empresa','30',1538754835),('empresa','31',1538754939),('empresa','32',1538757742),('empresa','39',1548811919),('empresa','41',1548812090),('empresa','42',1548905098),('empresa','44',1548935561),('empresa','50',1548938602),('empresa','52',1549592975),('empresa','58',1549595601),('empresa','59',1549595621),('empresa','60',1549684227),('empresa','62',1556509541),('empresa','63',1556894926),('empresa','64',1556986870),('empresa','65',1557002634),('empresa','66',1557029467),('empresa','67',1557031455);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,NULL,NULL,NULL,1538743063,1538743063),('administracion',1,NULL,NULL,NULL,1538743063,1538743063),('empresa',1,NULL,NULL,NULL,1538743063,1538743063);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria_empresa1_idx` (`empresa_id`),
  CONSTRAINT `fk_categoria_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (7,'Bicicletas Electricas',18),(8,'Bicicletas Electricas',19),(9,'servicio',20),(10,'Servicios en el punto de venta',22);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_reserva`
--

DROP TABLE IF EXISTS `config_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('Dias por semana','Rango de dias','Dias en especifico') DEFAULT NULL,
  `servicio_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`servicio_id`),
  KEY `fk_config_servicio_servicio1_idx` (`servicio_id`),
  CONSTRAINT `fk_config_servicio_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_reserva`
--

LOCK TABLES `config_reserva` WRITE;
/*!40000 ALTER TABLE `config_reserva` DISABLE KEYS */;
INSERT INTO `config_reserva` VALUES (6,'Dias por semana',19),(7,'Dias por semana',20),(8,'Dias por semana',21),(9,'Dias por semana',22),(10,'Dias por semana',23);
/*!40000 ALTER TABLE `config_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config_turno`
--

DROP TABLE IF EXISTS `config_turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_turno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desde` varchar(8) NOT NULL DEFAULT '00:00',
  `hasta` varchar(8) NOT NULL DEFAULT '23:59',
  `turno` tinyint(4) DEFAULT '0',
  `minutos_turno` int(11) DEFAULT NULL,
  `minutos_entre_turno` int(11) DEFAULT NULL,
  `cupos` int(11) DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_config_turno_empresa1_idx` (`empresa_id`),
  CONSTRAINT `fk_config_turno_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_turno`
--

LOCK TABLES `config_turno` WRITE;
/*!40000 ALTER TABLE `config_turno` DISABLE KEYS */;
INSERT INTO `config_turno` VALUES (1,'00:00 AM','00:00 PM',0,30,10,NULL,0),(2,'00:00','23:59',0,60,NULL,2,0),(3,'10:00','23:15',0,240,240,2,0),(4,'10:00','23:59',0,240,240,2,0),(5,'10:00','23:30',0,240,240,2,19),(6,'10:00','17:45',0,30,NULL,NULL,20),(7,'11:00','18:30',0,60,30,4,22),(8,'02:30','18:30',0,30,NULL,NULL,18);
/*!40000 ALTER TABLE `config_turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracion`
--

DROP TABLE IF EXISTS `configuracion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `turno_publico` tinyint(4) DEFAULT '1',
  `cancelar_turno` tinyint(4) DEFAULT '1',
  `reprogramar_turno` tinyint(4) DEFAULT '1',
  `correos` text,
  `adjunto_turno` tinyint(4) DEFAULT '0',
  `cualquier_horario` tinyint(4) DEFAULT '1',
  `cualquier_dia` tinyint(4) DEFAULT '1',
  `dias_especificos` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_configuracion_empresa1_idx` (`empresa_id`),
  CONSTRAINT `fk_configuracion_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion`
--

LOCK TABLES `configuracion` WRITE;
/*!40000 ALTER TABLE `configuracion` DISABLE KEYS */;
INSERT INTO `configuracion` VALUES (6,18,1,1,1,NULL,0,1,1,0);
/*!40000 ALTER TABLE `configuracion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dato`
--

DROP TABLE IF EXISTS `dato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `adjunto` varchar(255) DEFAULT NULL,
  `turno_id` int(11) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dato_turno1_idx` (`turno_id`),
  CONSTRAINT `fk_dato_turno1` FOREIGN KEY (`turno_id`) REFERENCES `turno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dato`
--

LOCK TABLES `dato` WRITE;
/*!40000 ALTER TABLE `dato` DISABLE KEYS */;
INSERT INTO `dato` VALUES (27,'95219474','Santiago Mena','1111111111','santiagomenape@gmail.com',NULL,'',51,NULL,NULL,NULL,NULL,NULL,NULL),(28,'95219474','Santiago Mena','1111111111','santiagomenape@gmail.com',NULL,'',52,NULL,NULL,NULL,NULL,NULL,NULL),(29,'123123','test','1111111111','santiagomenape@gmail.com',NULL,'',53,NULL,NULL,NULL,NULL,NULL,NULL),(30,'111111','Cliente','11111111','cliente@nuevo.com',NULL,'',54,NULL,NULL,NULL,NULL,NULL,NULL),(31,'1111111','Nombre','123456','santiagomenape@gamil.com',NULL,'',55,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dato_necesario`
--

DROP TABLE IF EXISTS `dato_necesario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dato_necesario` (
  `config_turno_id` int(11) NOT NULL,
  `documento` tinyint(4) DEFAULT NULL,
  `nombre` tinyint(4) DEFAULT NULL,
  `telefono` tinyint(4) DEFAULT NULL,
  `correo` tinyint(4) DEFAULT NULL,
  `cargo` tinyint(4) DEFAULT NULL,
  `adjunto` tinyint(4) DEFAULT NULL,
  `direccion` tinyint(4) DEFAULT NULL,
  `celular` tinyint(4) DEFAULT NULL,
  `whatsapp` tinyint(4) DEFAULT NULL,
  `pais` tinyint(4) DEFAULT NULL,
  `ciudad` tinyint(4) DEFAULT NULL,
  `localidad` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`config_turno_id`),
  CONSTRAINT `fk_dato_necesario_config_turno1` FOREIGN KEY (`config_turno_id`) REFERENCES `config_turno` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dato_necesario`
--

LOCK TABLES `dato_necesario` WRITE;
/*!40000 ALTER TABLE `dato_necesario` DISABLE KEYS */;
/*!40000 ALTER TABLE `dato_necesario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dia_especifico_reserva`
--

DROP TABLE IF EXISTS `dia_especifico_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dia_especifico_reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_turno_id` int(11) DEFAULT NULL,
  `config_reserva_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dia_especifico_reserva_config_turno1_idx` (`config_turno_id`),
  KEY `fk_dia_especifico_reserva_config_reserva1_idx` (`config_reserva_id`),
  CONSTRAINT `fk_dia_especifico_reserva_config_reserva1` FOREIGN KEY (`config_reserva_id`) REFERENCES `config_reserva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dia_especifico_reserva_config_turno1` FOREIGN KEY (`config_turno_id`) REFERENCES `config_turno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dia_especifico_reserva`
--

LOCK TABLES `dia_especifico_reserva` WRITE;
/*!40000 ALTER TABLE `dia_especifico_reserva` DISABLE KEYS */;
/*!40000 ALTER TABLE `dia_especifico_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dia_habil`
--

DROP TABLE IF EXISTS `dia_habil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dia_habil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dia_habil_empresa1_idx` (`empresa_id`),
  CONSTRAINT `fk_dia_habil_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dia_habil`
--

LOCK TABLES `dia_habil` WRITE;
/*!40000 ALTER TABLE `dia_habil` DISABLE KEYS */;
/*!40000 ALTER TABLE `dia_habil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dia_habil_has_franja_horaria`
--

DROP TABLE IF EXISTS `dia_habil_has_franja_horaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dia_habil_has_franja_horaria` (
  `dia_habil_id` int(11) NOT NULL,
  `franja_horaria_id` int(11) NOT NULL,
  PRIMARY KEY (`dia_habil_id`,`franja_horaria_id`),
  KEY `fk_dia_habil_has_franja_horaria_franja_horaria1_idx` (`franja_horaria_id`),
  KEY `fk_dia_habil_has_franja_horaria_dia_habil1_idx` (`dia_habil_id`),
  CONSTRAINT `fk_dia_habil_has_franja_horaria_dia_habil1` FOREIGN KEY (`dia_habil_id`) REFERENCES `dia_habil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dia_habil_has_franja_horaria_franja_horaria1` FOREIGN KEY (`franja_horaria_id`) REFERENCES `franja_horaria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dia_habil_has_franja_horaria`
--

LOCK TABLES `dia_habil_has_franja_horaria` WRITE;
/*!40000 ALTER TABLE `dia_habil_has_franja_horaria` DISABLE KEYS */;
/*!40000 ALTER TABLE `dia_habil_has_franja_horaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dia_turno`
--

DROP TABLE IF EXISTS `dia_turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dia_turno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` enum('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo') DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dia_turno_empresa1_idx` (`empresa_id`),
  CONSTRAINT `fk_dia_turno_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dia_turno`
--

LOCK TABLES `dia_turno` WRITE;
/*!40000 ALTER TABLE `dia_turno` DISABLE KEYS */;
/*!40000 ALTER TABLE `dia_turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `nit` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empresa_usuario1_idx` (`usuario_id`),
  CONSTRAINT `fk_empresa_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (18,'desligar.me',NULL,'quiero@desligar.me',NULL,NULL,'TMCGIPUbB2j7_-fPa0rRbbRkB7xpBdUT.png',63),(19,'Eco Tenderos',NULL,'santiago@contenidos-digitales.com',NULL,NULL,'4e0GxAkk_DgToXdfdIPnLwCy3rFGt35Q.png',64),(20,'daniel',NULL,'danielfmenap@gmail.com',NULL,NULL,'',65),(21,'Empresa Nueva',NULL,'empresa@nueva.com',NULL,NULL,'',66),(22,'Empresa Nueva',NULL,'empresa3@nueva.com',NULL,NULL,'_6FzeWOaTJIme57ZKiM_aJrFepRAtymx.png',67);
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `franja_horaria`
--

DROP TABLE IF EXISTS `franja_horaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `franja_horaria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) NOT NULL,
  `desde` varchar(8) NOT NULL DEFAULT '00:00 AM',
  `hasta` varchar(8) NOT NULL DEFAULT '00:00 PM',
  `tiene_turnos` tinyint(4) DEFAULT '0',
  `minutos_turno` int(11) DEFAULT '0',
  `tiene_limpieza` tinyint(4) DEFAULT '0',
  `tiempo_limpieza` int(11) DEFAULT '0',
  `cupos` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_franja_horaria_empresa1_idx` (`empresa_id`),
  CONSTRAINT `fk_franja_horaria_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `franja_horaria`
--

LOCK TABLES `franja_horaria` WRITE;
/*!40000 ALTER TABLE `franja_horaria` DISABLE KEYS */;
/*!40000 ALTER TABLE `franja_horaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `franja_horaria_has_dia_turno`
--

DROP TABLE IF EXISTS `franja_horaria_has_dia_turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `franja_horaria_has_dia_turno` (
  `franja_horaria_id` int(11) NOT NULL,
  `dia_turno_id` int(11) NOT NULL,
  PRIMARY KEY (`franja_horaria_id`,`dia_turno_id`),
  KEY `fk_franja_horaria_has_dia_turno_dia_turno1_idx` (`dia_turno_id`),
  KEY `fk_franja_horaria_has_dia_turno_franja_horaria1_idx` (`franja_horaria_id`),
  CONSTRAINT `fk_franja_horaria_has_dia_turno_dia_turno1` FOREIGN KEY (`dia_turno_id`) REFERENCES `dia_turno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_franja_horaria_has_dia_turno_franja_horaria1` FOREIGN KEY (`franja_horaria_id`) REFERENCES `franja_horaria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `franja_horaria_has_dia_turno`
--

LOCK TABLES `franja_horaria_has_dia_turno` WRITE;
/*!40000 ALTER TABLE `franja_horaria_has_dia_turno` DISABLE KEYS */;
/*!40000 ALTER TABLE `franja_horaria_has_dia_turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link`
--

DROP TABLE IF EXISTS `link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `visitas` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link`
--

LOCK TABLES `link` WRITE;
/*!40000 ALTER TABLE `link` DISABLE KEYS */;
INSERT INTO `link` VALUES (1,'http://google.com',4);
/*!40000 ALTER TABLE `link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1538713175),('m140209_132017_init',1538713177),('m140403_174025_create_account_table',1538713177),('m140504_113157_update_tables',1538713178),('m140504_130429_create_token_table',1538713178),('m140506_102106_rbac_init',1538722514),('m140830_171933_fix_ip_field',1538713178),('m140830_172703_change_account_table_name',1538713178),('m141222_110026_update_ip_field',1538713178),('m141222_135246_alter_username_length',1538713178),('m150614_103145_update_social_account_table',1538713178),('m150623_212711_fix_username_notnull',1538713178),('m151218_234654_add_timezone_to_profile',1538713178),('m160929_103127_add_last_login_at_to_user_table',1538713178),('m170907_052038_rbac_add_index_on_auth_assignment_user_id',1538722514);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (21,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(63,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(64,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(65,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(66,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(67,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rango_reserva`
--

DROP TABLE IF EXISTS `rango_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rango_reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_reserva_id` int(11) NOT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `config_turno_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rango_reserva_config_reserva1_idx` (`config_reserva_id`),
  KEY `fk_rango_reserva_config_turno1_idx` (`config_turno_id`),
  CONSTRAINT `fk_rango_reserva_config_reserva1` FOREIGN KEY (`config_reserva_id`) REFERENCES `config_reserva` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_rango_reserva_config_turno1` FOREIGN KEY (`config_turno_id`) REFERENCES `config_turno` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rango_reserva`
--

LOCK TABLES `rango_reserva` WRITE;
/*!40000 ALTER TABLE `rango_reserva` DISABLE KEYS */;
/*!40000 ALTER TABLE `rango_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva_turno`
--

DROP TABLE IF EXISTS `reserva_turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva_turno` (
  `id` int(11) NOT NULL,
  `desde` datetime DEFAULT NULL,
  `hasta` varchar(45) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Confirmado','Cancelado','Activo','Concluido','Reprogramado','Eliminado') NOT NULL DEFAULT 'Pendiente',
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva_turno`
--

LOCK TABLES `reserva_turno` WRITE;
/*!40000 ALTER TABLE `reserva_turno` DISABLE KEYS */;
/*!40000 ALTER TABLE `reserva_turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reserva_turno_historial`
--

DROP TABLE IF EXISTS `reserva_turno_historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reserva_turno_historial` (
  `version` int(11) NOT NULL,
  `desde` datetime DEFAULT NULL,
  `hasta` varchar(45) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Confirmado','Cancelado','Activo','Concluido','Reprogramado') NOT NULL DEFAULT 'Pendiente',
  `fecha_modificacion` datetime DEFAULT NULL,
  `reserva_turno_id` int(11) NOT NULL,
  PRIMARY KEY (`version`),
  KEY `fk_reserva_turno_historial_reserva_turno1_idx` (`reserva_turno_id`),
  CONSTRAINT `fk_reserva_turno_historial_reserva_turno1` FOREIGN KEY (`reserva_turno_id`) REFERENCES `reserva_turno` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reserva_turno_historial`
--

LOCK TABLES `reserva_turno_historial` WRITE;
/*!40000 ALTER TABLE `reserva_turno_historial` DISABLE KEYS */;
/*!40000 ALTER TABLE `reserva_turno_historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semana_reserva`
--

DROP TABLE IF EXISTS `semana_reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semana_reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lunes` tinyint(4) DEFAULT '0',
  `martes` tinyint(4) DEFAULT '0',
  `miercoles` tinyint(4) DEFAULT '0',
  `jueves` tinyint(4) DEFAULT '0',
  `viernes` tinyint(4) DEFAULT '0',
  `sabado` tinyint(4) DEFAULT '0',
  `domingo` tinyint(4) DEFAULT '0',
  `config_reserva_id` int(11) NOT NULL,
  `config_turno_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_semana_config_turno1_idx` (`config_turno_id`),
  KEY `fk_semana_config_reserva1_idx` (`config_reserva_id`),
  CONSTRAINT `fk_semana_config_reserva1` FOREIGN KEY (`config_reserva_id`) REFERENCES `config_reserva` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_semana_config_turno1` FOREIGN KEY (`config_turno_id`) REFERENCES `config_turno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semana_reserva`
--

LOCK TABLES `semana_reserva` WRITE;
/*!40000 ALTER TABLE `semana_reserva` DISABLE KEYS */;
INSERT INTO `semana_reserva` VALUES (2,1,0,1,0,1,0,1,4,2),(3,1,1,1,1,NULL,NULL,NULL,5,3),(4,1,NULL,1,NULL,1,NULL,1,6,4),(5,1,1,1,1,1,NULL,NULL,7,5),(6,1,1,1,1,1,NULL,NULL,8,6),(7,1,1,1,NULL,1,1,NULL,9,7),(8,1,1,1,NULL,NULL,NULL,NULL,10,8);
/*!40000 ALTER TABLE `semana_reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `habil_desde` datetime DEFAULT NULL,
  `habil_hasta` datetime DEFAULT NULL,
  `siempre_habil` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_servicio_categoria1_idx` (`categoria_id`),
  CONSTRAINT `fk_servicio_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
INSERT INTO `servicio` VALUES (19,'Alquiler por turnos',7,NULL,NULL,1),(20,'Alquiler por turno',8,NULL,NULL,1),(21,'servicio 1',9,NULL,NULL,1),(22,'Servicio de posventa',10,'2019-05-05 10:30:00','2019-12-23 17:00:00',0),(23,'Servicio nuevo',7,'2019-05-10 01:30:00','2019-05-31 23:30:00',0);
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_account`
--

DROP TABLE IF EXISTS `social_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_account`
--

LOCK TABLES `social_account` WRITE;
/*!40000 ALTER TABLE `social_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
INSERT INTO `token` VALUES (21,'CdZwPRwZtQeI6lPtsO4dqn2ohjgyH2K9',1538745092,0),(64,'fbnlJy2ONR0RThJL3Fb1M1AJuLCHGnuH',1557861930,1),(67,'MstIAv0Jpcc_-meMyO4jgSEBnfz4pM6f',1557033331,2);
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turno`
--

DROP TABLE IF EXISTS `turno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `estado` enum('Pendiente','Confirmado','Cancelado','Activo','Concluido','Reprogramado') NOT NULL DEFAULT 'Pendiente',
  `fecha_modificacion` datetime DEFAULT NULL,
  `desde` datetime NOT NULL,
  `hasta` datetime NOT NULL,
  `servicio_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_turno_servicio1_idx` (`servicio_id`),
  KEY `fk_turno_empresa1_idx` (`empresa_id`),
  CONSTRAINT `fk_turno_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_turno_servicio1` FOREIGN KEY (`servicio_id`) REFERENCES `servicio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turno`
--

LOCK TABLES `turno` WRITE;
/*!40000 ALTER TABLE `turno` DISABLE KEYS */;
INSERT INTO `turno` VALUES (51,'b4dcb084fd68c82f42cab8048a097fde','Pendiente',NULL,'2019-05-08 18:00:00','2019-05-08 22:00:00',20,19),(52,'c0d986dae8369d3011399ec2677bb8ee','Pendiente',NULL,'2019-05-08 18:00:00','2019-05-08 22:00:00',20,19),(53,'7e109c36202ea8ac19bffdfd7f750705','Pendiente',NULL,'2019-05-06 12:00:00','2019-05-06 12:30:00',21,20),(54,'7bcd5a90220c80e6d8a2146528910829','Pendiente',NULL,'2019-05-21 11:00:00','2019-05-21 12:00:00',22,22),(55,'d76255061665d5498b2c97f003eafc48','Pendiente',NULL,'2019-05-10 10:00:00','2019-05-10 14:00:00',19,18);
/*!40000 ALTER TABLE `turno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (21,'santiago','santiagomenape@gmail.com','$2y$10$Z6O/SYErPqdM7hcYHPM3KexJzHs6Jb7PnS.U35JZqC3b5axnrO30q','77gqOYDxjV21Uuot7p3tcJ5W8p1Z8TN2',NULL,NULL,NULL,'::1',1538745092,1538745092,0,1571004582),(63,'desligar.me','quiero@desligar.me','$2y$10$KYJy9Luw8JySxhKGdjRwmOpsdO/WPhJjbr.wIT9WON8Jx3d3wWc/.','0YVxx1_OSDwtAR17x48Ob31htNpP3fje',NULL,NULL,NULL,'190.194.175.20',1556894926,1556894926,0,1589488209),(64,'ecotenderos','santiago@contenidos-digitales.com','$2y$10$JlN1U69iEOcejzdjIIu6juRmwTlnbvufsE4zNMHZRRgmVb8pXA1sO','26Q4TdNiPDpiGTp3HCucDT0TIYPi7MOj',1556986868,NULL,NULL,'190.194.175.20',1556986869,1556986869,0,1556986883),(65,'daniel','danielfmenap@gmail.com','$2y$10$mMGXNBlWErK7Lr4tC/AyROUePaWkzuP3HBNM9rtsYsVv/wTP1RmFq','5iW02pNEAzhfeIHPuoSyu97FLz7fPzgc',1557002632,NULL,NULL,'190.194.175.20',1557002632,1557002632,0,1557002644),(66,'empresanueva','empresa@nueva.com','$2y$10$oYnyk0jGT/D7TQ8OrN4w5.Zc0XCIPFlgfG/HyjL/Sv6r9EvUkyGoG','7NRnnLWbmQ6g34vGkVgT1IADTDAvQhM0',1557029465,NULL,NULL,'190.194.175.20',1557029465,1557029465,0,1557029479),(67,'empresatres','empresa3@nueva.com','$2y$10$x1e.MDABaj1NPi6cJzejAeeb6xBPyhbN1Gr5tzFJq8IqIDpKFSzQe','F9w2lFQ8OfPBlNPMsSF16fuR9uX4N-Qa',1557031453,'empresatres@nueva.com',NULL,'190.194.175.20',1557031454,1557033333,0,1557031460);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_usuario_user1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (63,NULL,NULL,'quiero@desligar.me'),(64,NULL,NULL,'santiago@contenidos-digitales.com'),(65,NULL,NULL,'danielfmenap@gmail.com'),(66,NULL,NULL,'empresa@nueva.com'),(67,NULL,NULL,'empresa3@nueva.com');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-08 16:19:47
