CREATE DATABASE  IF NOT EXISTS `kim_moda` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kim_moda`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: kim_moda
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `cat_id` int NOT NULL AUTO_INCREMENT,
  `cat_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `idCategorias_UNIQUE` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Masculino'),(2,'Femenino'),(3,'Unisex');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clientes` (
  `cli_id` int NOT NULL AUTO_INCREMENT,
  `cli_nombre` varchar(45) NOT NULL,
  `cli_apellido` varchar(45) NOT NULL,
  `cli_tel` varchar(45) NOT NULL,
  `cli_domicilio` varchar(50) NOT NULL,
  `cli_email` varchar(50) NOT NULL,
  PRIMARY KEY (`cli_id`),
  UNIQUE KEY `idClientes_UNIQUE` (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (4,'Samuel','López','2224','Calle Falsa 123','ana@example.com'),(5,'Carlos','Martínez','33334444','Av. Siempre Viva 742','carlos@example.com'),(6,'Normando','Bur','38958339u3','El potrero','normandoburgos20@gmail.com');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalledeventas`
--

DROP TABLE IF EXISTS `detalledeventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalledeventas` (
  `pedido_id` int NOT NULL,
  `prod_id` int NOT NULL,
  `cantidad` int NOT NULL,
  PRIMARY KEY (`pedido_id`,`prod_id`),
  KEY `fk_pedidos_has_productos_productos1_idx` (`prod_id`),
  KEY `fk_pedidos_has_productos_pedidos1_idx` (`pedido_id`),
  CONSTRAINT `fk_pedidos_has_productos_pedidos1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`),
  CONSTRAINT `fk_pedidos_has_productos_productos1` FOREIGN KEY (`prod_id`) REFERENCES `productos` (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalledeventas`
--

LOCK TABLES `detalledeventas` WRITE;
/*!40000 ALTER TABLE `detalledeventas` DISABLE KEYS */;
INSERT INTO `detalledeventas` VALUES (29,84,1),(30,81,1),(30,83,1),(30,84,1),(32,77,1),(33,77,1);
/*!40000 ALTER TABLE `detalledeventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devoluciones`
--

DROP TABLE IF EXISTS `devoluciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `devoluciones` (
  `dev_id` int NOT NULL AUTO_INCREMENT,
  `pedido_id` int NOT NULL,
  `dev_fecha` date NOT NULL,
  `dev_plazo` varchar(45) NOT NULL,
  `dev_motivo` varchar(45) NOT NULL,
  PRIMARY KEY (`dev_id`,`pedido_id`),
  UNIQUE KEY `idDevoluciones_UNIQUE` (`dev_id`),
  KEY `fk_devoluciones_pedidos1_idx` (`pedido_id`),
  CONSTRAINT `fk_devoluciones_pedidos1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devoluciones`
--

LOCK TABLES `devoluciones` WRITE;
/*!40000 ALTER TABLE `devoluciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `devoluciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleados`
--

DROP TABLE IF EXISTS `empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleados` (
  `emp_id` int NOT NULL AUTO_INCREMENT,
  `fun_id` int NOT NULL,
  `emp_nombre` varchar(45) NOT NULL,
  `emp_apellido` varchar(45) NOT NULL,
  `emp_usuario` varchar(45) NOT NULL,
  `emp_contrasenia` varchar(45) NOT NULL,
  `emp_telefono` varchar(45) NOT NULL,
  `emp_sueldo` decimal(10,2) NOT NULL,
  PRIMARY KEY (`emp_id`,`fun_id`),
  UNIQUE KEY `idnew_table_UNIQUE` (`emp_id`),
  KEY `fk_empleados_funciones1_idx` (`fun_id`),
  CONSTRAINT `fk_empleados_funciones1` FOREIGN KEY (`fun_id`) REFERENCES `funciones` (`fun_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleados`
--

LOCK TABLES `empleados` WRITE;
/*!40000 ALTER TABLE `empleados` DISABLE KEYS */;
INSERT INTO `empleados` VALUES (10,3,'Yanet','Gutierrez','yan','1234','3874567890',50000.00),(11,4,'Maribel','Gutierrez','mari','mari10','3877654321',40000.00),(12,4,'Yanet','Gutierrez','yan12','6789','3874567890',50000.00);
/*!40000 ALTER TABLE `empleados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funciones`
--

DROP TABLE IF EXISTS `funciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funciones` (
  `fun_id` int NOT NULL AUTO_INCREMENT,
  `fun_descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`fun_id`),
  UNIQUE KEY `idFunciones_UNIQUE` (`fun_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funciones`
--

LOCK TABLES `funciones` WRITE;
/*!40000 ALTER TABLE `funciones` DISABLE KEYS */;
INSERT INTO `funciones` VALUES (3,'Administrador'),(4,'Vendedor');
/*!40000 ALTER TABLE `funciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes` (
  `img_id` int NOT NULL AUTO_INCREMENT,
  `img_ruta` varchar(255) NOT NULL,
  `prod_id` int NOT NULL,
  PRIMARY KEY (`img_id`,`prod_id`),
  UNIQUE KEY `idImagenes_UNIQUE` (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (1,'remera.jpeg',0),(2,'jeans.jpeg',0),(3,'blusa.jpeg',0),(5,'1766357930_remera.jpeg',80),(6,'1766360334_jeans.jpeg',81),(7,'1766360437_remeraRojaHombre.jpg',80),(9,'1771540218_PantalonHombreNegro.jpg',82),(11,'1771797514_buzoBlanco.jpg',84),(14,'1771875146_pantalonjeansazul2.jpg',81),(15,'1771876160_BuzoBlanco1.jpg',84),(17,'1771876845_PantalonMujer1.jpeg',77),(18,'1771876940_PantalonMujer.jpeg',77),(19,'1771877049_1771792781_Argentina1.jpeg',83),(20,'1771877153_Argentina2.jpeg',83),(21,'1771877603_Falda.jpeg',85),(22,'1771877649_faldagris1.jpg',85);
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `pedido_id` int NOT NULL AUTO_INCREMENT,
  `cli_id` int NOT NULL,
  `emp_id` int NOT NULL,
  `pedido_fecha` date NOT NULL,
  `pedido_estado` varchar(45) NOT NULL,
  `pedido_medio_pago` varchar(45) NOT NULL,
  PRIMARY KEY (`pedido_id`,`cli_id`,`emp_id`),
  UNIQUE KEY `idPedidos_UNIQUE` (`pedido_id`),
  KEY `fk_pedidos_clientes_idx` (`cli_id`),
  KEY `fk_pedidos_empleados1_idx` (`emp_id`),
  CONSTRAINT `fk_pedidos_clientes` FOREIGN KEY (`cli_id`) REFERENCES `clientes` (`cli_id`),
  CONSTRAINT `fk_pedidos_empleados1` FOREIGN KEY (`emp_id`) REFERENCES `empleados` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (29,4,10,'2026-02-22','Entregado','Efectivo'),(30,6,10,'2026-02-22','Entregado','Efectivo'),(32,4,10,'2026-02-23','Anulado','Efectivo'),(33,6,10,'2026-02-23','Anulado','Efectivo');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `prod_id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `prod_nombre` varchar(45) NOT NULL,
  `prod_color` varchar(45) NOT NULL,
  `prod_stock` int NOT NULL,
  `prod_talle` varchar(45) NOT NULL,
  `prod_descripcion` varchar(45) NOT NULL,
  `prod_precio` float NOT NULL,
  PRIMARY KEY (`prod_id`,`cat_id`),
  UNIQUE KEY `idProductos_UNIQUE` (`prod_id`),
  KEY `fk_productos_categorias1_idx` (`cat_id`),
  CONSTRAINT `fk_productos_categorias1` FOREIGN KEY (`cat_id`) REFERENCES `categorias` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (77,2,'Pantalón','negro',5,'38','jeans',25000),(81,1,'Pantalón','azul',2,'38','Jeans',30000),(83,1,'Remera','azul',4,'M','de Argentina',15000),(84,2,'buzo','blanco',2,'S','algodon',34000),(85,2,'falda','gris',5,'L','de lino',20000);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedores` (
  `prov_id` int NOT NULL AUTO_INCREMENT,
  `prov_nombre` varchar(45) NOT NULL,
  `prov_apellido` varchar(45) NOT NULL,
  `prov_telefono` varchar(45) NOT NULL,
  `prov_direccion` varchar(100) NOT NULL,
  PRIMARY KEY (`prov_id`),
  UNIQUE KEY `idnew_table_UNIQUE` (`prov_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (2,'Pedro','Luna','3875183489','Belgrano 999'),(5,'Maribel','Sanchez','11112222','Payogasta');
/*!40000 ALTER TABLE `proveedores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-23 22:00:35
