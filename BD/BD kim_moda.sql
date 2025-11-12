CREATE DATABASE  IF NOT EXISTS `kim_moda` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `kim_moda`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: kim_moda
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (4,'Ana','López','11112222','Calle Falsa 123','ana@example.com'),(5,'Carlos','Martínez','33334444','Av. Siempre Viva 742','carlos@example.com');
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
INSERT INTO `detalledeventas` VALUES (1,1,2),(1,3,1),(2,4,3),(2,5,2);
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
INSERT INTO `devoluciones` VALUES (2,1,'2025-06-05','7 días','Producto con defecto'),(3,2,'2025-06-18','5 días','Talle incorrecto');
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
-- Table structure for table `gastosextras`
--

DROP TABLE IF EXISTS `gastosextras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gastosextras` (
  `gasto_id` int NOT NULL AUTO_INCREMENT,
  `emp_id` int NOT NULL,
  `gasto_concepto` varchar(45) NOT NULL,
  `gasto_monto` decimal(10,2) NOT NULL,
  `gasto_fecha` date NOT NULL,
  PRIMARY KEY (`gasto_id`,`emp_id`),
  UNIQUE KEY `idGastosExtras_UNIQUE` (`gasto_id`),
  KEY `fk_gastosextras_empleados1_idx` (`emp_id`),
  CONSTRAINT `fk_gastosextras_empleados1` FOREIGN KEY (`emp_id`) REFERENCES `empleados` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gastosextras`
--

LOCK TABLES `gastosextras` WRITE;
/*!40000 ALTER TABLE `gastosextras` DISABLE KEYS */;
INSERT INTO `gastosextras` VALUES (6,10,'Arreglo mostrador',1200.00,'2025-06-10'),(7,12,'Papelería oficina',450.00,'2025-06-12'),(8,12,'Limpieza vidriera',600.00,'2025-06-20');
/*!40000 ALTER TABLE `gastosextras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imagenes` (
  `img_id` int NOT NULL AUTO_INCREMENT,
  `img_url` varchar(45) NOT NULL,
  PRIMARY KEY (`img_id`),
  UNIQUE KEY `idImagenes_UNIQUE` (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (1,'remera1.jpg'),(2,'pantalon1.jpg'),(3,'campera1.jpg');
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingresos`
--

DROP TABLE IF EXISTS `ingresos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingresos` (
  `prod_id` int NOT NULL,
  `prov_id` int NOT NULL,
  `ing_precio` decimal(10,2) NOT NULL,
  `ing_fecha` date NOT NULL,
  `ing_temporada` varchar(45) NOT NULL,
  PRIMARY KEY (`prod_id`,`prov_id`),
  KEY `fk_productos_has_proveedores_proveedores1_idx` (`prov_id`),
  KEY `fk_productos_has_proveedores_productos1_idx` (`prod_id`),
  CONSTRAINT `fk_productos_has_proveedores_productos1` FOREIGN KEY (`prod_id`) REFERENCES `productos` (`prod_id`),
  CONSTRAINT `fk_productos_has_proveedores_proveedores1` FOREIGN KEY (`prov_id`) REFERENCES `proveedores` (`prov_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingresos`
--

LOCK TABLES `ingresos` WRITE;
/*!40000 ALTER TABLE `ingresos` DISABLE KEYS */;
INSERT INTO `ingresos` VALUES (1,1,2500.00,'2025-03-01','Primavera'),(2,2,6000.00,'2025-02-15','Verano'),(3,2,12000.00,'2025-05-10','Invierno');
/*!40000 ALTER TABLE `ingresos` ENABLE KEYS */;
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
  `pedido_fecha` varchar(45) NOT NULL,
  `pedido_estado` varchar(45) NOT NULL,
  PRIMARY KEY (`pedido_id`,`cli_id`,`emp_id`),
  UNIQUE KEY `idPedidos_UNIQUE` (`pedido_id`),
  KEY `fk_pedidos_clientes_idx` (`cli_id`),
  KEY `fk_pedidos_empleados1_idx` (`emp_id`),
  CONSTRAINT `fk_pedidos_clientes` FOREIGN KEY (`cli_id`) REFERENCES `clientes` (`cli_id`),
  CONSTRAINT `fk_pedidos_empleados1` FOREIGN KEY (`emp_id`) REFERENCES `empleados` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,4,10,'2025-06-01','Entregado'),(2,5,11,'2025-06-15','En preparación');
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
  `prod_precio` decimal(10,2) NOT NULL,
  `img_id` int NOT NULL,
  PRIMARY KEY (`prod_id`,`cat_id`,`img_id`),
  UNIQUE KEY `idProductos_UNIQUE` (`prod_id`),
  KEY `fk_productos_categorias1_idx` (`cat_id`),
  KEY `fk_productos_imagenes1_idx` (`img_id`),
  CONSTRAINT `fk_productos_categorias1` FOREIGN KEY (`cat_id`) REFERENCES `categorias` (`cat_id`),
  CONSTRAINT `fk_productos_imagenes1` FOREIGN KEY (`img_id`) REFERENCES `imagenes` (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,1,'Camisa','Azul',10,'L','Manga larga',8500.00,1),(2,1,'Pantalón','Beige',8,'M','Casual',9200.00,1),(3,1,'Remera','Negro',15,'S','Dry-Fit',4800.00,1),(4,1,'Campera','Verde',6,'XL','Acolchada',14000.00,1),(5,1,'Short','Celeste',12,'M','Con bolsillos',4300.00,1),(6,2,'Blusa','Rosa',10,'M','Elegante',8700.00,2),(7,2,'Vestido','Rojo',5,'L','Corto',12000.00,2),(8,2,'Pantalón','Negro',9,'S','Ajustado',9600.00,2),(9,2,'Remera','Blanca',20,'M','Con diseño floral',5500.00,2),(10,2,'Campera','Azul',7,'L','Campera entallada',13500.00,2),(11,3,'Buzo','Gris',18,'L','Canguro',7800.00,3),(12,3,'Remera','Blanca',30,'M','De algodón',4200.00,3),(13,3,'Pantalón','Negro',16,'L','Jogger con puños',8900.00,3),(14,3,'Campera','Roja',9,'XL','Rompeviento',12500.00,3),(15,3,'Chaleco','Verde',5,'M','Sin mangas',9800.00,3),(16,3,'Gorro','Gris',25,'Único','Gorro tejido',2300.00,3),(17,3,'Camisa','Negro',10,'L','Lisa',7200.00,3),(18,3,'Remera','Multicolor',15,'M','Moderna',4900.00,3),(19,3,'Sudadera','Gris Oscuro',12,'L','Con capucha',8700.00,3),(20,3,'Campera','Azul Marino',8,'XL','Polar',14200.00,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores`
--

LOCK TABLES `proveedores` WRITE;
/*!40000 ALTER TABLE `proveedores` DISABLE KEYS */;
INSERT INTO `proveedores` VALUES (1,'María','Fernández','44445555','San Martín 500'),(2,'Pedro','Luna','55556666','Belgrano 999');
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

-- Dump completed on 2025-11-11 19:39:05
