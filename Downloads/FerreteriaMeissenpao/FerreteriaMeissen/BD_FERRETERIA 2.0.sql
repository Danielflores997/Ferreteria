/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.28-MariaDB : Database - ferreterianuevo
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ferreterianuevo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `ferreterianuevo`;

/*Table structure for table `categoria` */

DROP TABLE IF EXISTS `categoria`;

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCategoria` varchar(100) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `categoria` */

insert  into `categoria`(`idCategoria`,`nombreCategoria`) values (1,'HERRAMIENTAS'),(2,'PINTURAS'),(3,'CEMENTOS'),(4,'HERRAMIENTAS ELECTRICAS'),(5,'CARPINTERIA'),(6,'TORNILLLERIA'),(7,'PLOMERIA');

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `tipoDocumentoCliente` enum('CC','TI','CE') NOT NULL DEFAULT 'CC',
  `documentoCliente` varchar(20) NOT NULL,
  `nombresCliente` varchar(100) NOT NULL,
  `apellidosCliente` varchar(100) NOT NULL,
  `telefonoCliente` varchar(20) NOT NULL,
  `direccionCliente` varchar(100) NOT NULL,
  `passwordCliente` varchar(120) NOT NULL,
  `estadoCliente` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cliente` */

insert  into `cliente`(`idCliente`,`tipoDocumentoCliente`,`documentoCliente`,`nombresCliente`,`apellidosCliente`,`telefonoCliente`,`direccionCliente`,`passwordCliente`,`estadoCliente`) values (1,'CC','123456789','Juan','Pérez','1234567890','Calle 123, Ciudad','Hc#73$pl','Activo'),(2,'CC','987654321','María','Gómez','9876543210','Carrera 456, Ciudad','Kx%29&m@','Inactivo'),(3,'CC','246813579','Carlos','López','2468135790','Avenida 789, Ciudad','Zs@68*kd','Activo'),(4,'CC','135792468','Laura','Rodríguez','1357924680','Calle 567, Ciudad','Bp$82!cd','Activo'),(5,'CC','864209753','Ana','Ramírez','8642097530','Carrera 890, Ciudad','Mq$75&kd','Inactivo'),(6,'CC','579642813','Andrés','Sánchez','5796428130','Avenida 1234, Ciudad','Fg*63$lp','Activo'),(7,'CC','310725846','Sofía','Torres','3107258460','Calle 5678, Ciudad','Rj&19#vp','Inactivo'),(8,'CC','951462807','Alejandro','Castro','9514628070','Carrera 9012, Ciudad','Cx#27$lq','Activo'),(9,'CC','207536184','Andrea','Morales','2075361840','Avenida 3456, Ciudad','Dn$41@hr','Inactivo'),(10,'CC','468175923','David','Jiménez','4681759230','Calle 7890, Ciudad','Vz#82$qm','Activo'),(11,'CC','726943851','Natalia','Herrera','7269438510','Carrera 12345, Ciudad','Jt$94&sm','Inactivo'),(12,'CC','358291674','Roberto','Ortega','3582916740','Avenida 67890, Ciudad','Pk#37&bw','Activo'),(13,'CC','612835947','Carolina','Vargas','6128359470','Calle 12345, Ciudad','Sg%61#np','Activo'),(14,'CC','973461528','Luis','Castro','9734615280','Carrera 67890, Ciudad','Lw%73#hk','Inactivo'),(15,'CC','245890173','Laura','Molina','2458901730','Avenida 123456, Ciudad	','Gp#59!bm','Activo'),(16,'CC','481357926','José','Ríos','4813579260','Calle 789012, Ciudad','Yx$31%vd','Inactivo'),(17,'CC','936427510','Daniela','Guzmán','9364275100','Carrera 345678, Ciudad','Lt%68&vn','Activo'),(18,'CC','719264583','Pedro','Silva','7192645830','Avenida 901234, Ciudad','Qw#92%zc','Inactivo'),(19,'CC','582037196','Laura','Medina','5820371960','Calle 567890, Ciudad','Hn#36!xk','Activo'),(20,'CC','205819347','Andrés','Rojas','2058193470','Carrera 1234567, Ciudad','Tk#57&bf','Inactivo');

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `idCompra` int(11) NOT NULL AUTO_INCREMENT,
  `productos_idProducto` int(11) NOT NULL,
  `proveedor_idProveedor` int(11) NOT NULL,
  `fechaCompra` date NOT NULL,
  `valorCompra` varchar(45) NOT NULL,
  `cantidadCompra` varchar(45) NOT NULL,
  PRIMARY KEY (`idCompra`),
  KEY `productos_idProducto` (`productos_idProducto`),
  KEY `proveedor_idProveedor` (`proveedor_idProveedor`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`productos_idProducto`) REFERENCES `productos` (`idProducto`),
  CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`proveedor_idProveedor`) REFERENCES `proveedor` (`idProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compras` */

insert  into `compras`(`idCompra`,`productos_idProducto`,`proveedor_idProveedor`,`fechaCompra`,`valorCompra`,`cantidadCompra`) values (1,5,4,'2023-01-05','$150,000','10'),(2,7,3,'2023-02-12','$85,000	','5'),(3,1,7,'2023-03-20','$220,000','15'),(4,7,5,'2023-04-10','$45,000','2'),(5,2,1,'2023-05-01','$320,000','8'),(6,4,2,'2023-06-18','$75,000','6'),(7,20,8,'2023-07-09','$180,000','12'),(8,15,6,'2023-08-14','$90,000','4'),(9,4,9,'2023-09-22','$200,000','9'),(10,18,9,'2023-10-07','$55,000','3'),(11,17,6,'2023-11-19','$300,000','10'),(12,12,10,'2023-10-07','$55,000','3'),(13,25,4,'2023-11-19','$300,000','10'),(14,19,2,'2023-12-03','$65,000','5'),(15,22,7,'2024-03-14','$150,000','5'),(16,18,1,'2024-04-25','$280,000','12'),(17,6,14,'2024-05-06','$95,000','4'),(18,8,12,'2024-05-06','$230,000','10'),(19,8,5,'2024-07-02','$70,000','6'),(20,18,4,'2024-08-16','$160,000','8'),(21,24,10,'2024-09-28','$45,000','2'),(22,17,4,'2024-10-15','$130,000','7'),(23,19,7,'2024-11-29','$75,000','4'),(24,4,15,'2024-12-07','$180,000','9'),(25,25,4,'2025-01-18','$95,000','6'),(26,2,10,'2025-02-03','$200,000','10'),(27,18,3,'2025-03-16','$50,000','3'),(28,20,7,'2025-04-25','$160,000','8'),(29,10,6,'2025-05-10','$75,000','4'),(30,14,9,'2025-06-23','$210,000','12');

/*Table structure for table `detallefactura` */

DROP TABLE IF EXISTS `detallefactura`;

CREATE TABLE `detallefactura` (
  `idDetalleFactura` int(11) NOT NULL AUTO_INCREMENT,
  `factura_idFactura` int(11) NOT NULL,
  `productos_idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valorProductoVenta` decimal(10,0) NOT NULL,
  `totalDetalle` decimal(10,0) NOT NULL,
  PRIMARY KEY (`idDetalleFactura`),
  KEY `factura_idFactura` (`factura_idFactura`),
  KEY `productos_idProducto` (`productos_idProducto`),
  CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`factura_idFactura`) REFERENCES `factura` (`idFactura`),
  CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`productos_idProducto`) REFERENCES `productos` (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detallefactura` */

insert  into `detallefactura`(`idDetalleFactura`,`factura_idFactura`,`productos_idProducto`,`cantidad`,`valorProductoVenta`,`totalDetalle`) values (1,1,5,2,25000,50000),(2,1,1,1,15000,15000);

/*Table structure for table `detallepedido` */

DROP TABLE IF EXISTS `detallepedido`;

CREATE TABLE `detallepedido` (
  `idDetallePedido` int(11) NOT NULL AUTO_INCREMENT,
  `cantidadPedido` int(11) NOT NULL,
  `producto_idProducto` int(11) NOT NULL,
  `totalDetallePedido` decimal(10,0) NOT NULL,
  `pedido_idPedido` int(11) NOT NULL,
  PRIMARY KEY (`idDetallePedido`),
  KEY `pedido_idPedido` (`pedido_idPedido`),
  KEY `producto_idProducto` (`producto_idProducto`),
  CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`pedido_idPedido`) REFERENCES `pedido` (`idPedido`),
  CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`producto_idProducto`) REFERENCES `productos` (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `detallepedido` */

insert  into `detallepedido`(`idDetallePedido`,`cantidadPedido`,`producto_idProducto`,`totalDetallePedido`,`pedido_idPedido`) values (1,3,1,58999,1),(2,2,5,650000,1);

/*Table structure for table `factura` */

DROP TABLE IF EXISTS `factura`;

CREATE TABLE `factura` (
  `idFactura` int(11) NOT NULL AUTO_INCREMENT,
  `fechaFactura` date NOT NULL,
  `subtotalfactura` decimal(10,0) NOT NULL,
  `impuesto` int(11) NOT NULL,
  `valorTotalFactura` decimal(10,0) NOT NULL,
  `cliente_idCliente` int(11) NOT NULL,
  `usuario_idUsuario` int(11) NOT NULL,
  `pedido_idPedido` int(11) DEFAULT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `cliente_idCliente` (`cliente_idCliente`),
  KEY `usuario_idUsuario` (`usuario_idUsuario`),
  KEY `pedido_idPedido` (`pedido_idPedido`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cliente_idCliente`) REFERENCES `cliente` (`idCliente`),
  CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`pedido_idPedido`) REFERENCES `pedido` (`idPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `factura` */

insert  into `factura`(`idFactura`,`fechaFactura`,`subtotalfactura`,`impuesto`,`valorTotalFactura`,`cliente_idCliente`,`usuario_idUsuario`,`pedido_idPedido`) values (1,'2023-06-11',258900,15,890000,12,1,1);

/*Table structure for table `pedido` */

DROP TABLE IF EXISTS `pedido`;

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL AUTO_INCREMENT,
  `fechaPedido` date NOT NULL,
  `cliente_idCliente` int(11) NOT NULL,
  PRIMARY KEY (`idPedido`),
  KEY `cliente_idCliente` (`cliente_idCliente`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`cliente_idCliente`) REFERENCES `cliente` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pedido` */

insert  into `pedido`(`idPedido`,`fechaPedido`,`cliente_idCliente`) values (1,'2023-06-30',12);

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `codigoProducto` varchar(20) NOT NULL,
  `nombreProductos` varchar(100) NOT NULL,
  `valorProducto` decimal(10,2) NOT NULL,
  `stockProducto` int(11) NOT NULL,
  `descripcionProducto` varchar(250) NOT NULL,
  `categoria_idCategoria` int(11) NOT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `categoria_idCategoria` (`categoria_idCategoria`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_idCategoria`) REFERENCES `categoria` (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `productos` */

insert  into `productos`(`idProducto`,`codigoProducto`,`nombreProductos`,`valorProducto`,`stockProducto`,`descripcionProducto`,`categoria_idCategoria`) values (1,'P001','Martillo',25000.00,50,'Herramienta',1),(2,'P002','Destornillador',10000.00,75,'Herramienta',1),(3,'P003','Taladro',150000.00,20,'Eléctrico',1),(4,'P004','Cinta Métrica',8000.00,100,'Medición',5),(5,'P005','Llave Ajustable',18000.00,40,'Herramienta',5),(6,'P006','Sierra de Mano',30000.00,30,'Corte',1),(7,'P007','Brocas',12000.00,60,'Accesorio',1),(8,'P008','Clavos',5000.00,200,'Fijación',5),(9,'P009','Pintura',35000.00,15,'Acabado',2),(10,'P010','Guantes de Trabajo',10000.00,50,'Protección',1),(11,'P011','Sierra Circular',250000.00,10,'Eléctrico',0),(12,'P012','Llave de Tubo',22000.00,35,'Herramienta',0),(13,'P013','Pegamento',8000.00,80,'Adhesivo',0),(14,'P014','Lija',5000.00,150,'Pulido',0),(15,'P015','Tornillos',6000.00,100,'Fijación',0),(16,'P016','Taladro Inalámbrico',180000.00,25,'Eléctrico',0),(17,'P017','Nivel',40000.00,20,'Medición',0),(18,'P018','Pinzas',15000.00,45,'Herramienta',0),(19,'P019','Serrucho',25000.00,30,'Corte',0),(20,'P020','Escuadra',10000.00,70,'Medición',0),(21,'P021','Cepillo Metálico',12000.00,60,'Limpieza',0),(22,'P022','Pala',35000.00,15,'Jardinería',0),(23,'P023','Tijeras de Podar',25000.00,25,'Jardinería',0),(24,'P024','Grifo',50000.00,10,'Fontanería',0),(25,'P025','Linterna',15000.00,135,'Iluminación',1),(26,'P026','Cerradura',20000.00,30,'Seguridad',0),(27,'P027','Soplete',45000.00,20,'Soldadura',0),(28,'P028','Brocha',8000.00,60,'Pintura',0),(29,'P029','Cables Eléctricos',10000.00,100,'Electricidad',0),(30,'P030','Destornillador de Precisión',15000.00,50,'Herramienta',0),(33,'P025','Linterna',15000.00,145,'Iluminacion',1);

/*Table structure for table `proveedor` */

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProveedor` varchar(100) NOT NULL,
  `apellidoProveedor` varchar(100) NOT NULL,
  `telefonoProveedor` varchar(20) NOT NULL,
  `direccionProveedor` varchar(100) NOT NULL,
  `correoProveedor` varchar(45) NOT NULL,
  PRIMARY KEY (`idProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `proveedor` */

insert  into `proveedor`(`idProveedor`,`nombreProveedor`,`apellidoProveedor`,`telefonoProveedor`,`direccionProveedor`,`correoProveedor`) values (1,'Ferreacero','','555-123-4567','Calle Principal 123','info@ferreacero.com'),(2,'Herrajes','López','555-987-6543','Avenida del Sol 456','ventas@herrajeslopez.com'),(3,'Materiales','Rivas','555-555-5555','Plaza Mayor 789','contacto@materialesrivas.com'),(4,'Ferretería','Gómez','555-111-2222','Calle del Parque 234','info@ferreteriagomez.com'),(5,'Suministros','Martínez','555-777-8888','Paseo de la Montaña 567','ventas@suministrosmartinez.com'),(6,'Ferromaq','','555-333-9999','Avenida de los Flores 890','contacto@ferromaq.com'),(7,'Ferretería','Torres','555-444-3333','Calle de los Pinos 123','ventas@ferreteriatorres.com'),(8,'Comercial','Ferroplast','555-666-7777','Plaza del Mercado 456','info@comercialferroplast.com'),(9,'Proveedora','Vargas','555-888-9999','Avenida de la Playa 78','ventas@proveedoravargas.com'),(10,'Ferretería','Luna','555-222-1111','Calle de la Luna 234','contacto@ferreterialuna.com'),(11,'Suministros','Herrera','555-666-4444','Paseo del Bosque 567','info@suministrosherrera.com'),(12,'Ferretería','Silva','555-222-7777','Avenida de las Palmas 890','ventas@ferreteriasilva.com'),(13,'Comercial','Morales','555-888-5555','Calle del Río 123','contacto@comercialmorales.com'),(14,'Proveedora','Pacheco','555-444-2222','Plaza de la Fuente 456','ventas@proveedorapacheco.com'),(15,'FerroSuministros','Méndez','555-777-9999','Avenida de los Alamos 789','info@ferrosuministrosmendez.com');

/*Table structure for table `rol` */

DROP TABLE IF EXISTS `rol`;

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(45) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rol` */

insert  into `rol`(`idRol`,`nombreRol`) values (1,'Adminstrador'),(2,'Vendedor');

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `tipoDocumentoUsuario` enum('CC','TI','CE') NOT NULL DEFAULT 'CC',
  `documentopUsuario` varchar(20) NOT NULL,
  `nombresUsuario` varchar(100) NOT NULL,
  `apellidosUsuario` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `claveUsuario` varchar(50) NOT NULL,
  `estadoUsuario` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `rol_idRol` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `rol_idRol` (`rol_idRol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol_idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `usuario` */

insert  into `usuario`(`idUsuario`,`tipoDocumentoUsuario`,`documentopUsuario`,`nombresUsuario`,`apellidosUsuario`,`correo`,`claveUsuario`,`estadoUsuario`,`rol_idRol`) values (1,'CC','123456789        ','Juan    ','Pérez    ','juan.perez@example.com','juan1234              ','Activo',1),(2,'CC','987654321        ','María   ','López    ','maria.lopez@example.com','maria5678             ','Inactivo',2),(3,'CE','A12345678        ','Carlos  ','Gómez    ','carlos.gomez@example.com','carlos9823            ','Activo',2),(4,'CC','456789123        ','Laura   ','Torres   ','laura.torres@example.com','laura7412             ','Activo',2),(5,'CC','789123456        ','Pedro   ','Ramírez  ','pedro.ramirez@example.com','pedro5309             ','Inactivo',1),(6,'CC','321654987        ','Ana     ','Rodríguez| ','Rodríguez| ','ana2716               ','Activo',2),(7,'CE','B87654321        ','Andrés  ','Silva    ','Silva    ','andres4992            ','Inactivo',2),(8,'CC','654987321        ','Carolina| ','Vargas   ','carolina.vargas@example.com','carolina7248         ','Activo',2),(9,'CC','234567891        ','Daniel  ','Martínez ','daniel.martinez@example.com','daniel2083            ','Inactivo',2),(10,'CC','678912345        ','Laura   ','Salazar  ','Salazar  ','laura3847             ','Activo',2),(11,'CC','987654321        ','José    ','Castro   ','jose.castro@example.com','jose7529              ','Inactivo',2),(12,'CE','C87654321        ','María   ','Ríos     ','Ríos     ','maria9735             ','Activo',2),(13,'CC','456789123        ','Alejandro','Gómez','alejandro.gomez@example.com','alejandro6165','Inactivo',1),(14,'CC','789123456        ','Andrea','Herrera','andrea.herrera@example.com','andrea.herrera@example.com','Activo',2),(15,'CC','321654987        ','Andrés  ','González ','González ','andres9614            ','Inactivo',2);

/* Procedure structure for procedure `Actualiza_Factura` */

/*!50003 DROP PROCEDURE IF EXISTS  `Actualiza_Factura` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Actualiza_Factura`()
BEGIN
	SELECT f.idFactura, COUNT(DISTINCT p.codigoProducto) AS Productos_Vendidos, COUNT(f.idFactura) AS Ventas_Realizadas
	FROM factura f
	JOIN detallePedido dp ON dp.idDetallePedido= f.idFactura
	JOIN productos p ON p.codigoProducto = dp.producto_idProducto
	GROUP BY f.idFactura;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `C_Proveedor` */

/*!50003 DROP PROCEDURE IF EXISTS  `C_Proveedor` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `C_Proveedor`()
BEGIN
	SELECT c.IdCompra, c.fechaCompra, c.valorCompra FROM compras c
	JOIN detallefactura df ON c.`idCompra` = df.`factura_idFactura`;
    END */$$
DELIMITER ;

/*Table structure for table `p_venta` */

DROP TABLE IF EXISTS `p_venta`;

/*!50001 DROP VIEW IF EXISTS `p_venta` */;
/*!50001 DROP TABLE IF EXISTS `p_venta` */;

/*!50001 CREATE TABLE  `p_venta`(
 `IdCliente` int(11) ,
 `documentoCliente` varchar(20) ,
 `idFactura` int(11) ,
 `fechaFactura` date ,
 `ValorTotalFactura` decimal(10,0) 
)*/;

/*View structure for view p_venta */

/*!50001 DROP TABLE IF EXISTS `p_venta` */;
/*!50001 DROP VIEW IF EXISTS `p_venta` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `p_venta` AS (select `c`.`idCliente` AS `IdCliente`,`c`.`documentoCliente` AS `documentoCliente`,`f`.`idFactura` AS `idFactura`,`f`.`fechaFactura` AS `fechaFactura`,`f`.`valorTotalFactura` AS `ValorTotalFactura` from ((`cliente` `c` join `pedido` `p` on(`c`.`idCliente` = `p`.`cliente_idCliente`)) join `factura` `f` on(`p`.`idPedido` = `f`.`usuario_idUsuario`))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
