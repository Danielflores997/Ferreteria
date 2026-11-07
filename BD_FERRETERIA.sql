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

/* Tabla maestra multi-tenant */

DROP TABLE IF EXISTS `tenants`;

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `documento` varchar(30) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_tenants_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tenants` (`id`,`nombre`,`slug`,`estado`)
VALUES (1,'Ferretería inicial','ferreteria-inicial','Activo');

/*Table structure for table `categoria` */

DROP TABLE IF EXISTS `categoria`;

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCategoria` varchar(100) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `categoria` */

LOCK TABLES `categoria` WRITE;

insert  into `categoria`(`idCategoria`,`nombreCategoria`) values (1,'HERRAMIENTAS'),(2,'PINTURAS'),(3,'CEMENTOS'),(4,'HERRAMIENTAS ELECTRICAS'),(5,'CARPINTERIA'),(6,'TORNILLLERIA'),(7,'PLOMERIA'),(8,'JARDINERIA'),(9,'ACCESORIOS');

UNLOCK TABLES;

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
  `estadoCliente` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idCliente`),
  UNIQUE KEY `uq_cliente_tenant_id` (`tenant_id`,`idCliente`),
  KEY `idx_cliente_tenant` (`tenant_id`),
  CONSTRAINT `fk_cliente_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cliente` */

LOCK TABLES `cliente` WRITE;

insert  into `cliente`(`idCliente`,`tipoDocumentoCliente`,`documentoCliente`,`nombresCliente`,`apellidosCliente`,`telefonoCliente`,`direccionCliente`,`estadoCliente`) values (1,'TI','21243534','Juan','Pérez','3157568987','Calle 321, Ciudad','Activo'),(2,'CC','987654321','María','Gómez','9876543210','Carrera 456, Ciudad','Inactivo'),(3,'CC','246813579','Carlos','López','2468135790','Avenida 789, Ciudad','Activo'),(4,'CC','135792468','Laura','Rodríguez','1357924680','Calle 567, Ciudad','Activo'),(5,'CC','864209753','Ana','Ramírez','8642097530','Carrera 890, Ciudad','Inactivo'),(6,'CC','579642813','Andrés','Sánchez','5796428130','Avenida 1234, Ciudad','Activo'),(7,'CC','310725846','Sofía','Torres','3107258460','Calle 5678, Ciudad','Inactivo'),(8,'CC','951462807','Alejandro','Castro','9514628070','Carrera 9012, Ciudad','Activo'),(9,'CC','207536184','Andrea','Morales','2075361840','Avenida 3456, Ciudad','Inactivo'),(10,'CC','468175923','David','Jiménez','4681759230','Calle 7890, Ciudad','Activo'),(11,'CC','726943851','Natalia','Herrera','7269438510','Carrera 12345, Ciudad','Inactivo'),(12,'CC','358291674','Roberto','Ortega','3582916740','Avenida 67890, Ciudad','Activo'),(13,'CC','612835947','Carolina','Vargas','6128359470','Calle 12345, Ciudad','Activo'),(14,'CC','973461528','Luis','Castro','9734615280','Carrera 67890, Ciudad','Inactivo'),(15,'CC','245890173','Laura','Molina','2458901730','Avenida 123456, Ciudad	','Activo'),(16,'CC','481357926','José','Ríos','4813579260','Calle 789012, Ciudad','Inactivo'),(17,'CC','936427510','Daniela','Guzmán','9364275100','Carrera 345678, Ciudad','Activo'),(18,'CC','719264583','Pedro','Silva','7192645830','Avenida 901234, Ciudad','Inactivo'),(19,'CC','205819347','Andrés','Rojas','2058193470','Carrera 2367, Ciudad','Inactivo'),(21,'CC','1000320746','daniel','flores','8152606466','522 Mcdounough st','Inactivo');

UNLOCK TABLES;

/*Table structure for table `compras` */

DROP TABLE IF EXISTS `compras`;

CREATE TABLE `compras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  `checkout_id` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `producto_id` (`producto_id`),
  KEY `idx_compras_tenant_checkout` (`tenant_id`,`checkout_id`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`idProducto`),
  CONSTRAINT `fk_compras_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compras` */

LOCK TABLES `compras` WRITE;

insert  into `compras`(`id`,`usuario_id`,`producto_id`,`cantidad`,`fecha`) values (1,20,63,1,'2024-03-01 23:36:51'),(2,20,2,1,'2024-03-01 23:36:51'),(3,20,1,1,'2024-03-01 23:36:51'),(4,20,10,1,'2024-03-02 23:36:51'),(5,22,31,1,'2024-03-03 23:37:41'),(6,22,39,1,'2024-03-03 23:37:41'),(7,22,44,1,'2024-03-04 23:37:41'),(8,22,42,1,'2024-03-06 23:37:41'),(9,22,4,1,'2024-03-13 23:37:41'),(10,22,60,2,'2024-03-15 23:37:41');

UNLOCK TABLES;

/*Table structure for table `detallefactura` */

DROP TABLE IF EXISTS `detallefactura`;

CREATE TABLE `detallefactura` (
  `idDetalleFactura` int(11) NOT NULL AUTO_INCREMENT,
  `factura_idFactura` int(11) NOT NULL,
  `productos_idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valorProductoVenta` decimal(10,0) NOT NULL,
  `totalDetalle` decimal(10,0) NOT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idDetalleFactura`),
  KEY `factura_idFactura` (`factura_idFactura`),
  KEY `productos_idProducto` (`productos_idProducto`),
  CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`factura_idFactura`) REFERENCES `factura` (`idFactura`),
  CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`productos_idProducto`) REFERENCES `productos` (`idProducto`),
  KEY `idx_detallefactura_tenant` (`tenant_id`),
  CONSTRAINT `fk_detallefactura_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `detallefactura` */

LOCK TABLES `detallefactura` WRITE;

insert  into `detallefactura`(`idDetalleFactura`,`factura_idFactura`,`productos_idProducto`,`cantidad`,`valorProductoVenta`,`totalDetalle`) values (1,1,5,2,25000,50000),(2,1,1,1,15000,15000);

UNLOCK TABLES;

/*Table structure for table `detallepedido` */

DROP TABLE IF EXISTS `detallepedido`;

CREATE TABLE `detallepedido` (
  `idDetallePedido` int(11) NOT NULL AUTO_INCREMENT,
  `cantidadPedido` int(11) NOT NULL,
  `producto_idProducto` int(11) NOT NULL,
  `totalDetallePedido` decimal(10,0) NOT NULL,
  `pedido_idPedido` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idDetallePedido`),
  KEY `pedido_idPedido` (`pedido_idPedido`),
  KEY `producto_idProducto` (`producto_idProducto`),
  CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`pedido_idPedido`) REFERENCES `pedido` (`idPedido`),
  CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`producto_idProducto`) REFERENCES `productos` (`idProducto`),
  KEY `idx_detallepedido_tenant` (`tenant_id`),
  CONSTRAINT `fk_detallepedido_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `detallepedido` */

LOCK TABLES `detallepedido` WRITE;

insert  into `detallepedido`(`idDetallePedido`,`cantidadPedido`,`producto_idProducto`,`totalDetallePedido`,`pedido_idPedido`) values (1,3,1,58999,1),(2,2,5,650000,1);

UNLOCK TABLES;

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
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idFactura`),
  UNIQUE KEY `uq_factura_tenant_id` (`tenant_id`,`idFactura`),
  KEY `cliente_idCliente` (`cliente_idCliente`),
  KEY `usuario_idUsuario` (`usuario_idUsuario`),
  KEY `pedido_idPedido` (`pedido_idPedido`),
  CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cliente_idCliente`) REFERENCES `cliente` (`idCliente`),
  CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`),
  CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`pedido_idPedido`) REFERENCES `pedido` (`idPedido`),
  KEY `idx_factura_tenant` (`tenant_id`),
  CONSTRAINT `fk_factura_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `factura` */

LOCK TABLES `factura` WRITE;

insert  into `factura`(`idFactura`,`fechaFactura`,`subtotalfactura`,`impuesto`,`valorTotalFactura`,`cliente_idCliente`,`usuario_idUsuario`,`pedido_idPedido`) values (1,'2023-06-11',258900,15,890000,12,1,1);

UNLOCK TABLES;

/*Table structure for table `pedido` */

DROP TABLE IF EXISTS `pedido`;

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL AUTO_INCREMENT,
  `fechaPedido` date NOT NULL,
  `cliente_idCliente` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idPedido`),
  UNIQUE KEY `uq_pedido_tenant_id` (`tenant_id`,`idPedido`),
  KEY `cliente_idCliente` (`cliente_idCliente`),
  CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`cliente_idCliente`) REFERENCES `cliente` (`idCliente`),
  KEY `idx_pedido_tenant` (`tenant_id`),
  CONSTRAINT `fk_pedido_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pedido` */

LOCK TABLES `pedido` WRITE;

insert  into `pedido`(`idPedido`,`fechaPedido`,`cliente_idCliente`) values (1,'2023-06-30',12);

UNLOCK TABLES;

/*Table structure for table `peticiones` */

DROP TABLE IF EXISTS `peticiones`;

CREATE TABLE `peticiones` (
  `idPeticion` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(20) DEFAULT NULL,
  `Apellido` varchar(20) DEFAULT NULL,
  `Direccion` varchar(50) DEFAULT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Motivo` varchar(250) DEFAULT NULL,
  `Estado` enum('Si','No') DEFAULT NULL,
  `tenant_id` int(11) DEFAULT 1,
  PRIMARY KEY (`idPeticion`),
  KEY `idx_peticiones_tenant` (`tenant_id`),
  CONSTRAINT `fk_peticiones_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `peticiones` */

LOCK TABLES `peticiones` WRITE;

insert  into `peticiones`(`Nombre`,`Apellido`,`Direccion`,`Telefono`,`Correo`,`Motivo`,`Estado`) values ('daniel','flores','522 Mcdounough st',2147483647,'daniflores@gmail.com','a david no le funcionan los mensajes para quejarse, ayudenlo plis','Si'),('armando','pizos','522 Mcdounough st',2147483647,'armandopizos@hotmail.com','Mensaje con 100 caracteres:\r\n\"Producto defectuoso, exijo un reemplazo.\"\r\n\r\nMensaje con 150 caractere','No'),('cristian','gray','kr 13f este 91b 17 sur',313,'cristian@gmail.com','el martillo no martilla bien','No');

UNLOCK TABLES;

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `codigoProducto` varchar(20) NOT NULL,
  `nombreProductos` varchar(100) NOT NULL,
  `valorProducto` decimal(10,2) NOT NULL,
  `stockProducto` int(11) NOT NULL,
  `descripcionProducto` varchar(250) NOT NULL,
  `nombreCategoria` int(11) NOT NULL,
  `imagen` varchar(250) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idProducto`),
  UNIQUE KEY `uq_productos_tenant_codigo` (`tenant_id`,`codigoProducto`),
  UNIQUE KEY `uq_productos_tenant_id` (`tenant_id`,`idProducto`),
  KEY `categoria_idCategoria` (`nombreCategoria`),
  KEY `idx_productos_tenant` (`tenant_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`nombreCategoria`) REFERENCES `categoria` (`idCategoria`),
  CONSTRAINT `fk_productos_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `productos` */

LOCK TABLES `productos` WRITE;

insert  into `productos`(`idProducto`,`codigoProducto`,`nombreProductos`,`valorProducto`,`stockProducto`,`descripcionProducto`,`nombreCategoria`,`imagen`) values (1,'P001','Martillo Thompson',20000.00,40,'De bola mango anti deslizante',1,'https://www.electromanferonline.com/2262-large_default/martillo-cabeza-bola-de-bronce-1-12-lb-cabo-fibra.jpg'),(2,'P002','Destornillador Stanley',10000.00,85,'Estornillador Punta plana Color Negro',1,'https://iprpartesyrepuestos.com/wp-content/uploads/2018/09/510-0009-3.jpg'),(3,'P003','Taladro Makita',150000.00,20,'Capacidad de Broquero (13MM)',4,'https://belltec.com.co/6754-large_default/taladro-de-rotacion-38-makita-450-watts-6413.jpg\r\n'),(4,'P004','Cinta Métrica Stanley',8000.00,100,'Cubierta Negra apto para carpinteria',1,'https://belltec.com.co/16912-large_default/cinta-metrica-global-plus-8-mts-1pulg-stanley-30626.jpg\r\n'),(5,'P005','Llave Ajustable Incolma',18000.00,40,'Acero inoxidable para tuerca de 18\'\'',1,'https://belltec.com.co/11417-large_default/llave-ajustable-6-pulgadas-cromada-stanley-87431.jpg\r\n'),(6,'P006','Sierra de Mano GRÜNTEK',30000.00,30,'Apto para jardineria y mango de madera de roble',4,'https://m.media-amazon.com/images/I/61mVXBtQkkL.jpg\r\n'),(7,'P007','Brocas BLACK & DECKER',12000.00,60,'Brocas para manposteria de 1/8\"',1,'https://www.incolma.com/wp-content/uploads/2022/04/Brocas-HSS-Barracuda-e1624672193286.png'),(8,'P008','Clavos Incolma',5000.00,200,'Clavos Punta de acero para pared tipo pesado',5,'https://i0.wp.com/pinturasyyesos.com/wp-content/uploads/2021/02/clavos-corsan-comun.jpg?fit=800%2C800&ssl=1\r\n'),(9,'P009','Pintura Vinitex Pintuco',35000.00,15,'Especialmente para exteriores y proteccion UV',2,'https://www.pinturastorcaza.com/wp-content/uploads/2020/03/poliuretano-pg-compressed.jpg\r\n'),(10,'P010','Guantes de Trabajo KIM',10000.00,50,'Protección anti-fluido y tipo pesado',9,'https://static.stihl.com/upload/assetmanager/modell_imagefilename/scaled/zoom/bf2132560e4b48ffb236e0d96c62e3d6.jpg\r\n'),(11,'P011','Sierra Circular Dewalt',250000.00,10,'Sierra de 5500 RPM tipo industrial Amarillo',4,'https://plazavea.vteximg.com.br/arquivos/ids/21436393-512-512/image-9ae83aea62204d93ab09113f4e414731.jpg'),(12,'P012','Llave de Tubo Stanley',22000.00,35,'Apto para todo tipo de tuberia antioxidante',7,'https://www.reedmfgco.com/assets/Images/Products/Wrenches/Pipe-Wrenches-Heavy-Duty-Straight/02120-RW8-RGB__PadWzEyODAsODQ2LCJGRkZGRkYiLDBd.jpg\r\n'),(13,'P013','Pegamento Carpincol',8000.00,80,'Adhesivo exclusivo para madera ',3,'https://www.electromanferonline.com/730-large_default/boxer-evoluci%C3%B3n-x-gal%C3%B3n.jpg\r\n'),(14,'P014','Lija Abracol',5000.00,150,'Lija de agua con papel para madera y acrilico',5,'https://ferreteriaonlinelevallejoaz.com/wp-content/uploads/2021/04/350.jpg'),(15,'P015','Tornillos Incolma',6000.00,100,'Punta de acero especialmente para pared de concreto',6,'https://schecomex.com/wp-content/uploads/2020/09/Tornillos-para-madera-.jpg\r\n'),(16,'P016','Taladro Inalámbrico Stanley',180000.00,25,'Larga duracion y adaptable al trabajo rutinario',4,'https://dotacionesadomicilio.com/wp-content/uploads/2022/04/taladro-inalambrico-dewalt-20v-nuevo-original-dotaciones-a-domicilio-15.jpg\r\n'),(17,'P017','Nivel Incolma',40000.00,20,'Preciso y multimedida de color Gris plata',1,'https://perusupply.com/218-large_default/nivel-de-mano-24-truper.jpg\r\n'),(18,'P018','Pinzas Stanley',15000.00,45,'Antioxidante y de caucho anti desplizante',1,'https://i0.wp.com/pinturasyyesos.com/wp-content/uploads/2021/02/alicate-8-pretul.jpg?fit=800%2C800&ssl=1\r\n'),(19,'P019','Serrucho GRÜNTEK',25000.00,30,'Mayor precision y mas durabilidad',5,'https://jpdrywallsystem.com/wp-content/uploads/2019/11/serrucho.jpg\r\n'),(20,'P020','Escuadra Fabell Castell',10000.00,70,'Acero anti-oxidable numeracion clara',1,'https://www.dateriumsystem.com/appfiles/clientes/308/catalogo/ESCUADRA-ACERO-MANGO-ALUMINIO-ALYCO-197392-PRINCIPAL.jpg\r\n'),(21,'P021','Cepillo Metálico Incolma',12000.00,60,'Limpieza profunda con cerdas de titanio',1,'https://rodapin.com/wp-content/uploads/2021/04/48200-cepillo-metalico-curvo-estandar.jpg\r\n'),(22,'P022','Pala Stanley',55000.00,10,'Multiproposito para construccion y jardineria',1,'https://codecam.com.co/wp-content/uploads/2021/07/PALA-ANTICHISPA-scaled.jpg\r\n'),(23,'P023','Tijeras de Podar Stanley',25000.00,25,'Mango flexible color negro metalizado',8,'https://guantesterry.com/wp-content/uploads/2019/08/TIJERA-PODA-7-BELLOTA.jpg\r\n'),(24,'P024','Grifo Bocherinni',50000.00,10,'Cubierta de plata apto para la cocina',7,'https://www.ferreteriabervar.com/cdn/shop/products/GRIFO_CORNETA_BRONCE_1_2_47d39945-28b6-4378-b16c-5d23d6e9fd2a.png?v=1660225900'),(25,'P025','Linterna Phillips',15000.00,40,'Recargable de tecnologia LED y mayor distancia',1,'https://losvictorinos.co/cdn/shop/products/Linterna_tactica_recargable_P50_VTR-193_9.png?v=1680125631'),(26,'P026','Cerradura YALE',20000.00,30,'Calibre pesado para exteriores Blanca',9,'https://ps.felinux.co/456-large_default/cerradura-de-seguridad-auxiliar-antitaladro-mha.jpg\r\n'),(27,'P027','Soplete Ingrill',45000.00,20,'Apto para ahumadores nuestro kit soplete, fácil y cómodo a la hora de usarlo.',7,'https://ferreteriatecnica.co/cdn/shop/products/SOPLETE-2200-DREMEL_800x.jpg?v=1613568517'),(29,'P029','Cables Eléctricos Centelsa',10000.00,100,'Cable de cobre tipo 8 rollo de 100 mts',1,'https://bricable.com/wp-content/themes/bricable-theme/imgs/caja_bricable.jpg'),(30,'P030','Destornillador de Precisión',15000.00,50,'Herramienta',1,'https://img.pccomponentes.com/articles/5/54609/startech-kit-destornilladores-precision.jpg\r\n'),(31,'P031','Pintura Blanca Kolor',25000.00,10,'Especialmente para exteriores y antideslizante',2,'https://admintienda.coval.com.co/backend/admin/backend/web/archivosDelCliente/items/images/20210602120033-INTERIOR-PAREDES-Vinilico-Blanco-Caneca-5-Galones-Ico-850202106021200335145.jpg\r\n'),(32,'P032','Taladro Percutor Black and Decker',95000.00,10,'Naranja especialmente para trabajo tipo pesado',4,'https://www.loencuentras.com.co/1389-large_default/taladro-percutor-12-profesional-850-w-.jpg\r\n'),(33,'P033','Martillo de Carpintero Incolma',13000.00,40,'Martillo Para Roble y MDF',1,'https://m.media-amazon.com/images/I/31BUQrbTgpL.jpg'),(34,'P034','Pintura en Aerosol Vinitex',19000.00,40,'Anti fluidos y mayor durabilidad',2,'https://i.linio.com/p/c79f94590f73dde1443ee1be3151a737-product.jpg\r\n'),(35,'P035','Cemento Gris Cemex',29000.00,45,'Cemento Para Construccion tipo Portland',3,'https://ferropaz.com/img/p/3/7/37-thickbox_default.jpg\r\n'),(36,'P036','Cemento Blanco Corona',35000.00,20,'Cemento Para Ceramica de secado facil',3,'https://centroferreteromafer.com/wp-content/uploads/2019/06/CEMENTO-BLANCO-ARGOS.jpg\r\n'),(37,'P037','Pulidora Para Pisos Abracol',110000.00,9,'Disco Fino para mayor brillo ',4,'https://i0.wp.com/aspiradoras-ventas.com/wp-content/uploads/sites/5/2020/08/D-2015-1.jpg?fit=600%2C600&ssl=1'),(38,'P038','Varsol Para Madera Alaska',10000.00,50,'disolvente efectivo para diluir pinturas a base deaceite',5,'https://pisolimpio.com.co/wp-content/uploads/3815.jpg\r\n'),(39,'P039','Rodillo Para Pintura Goya',10000.00,60,'Rodillo Para Pintar Fachadas mango anti desplizante',2,'https://m.media-amazon.com/images/I/61-CXpx5LvL.jpg\r\n'),(40,'P040','Mortero Holcim',23000.00,35,'Mezcla Facil para interiores',3,'https://cdn.homedepot.com.mx/productos/981862/981862-z.jpg\r\n'),(41,'P041','Adhesivo Para Ceramica Corona',25000.00,20,'Pegante Especial Para Todo Tipo De Ceramica',3,'https://www.argos.com.pa/wp-content/uploads/2021/09/pegamento-ceramica.jpg\r\n'),(42,'P042','Brocha Goya',5000.00,40,'Mango de madera y mas resistente',2,'https://m.media-amazon.com/images/I/71YmeD-PlEL._AC_UF894,1000_QL80_.jpg'),(43,'P043','Espatula Goya',6000.00,30,'Mayor Acabo En Interiores',2,'https://www.herragro.com/shop/152-large_default/espatula-flexible-2.jpg\r\n'),(44,'P044','Diluyente de Pintura Alaska',10000.00,15,'Retirar La Pintura En Materiales Delicadas',2,'https://d2o812a6k13pkp.cloudfront.net/fit-in/455x455/Productos/40386088_0120220525095101.jpg'),(45,'P045','Grava',15000.00,150,'Complemento Para Construccion En General',3,'https://www.materialesmae.com/ferreteria-cuautitlan/grava-texcoco.jpg\r\n'),(46,'P046','Arena',15000.00,150,'Complemento Para Construccion En General',3,'https://static5.depositphotos.com/1006597/458/i/450/depositphotos_4585145-stock-photo-pile-of-sand.jpg\r\n'),(47,'P047','Cepillo Electrico Dewalt',80000.00,15,'Elimina Las Impuras Facilmente 700 W',4,'https://belltec.com.co/11133-large_default/cepillo-makita-kp0800.jpg\r\n'),(48,'P048','Sierra Caladora Bauker',100000.00,50,'800 w + 2 hojas de repuesto + Laser Rojo',4,'https://www.atrial.com.co/wp-content/uploads/2021/05/sierra-caladora-profesional-550-w-7da.jpg\r\n'),(49,'P049','Tornillo Cabeza Hexagonal Incolma',1000.00,100,'Aptos Para Los Muebles',6,'https://hechitools.com/cdn/shop/products/LLADEDETRINQUETEEXTENDIBLET7214.jpg?v=1651768820\r\n'),(50,'P050','Tornillo Autoroscante Incolma',500.00,200,'Facil Para Ajustar Cuadros',6,'https://www.fisa.com.co/496-home_default/juego-llaves-fijas-86-970-stanley.jpg\r\n'),(51,'P051','Tornillo de Fijacion Incolma',600.00,100,'Aptos Para Fijar Estructuras Metalicas',6,'https://thorsmex.mx/wp-content/uploads/2022/08/tornillo-cabeza-plana.jpg'),(52,'P052','Tornillo de Acero inoxidable Incolma',1000.00,200,'Aptos Para Exteriores',6,'https://m.media-amazon.com/images/I/61Iv8YrXkLL._AC_UF894,1000_QL80_.jpg'),(53,'P053','Tornillo de Rosca Metrica Incolma',350.00,50,'Apto para Vehiculos Y Motos',6,'https://blog.bextok.com/wp-content/uploads/2017/03/iStock-529328169-e1490544032846.jpg'),(54,'P054','Codo PVC Pavco Wavin',2500.00,30,'Exclusivo Para Transporte de Agua Potable',1,'https://d2j6dbq0eux0bg.cloudfront.net/images/28326070/2880507065.jpg\r\n'),(55,'P055','Tubo de Cobre',10000.00,150,'Para el calentador 1/2\" 6 Mts',7,'https://cdn.homedepot.com.mx/productos/625300/625300-d.jpg\r\n'),(56,'P056','Tubo flexible Pavco Wavin',3000.00,50,'TUBO PVC AGUA 3/4\" 5 M C/R PAVCO',7,'https://akl.com.pe/805-large_default/tubo-pvc-agua-34-5-m-cr-pavco.jpg'),(57,'P057','Sifon Grival',5000.00,30,'Sifón flexible Grival 1½” y 1¼” para lavamanos y lavaplatos',7,'https://admintienda.coval.com.co/backend/admin/backend/web/archivosDelCliente/items/images/20220311122908-COMPLEMENTOS-SIFONES-Sifon-en-P-Gris-con-adaptador-Grival-2090202203111229089270.jpg\r\n'),(58,'P058','Rastrillo Incolma',8000.00,30,'Para barrer el cesped Dientes antioxidantes',8,'https://zummar.com/wp-content/uploads/2022/06/rastrillo-jardinero-16-dientes-mango-6-fibra-de-vidrio-truper-R-16AMF.jpg'),(59,'P059','Guantes Para Jardineria KIM',5000.00,45,'Para Proteger de Las Ramas Rotas Color Amarillo',8,'https://bosquesa.com.do/website_files/products/8.jpg\r\n'),(60,'P060','Regadera Incolma',10000.00,25,'Para Hidratar Las Plantas verde jungla',1,'https://www.ecured.cu/images/3/33/Regaderaaa2.jpg\r\n'),(61,'P061','llave YALE',3000.00,8,'Anti oxidante Plateado para tipo pesado',1,'https://www.cofan.es/images/content/1024x682/web1_31309999_01.jpg'),(62,'P062','pintura negra Kolor',31000.00,10,'para superficies externas para el carro y moto',2,'https://s.cornershopapp.com/product-images/232590.jpg'),(63,'P063','Base para bombillo SKAFTET',7800.00,5,'base para bombillo para el escritorio',1,'https://http2.mlstatic.com/D_NQ_NP_849936-MLV70505450149_072023-O.webp');

UNLOCK TABLES;

/*Table structure for table `proveedor` */

DROP TABLE IF EXISTS `proveedor`;

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProveedor` varchar(100) NOT NULL,
  `apellidoProveedor` varchar(100) NOT NULL,
  `telefonoProveedor` varchar(20) NOT NULL,
  `direccionProveedor` varchar(100) NOT NULL,
  `correoProveedor` varchar(45) NOT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idProveedor`)
  ,KEY `idx_proveedor_tenant` (`tenant_id`),
  CONSTRAINT `fk_proveedor_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000320747 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `proveedor` */

LOCK TABLES `proveedor` WRITE;

insert  into `proveedor`(`idProveedor`,`nombreProveedor`,`apellidoProveedor`,`telefonoProveedor`,`direccionProveedor`,`correoProveedor`) values (3566769,'Ferromaq','','777-333-9999','Avenida de los Flores 877','ferromaq@gmail.com'),(3783678,'Suministros','Martínez','666-777-8888','Paseo de la Montaña 567','ventas@suministrosmartinez.com'),(7986614,'Ferretería','Luna','555-222-1111','Calle de la Luna 234','contacto@ferreterialuna.com'),(8737837,'Materiales','Rivas','555-555-5555','Plaza Mayor 789','contacto@materialesrivas.com'),(8975757,'Proveedora daniel','Vargas','555-888-9999','Avenida de la Playa 78','ventas@proveedoravargas.com'),(9874576,'Suministros','Herrera','555-666-4444','Paseo del Bosque 567','info@suministrosherrera.com'),(18165164,'Ferreacero','Conway','3187659087','Calle Principal 321','info@ferreacero23.com'),(23556457,'Ferretería','Torres','555-444-3333','Calle de los Pinos 123','ventas@ferreteriatorres.com'),(25383783,'Herrajes','López','555-987-6543','Avenida del Sol 654','ventas@herrajeslopez.com'),(27867452,'Ferretería','Gómez','555-111-2222','Calle del Parque 234','info@ferreteriagomez.com'),(34556435,'Proveedora','Pacheco','555-444-2222','Plaza de la Fuente 456','ventas@proveedorapacheco.com'),(54653525,'Comercial','Ferroplast','555-666-7777','Plaza del Mercado 456','info@comercialferroplast.com'),(96574216,'Ferretería','Silva','555-222-7777','Avenida de las Palmas 890','ventas@ferreteriasilva.com'),(903465434,'Comercial','Morales','555-888-5555','Calle del Río 123','contacto@comercialmorales.com'),(1000320746,'daniel','Conway','8152606466','522 Mcdounough st','contacto23@ferromaq.com');

UNLOCK TABLES;

/*Table structure for table `rol` */

DROP TABLE IF EXISTS `rol`;

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(45) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rol` */

LOCK TABLES `rol` WRITE;

insert  into `rol`(`idRol`,`nombreRol`) values (1,'Administrador'),(2,'Vendedor'),(3,'Cliente'),(4,'Superadmin');

UNLOCK TABLES;

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `tipoDocumentoUsuario` enum('CC','TI','CE') NOT NULL DEFAULT 'CC',
  `documentoUsuario` varchar(20) NOT NULL,
  `nombresUsuario` varchar(100) NOT NULL,
  `apellidosUsuario` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `claveUsuario` varchar(255) NOT NULL,
  `estadoUsuario` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `rol_idRol` int(11) NOT NULL,
  `fotoPerfil` mediumtext DEFAULT NULL,
  `tenant_id` int(11) DEFAULT 1,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `uq_usuario_correo` (`correo`),
  UNIQUE KEY `uq_usuario_tenant_id` (`tenant_id`,`idUsuario`),
  KEY `idx_usuario_tenant_rol` (`tenant_id`,`rol_idRol`),
  KEY `rol_idRol` (`rol_idRol`),
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`rol_idRol`) REFERENCES `rol` (`idRol`),
  CONSTRAINT `fk_usuario_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `usuario` */

LOCK TABLES `usuario` WRITE;

insert  into `usuario`(`idUsuario`,`tipoDocumentoUsuario`,`documentoUsuario`,`nombresUsuario`,`apellidosUsuario`,`correo`,`claveUsuario`,`estadoUsuario`,`rol_idRol`,`fotoPerfil`) values (1,'TI',99752136,'Juan    ','Pérez    ','juanperez@gmail.com','juan369','Activo',2,NULL),(2,'CC',987654321,'María   ','López    ','maria.lopez@example.com','maria5678','Inactivo',2,NULL),(3,'CE',12345678,'Carlos  ','Gómez    ','carlos.gomez@example.com','carlos9823','Activo',2,NULL),(4,'CC',789123456,'Pedro   ','Ramírez  ','pedroramirez@example.com','pedro5309','Inactivo',1,NULL),(5,'CC',321654987,'Ana     ','Rodríguez| ','Rodríguez@example.com','ana2716','Activo',2,NULL),(6,'CE',87654321,'Andrés  ','Silva    ','Silva@example.com','andres4992','Inactivo',2,NULL),(7,'CC',654987321,'Carolina','Vargas','carolina.vargas@example.com','carolina7248','Activo',2,NULL),(8,'CC',234567891,'Daniel  ','Martínez ','daniel.martinez@example.com','daniel2083','Inactivo',2,NULL),(9,'CC',987654321,'José    ','Castro   ','jose.castro@example.com','jose7529','Inactivo',2,NULL),(10,'CC',456789123,'Alejandro','Gómez','alejandrogomez@example.com','alejandro6165','Activo',1,NULL),(11,'CC',789123456,'Andrea','Herrera','andreaherrera@example.com','andreaherrera','Activo',2,NULL),(12,'CC',321654987,'Andrés  ','González ','Gonzalez@example.com','andres9614','Inactivo',2,NULL),(13,'CC',1000320746,'Daniel Mauricio','Flores Rueda','daniflores5492@gmail.com','daniel','Activo',1,'https://www.mundodeportivo.com/alfabeta/hero/2023/11/halo-infinite.1699531337.9737.jpg?width=768&aspect_ratio=16:9&format=nowebp'),(14,'CC',27867867,'carolina','rueda','adrianiyarueda@gmail.com','1234','Activo',2,'https://img.freepik.com/vector-premium/angel-dibujos-animados-halo-fondo-rosa_712485-1527.jpg'),(20,'CC',3543645,'armando','pizos','casas23@gmail.com','23','Activo',0,'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDABQODxIPDRQSEBIXFRQYHjIhHhwcHj0sLiQySUBMS0dARkVQWnNiUFVtVkVGZIhlbXd7gYKBTmCNl4x9lnN+gXz/2wBDARUXFx4aHjshITt8U0ZTfHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHz/wAARCAJ5AaYDASI'),(22,'CC',342435345,'timmy','torner','padrinos@gmail.com','cosmo','Activo',0,'https://cdn.pixabay.com/photo/2022/07/22/10/42/man-7337829_640.jpg');

UNLOCK TABLES;

UPDATE `usuario`
SET `rol_idRol` = 3, `tenant_id` = NULL
WHERE `rol_idRol` IN (0, 3);

/*Table structure for table `ventas` */

DROP TABLE IF EXISTS `ventas`;

CREATE TABLE `ventas` (
  `idVenta` int(11) NOT NULL AUTO_INCREMENT,
  `idcodigo` varchar(20) NOT NULL,
  `producto` varchar(45) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `Categoria` varchar(45) DEFAULT NULL,
  `fecha_venta` date NOT NULL DEFAULT curdate(),
  `tenant_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idVenta`),
  KEY `idx_ventas_tenant_fecha` (`tenant_id`,`fecha_venta`),
  KEY `idx_ventas_tenant_codigo` (`tenant_id`,`idcodigo`),
  CONSTRAINT `fk_ventas_tenant` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `ventas` */

LOCK TABLES `ventas` WRITE;

insert  into `ventas`(`idVenta`,`idcodigo`,`producto`,`precio_unitario`,`cantidad`,`descripcion`,`Categoria`,`fecha_venta`) values (1,'P068','llaves respuesto',60000,10,'llaves con mucha fuerza','5','2024-02-17'),(2,'P001','martillo',35000,8,'para clavos','1','2024-02-18'),(3,'P001','Martillo',35000,8,'llaves con mucha fuerza','1','2024-02-19'),(4,'P001','Martillo',35000,10,'llaves con mucha fuerza','1','2024-02-20'),(6,'P063','Base para bombillo',35000,3,'fluorecente','1','2024-02-20'),(8,'P064','caja fuerte',15000,3,'muy fuerte','1','2024-03-06');

UNLOCK TABLES;

SET FOREIGN_KEY_CHECKS=1;

ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_producto_tenant`
  FOREIGN KEY (`tenant_id`,`producto_id`) REFERENCES `productos` (`tenant_id`,`idProducto`);

ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_cliente_tenant`
  FOREIGN KEY (`tenant_id`,`cliente_idCliente`) REFERENCES `cliente` (`tenant_id`,`idCliente`);

ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_cliente_tenant`
    FOREIGN KEY (`tenant_id`,`cliente_idCliente`) REFERENCES `cliente` (`tenant_id`,`idCliente`),
  ADD CONSTRAINT `fk_factura_usuario_tenant`
    FOREIGN KEY (`tenant_id`,`usuario_idUsuario`) REFERENCES `usuario` (`tenant_id`,`idUsuario`),
  ADD CONSTRAINT `fk_factura_pedido_tenant`
    FOREIGN KEY (`tenant_id`,`pedido_idPedido`) REFERENCES `pedido` (`tenant_id`,`idPedido`);

ALTER TABLE `detallepedido`
  ADD CONSTRAINT `fk_detallepedido_pedido_tenant`
    FOREIGN KEY (`tenant_id`,`pedido_idPedido`) REFERENCES `pedido` (`tenant_id`,`idPedido`),
  ADD CONSTRAINT `fk_detallepedido_producto_tenant`
    FOREIGN KEY (`tenant_id`,`producto_idProducto`) REFERENCES `productos` (`tenant_id`,`idProducto`);

ALTER TABLE `detallefactura`
  ADD CONSTRAINT `fk_detallefactura_factura_tenant`
    FOREIGN KEY (`tenant_id`,`factura_idFactura`) REFERENCES `factura` (`tenant_id`,`idFactura`),
  ADD CONSTRAINT `fk_detallefactura_producto_tenant`
    FOREIGN KEY (`tenant_id`,`productos_idProducto`) REFERENCES `productos` (`tenant_id`,`idProducto`);

/* Procedure structure for procedure `Compras_Superiores` */

/*!50003 DROP PROCEDURE IF EXISTS  `Compras_Superiores` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Compras_Superiores`()
BEGIN
SELECT c.nombre, c.apellido, SUM(d.precio * v.cantidad) AS total_compras
FROM clientes c
JOIN ventas v ON c.id_cliente = v.id_cliente
JOIN detalles_venta d ON v.id_venta = d.id_venta
GROUP BY c.nombre, c.apellido
HAVING total_compras > 100000;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `Productos_Bajo_Stock` */

/*!50003 DROP PROCEDURE IF EXISTS  `Productos_Bajo_Stock` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Productos_Bajo_Stock`(IN p_tenant_id INT)
BEGIN
    SELECT tenant_id, nombreProductos, stockProducto
    FROM productos
    WHERE stockProducto < 10
      AND (p_tenant_id IS NULL OR tenant_id = p_tenant_id);
END */$$
DELIMITER ;

/* Procedure structure for procedure `Productos_Vendidos` */

/*!50003 DROP PROCEDURE IF EXISTS  `Productos_Vendidos` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Productos_Vendidos`()
BEGIN
SELECT p.nombre, SUM(d.cantidad) AS total_vendido
FROM productos p
JOIN detalles_venta d ON p.id_producto = d.id_producto
JOIN ventas v ON d.id_venta = v.id_venta
WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY p.nombre
ORDER BY total_vendido DESC
LIMIT 6;
    END */$$
DELIMITER ;

/* Procedure structure for procedure `uno` */

/*!50003 DROP PROCEDURE IF EXISTS  `uno` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `uno`()
BEGIN
	
  
    END */$$
DELIMITER ;

/* Procedure structure for procedure `Ventas_Categoria_Mes` */

/*!50003 DROP PROCEDURE IF EXISTS  `Ventas_Categoria_Mes` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `Ventas_Categoria_Mes`()
BEGIN
SELECT c.nombre AS categoria, SUM(d.precio * v.cantidad) AS total_ventas
FROM ventas v
JOIN detalles_venta d ON v.id_venta = d.id_venta
JOIN productos p ON d.id_producto = p.id_producto
JOIN categorias c ON p.id_categoria = c.id_categoria
WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
GROUP BY c.nombre;
    END */$$
DELIMITER ;

/*Table structure for table `inventario_por_categoria` */

DROP TABLE IF EXISTS `inventario_por_categoria`;

/*!50001 DROP VIEW IF EXISTS `inventario_por_categoria` */;
/*!50001 DROP TABLE IF EXISTS `inventario_por_categoria` */;

/*!50001 CREATE TABLE  `inventario_por_categoria`(
 `nombreCategoria` varchar(100) ,
 `totalProductos` bigint(21) 
)*/;

/*Table structure for table `productos_mas_vendidos` */

DROP TABLE IF EXISTS `productos_mas_vendidos`;

/*!50001 DROP VIEW IF EXISTS `productos_mas_vendidos` */;
/*!50001 DROP TABLE IF EXISTS `productos_mas_vendidos` */;

/*!50001 CREATE TABLE  `productos_mas_vendidos`(
 `nombreProductos` varchar(100) ,
 `totalVentas` decimal(32,0) 
)*/;

/*Table structure for table `productos_vendidos_por_mes` */

DROP TABLE IF EXISTS `productos_vendidos_por_mes`;

/*!50001 DROP VIEW IF EXISTS `productos_vendidos_por_mes` */;
/*!50001 DROP TABLE IF EXISTS `productos_vendidos_por_mes` */;

/*!50001 CREATE TABLE  `productos_vendidos_por_mes`(
 `mes` int(2) ,
 `cantidadProductos` bigint(21) 
)*/;

/*Table structure for table `total_ventas_por_producto` */

DROP TABLE IF EXISTS `total_ventas_por_producto`;

/*!50001 DROP VIEW IF EXISTS `total_ventas_por_producto` */;
/*!50001 DROP TABLE IF EXISTS `total_ventas_por_producto` */;

/*!50001 CREATE TABLE  `total_ventas_por_producto`(
 `nombreProductos` varchar(100) ,
 `totalVentas` decimal(32,0) 
)*/;

/*Table structure for table `valor_facturas_cliente` */

DROP TABLE IF EXISTS `valor_facturas_cliente`;

/*!50001 DROP VIEW IF EXISTS `valor_facturas_cliente` */;
/*!50001 DROP TABLE IF EXISTS `valor_facturas_cliente` */;

/*!50001 CREATE TABLE  `valor_facturas_cliente`(
 `nombresCliente` varchar(100) ,
 `promedioValorFactura` decimal(14,4) 
)*/;

/*Table structure for table `ventas_por_cliente` */

DROP TABLE IF EXISTS `ventas_por_cliente`;

/*!50001 DROP VIEW IF EXISTS `ventas_por_cliente` */;
/*!50001 DROP TABLE IF EXISTS `ventas_por_cliente` */;

/*!50001 CREATE TABLE  `ventas_por_cliente`(
 `nombresCliente` varchar(100) ,
 `totalVentas` decimal(32,0) 
)*/;

/*View structure for view inventario_por_categoria */

/*!50001 DROP TABLE IF EXISTS `inventario_por_categoria` */;
/*!50001 DROP VIEW IF EXISTS `inventario_por_categoria` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventario_por_categoria` AS select `categoria`.`nombreCategoria` AS `nombreCategoria`,count(`productos`.`idProducto`) AS `totalProductos` from (`categoria` join `productos` on(`categoria`.`idCategoria` = `productos`.`nombreCategoria`)) group by `categoria`.`nombreCategoria` */;

/*View structure for view productos_mas_vendidos */

/*!50001 DROP TABLE IF EXISTS `productos_mas_vendidos` */;
/*!50001 DROP VIEW IF EXISTS `productos_mas_vendidos` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_mas_vendidos` AS select `productos`.`nombreProductos` AS `nombreProductos`,sum(`detallefactura`.`cantidad`) AS `totalVentas` from (`detallefactura` join `productos` on(`detallefactura`.`productos_idProducto` = `productos`.`idProducto`)) group by `productos`.`nombreProductos` order by sum(`detallefactura`.`cantidad`) desc limit 5 */;

/*View structure for view productos_vendidos_por_mes */

/*!50001 DROP TABLE IF EXISTS `productos_vendidos_por_mes` */;
/*!50001 DROP VIEW IF EXISTS `productos_vendidos_por_mes` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_vendidos_por_mes` AS select month(`factura`.`fechaFactura`) AS `mes`,count(`detallefactura`.`idDetalleFactura`) AS `cantidadProductos` from (`factura` join `detallefactura` on(`detallefactura`.`factura_idFactura` = `factura`.`idFactura`)) group by month(`factura`.`fechaFactura`) */;

/*View structure for view total_ventas_por_producto */

/*!50001 DROP TABLE IF EXISTS `total_ventas_por_producto` */;
/*!50001 DROP VIEW IF EXISTS `total_ventas_por_producto` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_ventas_por_producto` AS select `productos`.`nombreProductos` AS `nombreProductos`,sum(`detallefactura`.`cantidad`) AS `totalVentas` from (`detallefactura` join `productos` on(`detallefactura`.`productos_idProducto` = `productos`.`idProducto`)) group by `productos`.`nombreProductos` */;

/*View structure for view valor_facturas_cliente */

/*!50001 DROP TABLE IF EXISTS `valor_facturas_cliente` */;
/*!50001 DROP VIEW IF EXISTS `valor_facturas_cliente` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `valor_facturas_cliente` AS select `cliente`.`nombresCliente` AS `nombresCliente`,avg(`factura`.`valorTotalFactura`) AS `promedioValorFactura` from (`cliente` join `factura` on(`cliente`.`idCliente` = `factura`.`cliente_idCliente`)) group by `cliente`.`nombresCliente` */;

/*View structure for view ventas_por_cliente */

/*!50001 DROP TABLE IF EXISTS `ventas_por_cliente` */;
/*!50001 DROP VIEW IF EXISTS `ventas_por_cliente` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ventas_por_cliente` AS select `cliente`.`nombresCliente` AS `nombresCliente`,sum(`factura`.`valorTotalFactura`) AS `totalVentas` from (`cliente` join `factura` on(`factura`.`cliente_idCliente` = `cliente`.`idCliente`)) group by `cliente`.`nombresCliente` */;



/* Datos de demostración multi-tenant: cinco ferreterías y 25 productos por tienda */
-- Datos de demostracion para ferreterianuevo.
-- Crea cinco ferreterias, un administrador por ferreteria y 25 productos
-- por tienda: 20 propios y los mismos cinco productos compartidos.
-- El superadmin es global y ya existente; este script no lo crea ni modifica.
-- Compatible con MariaDB 10.4. Ejecutar una sola vez o volver a ejecutar
-- para completar datos faltantes sin duplicar slug, correo ni codigo por tienda.

USE `ferreterianuevo`;
SET NAMES utf8mb4;

CREATE TEMPORARY TABLE `seed_productos_demo` (
  `tenant_slug` varchar(160) NOT NULL,
  `codigoProducto` varchar(20) NOT NULL,
  `nombreProductos` varchar(100) NOT NULL,
  `valorProducto` decimal(10,2) NOT NULL,
  `stockProducto` int(11) NOT NULL,
  `descripcionProducto` varchar(250) NOT NULL,
  `nombreCategoria` int(11) NOT NULL,
  PRIMARY KEY (`tenant_slug`, `codigoProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `seed_productos_demo`
  (`tenant_slug`,`codigoProducto`,`nombreProductos`,`valorProducto`,`stockProducto`,`descripcionProducto`,`nombreCategoria`)
VALUES
  ('ferreteria-norte-demo','P001','Martillo de uña reforzado',28000,30,'Martillo de acero con mango antideslizante.',1),
  ('ferreteria-norte-demo','P002','Juego de destornilladores',42000,24,'Juego de puntas planas y Phillips.',1),
  ('ferreteria-norte-demo','P003','Alicate universal aislado',35000,20,'Alicate con mangos aislados para uso general.',1),
  ('ferreteria-norte-demo','P004','Llave ajustable 10 pulgadas',48000,18,'Llave ajustable cromada para trabajos de montaje.',1),
  ('ferreteria-norte-demo','P005','Cinta métrica 8 metros',19000,35,'Cinta métrica con freno y gancho magnético.',1),
  ('ferreteria-norte-demo','P006','Serrucho carpintero 20 pulgadas',39000,14,'Hoja de acero para cortes en madera.',5),
  ('ferreteria-norte-demo','P007','Nivel de aluminio 60 cm',32000,16,'Nivel con tres burbujas para instalación.',1),
  ('ferreteria-norte-demo','P008','Broca para concreto 8 mm',9000,50,'Broca de mampostería con punta de carburo.',4),
  ('ferreteria-norte-demo','P009','Extensión eléctrica 10 metros',52000,12,'Extensión doméstica con aislamiento reforzado.',9),
  ('ferreteria-norte-demo','P010','Linterna recargable LED',45000,17,'Linterna portátil con batería recargable.',9),
  ('ferreteria-norte-demo','P011','Pala cuadrada de acero',58000,11,'Pala para construcción con mango resistente.',8),
  ('ferreteria-norte-demo','P012','Tijera de podar manual',34000,19,'Tijera de jardinería con hoja de acero.',8),
  ('ferreteria-norte-demo','P013','Llave para tubo 12 pulgadas',62000,10,'Llave ajustable para trabajos de plomería.',7),
  ('ferreteria-norte-demo','P014','Rodillo para pintura 9 pulgadas',16000,28,'Rodillo de felpa para superficies lisas.',2),
  ('ferreteria-norte-demo','P015','Brocha plana 3 pulgadas',12000,32,'Brocha para aplicación uniforme de pintura.',2),
  ('ferreteria-norte-demo','P016','Lija para madera grano 120',3000,100,'Lija de grano medio para acabado de madera.',5),
  ('ferreteria-norte-demo','P017','Disco de corte 4.5 pulgadas',7000,45,'Disco abrasivo para corte de metal.',4),
  ('ferreteria-norte-demo','P018','Candado de seguridad 50 mm',26000,21,'Candado metálico con dos llaves.',9),
  ('ferreteria-norte-demo','P019','Manguera de jardín 15 metros',68000,9,'Manguera flexible para riego doméstico.',8),
  ('ferreteria-norte-demo','P020','Pistola para silicona',15000,25,'Aplicador manual para cartuchos de sellador.',9),

  ('ferreteria-central-demo','P001','Combo llave fija 8 piezas',76000,12,'Juego de llaves fijas métricas.',1),
  ('ferreteria-central-demo','P002','Llave de tubo 14 pulgadas',74000,10,'Llave para instalación y mantenimiento de tuberías.',7),
  ('ferreteria-central-demo','P003','Taladro percutor 650 W',245000,8,'Taladro eléctrico con función percutora.',4),
  ('ferreteria-central-demo','P004','Broca para madera 10 mm',11000,40,'Broca helicoidal para perforación de madera.',5),
  ('ferreteria-central-demo','P005','Disco de pulir 4.5 pulgadas',9500,35,'Disco abrasivo para pulido de superficies metálicas.',4),
  ('ferreteria-central-demo','P006','Careta para soldar',58000,9,'Protección facial para trabajos de soldadura.',9),
  ('ferreteria-central-demo','P007','Guantes de carnaza',22000,22,'Guantes resistentes para trabajos de taller.',9),
  ('ferreteria-central-demo','P008','Cincel plano 10 pulgadas',24000,16,'Cincel de acero para trabajos de construcción.',1),
  ('ferreteria-central-demo','P009','Formón para madera 1 pulgada',27000,14,'Formón de acero para carpintería.',5),
  ('ferreteria-central-demo','P010','Escuadra metálica 12 pulgadas',18000,20,'Escuadra para trazado y verificación de ángulos.',5),
  ('ferreteria-central-demo','P011','Cinta aislante eléctrica',4500,60,'Cinta aislante para reparaciones eléctricas.',4),
  ('ferreteria-central-demo','P012','Probador de voltaje',17000,18,'Herramienta compacta para comprobar tensión.',4),
  ('ferreteria-central-demo','P013','Sifón flexible para lavaplatos',21000,16,'Sifón flexible para instalación de desagüe.',7),
  ('ferreteria-central-demo','P014','Válvula de paso 1/2 pulgada',19000,15,'Válvula metálica para redes de agua.',7),
  ('ferreteria-central-demo','P015','Sellador acrílico blanco',14000,24,'Sellador para juntas interiores y acabados.',2),
  ('ferreteria-central-demo','P016','Pintura anticorrosiva gris',56000,10,'Recubrimiento para protección de superficies metálicas.',2),
  ('ferreteria-central-demo','P017','Llave Bristol 9 piezas',33000,13,'Juego de llaves hexagonales tipo Bristol.',1),
  ('ferreteria-central-demo','P018','Prensa de banco 4 pulgadas',185000,5,'Prensa de banco para sujetar piezas de trabajo.',1),
  ('ferreteria-central-demo','P019','Espátula flexible 4 pulgadas',13000,21,'Espátula para resanes y aplicación de masilla.',2),
  ('ferreteria-central-demo','P020','Rodillera de protección',38000,8,'Protección acolchada para trabajos en el suelo.',9),

  ('ferreteria-andinos-demo','P001','Pico de acero con mango',69000,10,'Pico para excavación y labores de construcción.',8),
  ('ferreteria-andinos-demo','P002','Barreta hexagonal 1.5 metros',85000,7,'Barreta de acero para palanca y demolición ligera.',1),
  ('ferreteria-andinos-demo','P003','Carretilla de obra',295000,4,'Carretilla con platón metálico y rueda reforzada.',8),
  ('ferreteria-andinos-demo','P004','Mezclador manual para pintura',18000,18,'Accesorio para mezclar pintura y recubrimientos.',2),
  ('ferreteria-andinos-demo','P005','Llana metálica lisa',24000,16,'Llana para aplicación y acabado de mortero.',3),
  ('ferreteria-andinos-demo','P006','Palustre para albañil',17000,20,'Palustre de acero para trabajos de mampostería.',3),
  ('ferreteria-andinos-demo','P007','Flotador para concreto',52000,8,'Herramienta para alisar superficies de concreto.',3),
  ('ferreteria-andinos-demo','P008','Malla para revoque',38000,12,'Malla de refuerzo para revestimientos y revoques.',3),
  ('ferreteria-andinos-demo','P009','Impermeabilizante acrílico',89000,9,'Recubrimiento para protección de superficies expuestas.',2),
  ('ferreteria-andinos-demo','P010','Cemento gris uso general',32000,40,'Cemento para mezclas y trabajos de construcción.',3),
  ('ferreteria-andinos-demo','P011','Arena lavada en saco',18000,30,'Agregado fino para mezclas de construcción.',3),
  ('ferreteria-andinos-demo','P012','Gravilla en saco',20000,28,'Agregado grueso para mezclas y reparaciones.',3),
  ('ferreteria-andinos-demo','P013','Plomada metálica',15000,14,'Herramienta para comprobar verticalidad.',1),
  ('ferreteria-andinos-demo','P014','Hilo para construcción',9000,35,'Hilo resistente para nivelación y trazado.',1),
  ('ferreteria-andinos-demo','P015','Regla de aluminio 2 metros',62000,7,'Regla recta para nivelación de superficies.',1),
  ('ferreteria-andinos-demo','P016','Manguera para nivel 20 metros',26000,11,'Manguera transparente para nivelación por agua.',1),
  ('ferreteria-andinos-demo','P017','Trompo mezclador manual',45000,9,'Accesorio manual para mezclar mortero y concreto.',3),
  ('ferreteria-andinos-demo','P018','Casco de seguridad',35000,15,'Casco ajustable para protección en obra.',9),
  ('ferreteria-andinos-demo','P019','Gafas de seguridad claras',12000,25,'Gafas de protección para trabajos generales.',9),
  ('ferreteria-andinos-demo','P020','Botas de caucho',78000,6,'Botas impermeables para trabajos de obra.',9),

  ('ferreteria-hogar-demo','P001','Grifo para lavamanos',98000,8,'Grifo cromado para instalación en lavamanos.',7),
  ('ferreteria-hogar-demo','P002','Ducha eléctrica 110 V',115000,7,'Ducha eléctrica con control de temperatura.',7),
  ('ferreteria-hogar-demo','P003','Regadera de mano',42000,12,'Regadera manual para ducha con soporte.',7),
  ('ferreteria-hogar-demo','P004','Cinta teflón para tubería',2500,80,'Cinta selladora para conexiones roscadas.',7),
  ('ferreteria-hogar-demo','P005','Flotador para tanque',22000,14,'Válvula flotadora para tanque de agua.',7),
  ('ferreteria-hogar-demo','P006','Cerradura de pomo',56000,10,'Cerradura para puerta interior con llaves.',9),
  ('ferreteria-hogar-demo','P007','Bisagra de acero 3 pulgadas',8500,40,'Bisagra metálica para puertas y muebles.',9),
  ('ferreteria-hogar-demo','P008','Topes para puerta',7000,25,'Tope de caucho para proteger puertas y paredes.',9),
  ('ferreteria-hogar-demo','P009','Bombillo LED 12 W',9500,35,'Bombillo LED de luz blanca para uso doméstico.',4),
  ('ferreteria-hogar-demo','P010','Portalámpara de techo',6500,30,'Portalámpara para instalación en techo.',4),
  ('ferreteria-hogar-demo','P011','Tomacorriente doble',12000,22,'Tomacorriente doble para instalación residencial.',4),
  ('ferreteria-hogar-demo','P012','Interruptor sencillo',8000,26,'Interruptor de pared para iluminación.',4),
  ('ferreteria-hogar-demo','P013','Masilla para pared 1 kg',11000,28,'Masilla para reparación de pequeñas imperfecciones.',2),
  ('ferreteria-hogar-demo','P014','Sellador acrílico para baño',16000,20,'Sellador para juntas y acabados en el baño.',9),
  ('ferreteria-hogar-demo','P015','Cortina de baño',32000,9,'Cortina impermeable para baño doméstico.',9),
  ('ferreteria-hogar-demo','P016','Organizador plástico 5 litros',18000,15,'Caja plástica para almacenamiento del hogar.',9),
  ('ferreteria-hogar-demo','P017','Llave para lavaplatos',45000,10,'Llave de agua para instalación en lavaplatos.',7),
  ('ferreteria-hogar-demo','P018','Manguera de lavadora',22000,13,'Manguera flexible para conexión de lavadora.',7),
  ('ferreteria-hogar-demo','P019','Canaleta eléctrica 2 metros',14500,24,'Canaleta para organizar cableado interior.',4),
  ('ferreteria-hogar-demo','P020','Extensión doméstica 5 metros',29000,12,'Extensión eléctrica para uso doméstico.',4),

  ('ferreteria-tornillo-demo','P001','Tornillo para madera 1 pulgada',300,500,'Tornillo galvanizado para ensamble de madera.',6),
  ('ferreteria-tornillo-demo','P002','Tornillo para madera 2 pulgadas',500,400,'Tornillo galvanizado de mayor longitud.',6),
  ('ferreteria-tornillo-demo','P003','Tornillo autoperforante',350,450,'Tornillo punta broca para lámina y perfiles.',6),
  ('ferreteria-tornillo-demo','P004','Tornillo drywall',180,600,'Tornillo fosfatado para instalación de drywall.',6),
  ('ferreteria-tornillo-demo','P005','Perno hexagonal 1/4 pulgada',900,250,'Perno de acero con cabeza hexagonal.',6),
  ('ferreteria-tornillo-demo','P006','Tuerca hexagonal 1/4 pulgada',250,400,'Tuerca de acero para perno de 1/4 pulgada.',6),
  ('ferreteria-tornillo-demo','P007','Arandela plana 1/4 pulgada',120,500,'Arandela metálica para distribuir presión.',6),
  ('ferreteria-tornillo-demo','P008','Chazo plástico 1/4 pulgada',180,500,'Chazo plástico para fijación en mampostería.',6),
  ('ferreteria-tornillo-demo','P009','Anclaje metálico expansivo',2500,80,'Anclaje metálico para fijaciones resistentes.',6),
  ('ferreteria-tornillo-demo','P010','Puntilla de acero 1 pulgada',250,500,'Puntilla para fijación general en madera.',6),
  ('ferreteria-tornillo-demo','P011','Puntilla de acero 2 pulgadas',400,400,'Puntilla de mayor longitud para carpintería.',6),
  ('ferreteria-tornillo-demo','P012','Grapa para madera',120,700,'Grapa metálica para tapicería y madera.',6),
  ('ferreteria-tornillo-demo','P013','Remache pop 1/8 pulgada',300,350,'Remache de aluminio para unión de láminas.',6),
  ('ferreteria-tornillo-demo','P014','Varilla roscada 1/4 pulgada',12000,18,'Varilla roscada para fijaciones y soportes.',6),
  ('ferreteria-tornillo-demo','P015','Abrazadera metálica 1 pulgada',1800,120,'Abrazadera para sujeción de mangueras y tubos.',6),
  ('ferreteria-tornillo-demo','P016','Escuadra de ensamble pequeña',2200,100,'Escuadra metálica para unión de muebles.',6),
  ('ferreteria-tornillo-demo','P017','Cáncamo cerrado 1/4 pulgada',1500,90,'Cáncamo roscado para puntos de sujeción.',6),
  ('ferreteria-tornillo-demo','P018','Gancho roscado 2 pulgadas',1200,100,'Gancho metálico para colgar objetos.',6),
  ('ferreteria-tornillo-demo','P019','Pasador metálico 3 pulgadas',6500,25,'Pasador para cierre de puertas y portones.',9),
  ('ferreteria-tornillo-demo','P020','Bisagra de piano 30 cm',14500,16,'Bisagra continua para puertas y cajas.',9),

  ('ferreteria-norte-demo','P021','Guantes de trabajo',12000,40,'Guantes resistentes para labores de ferretería.',9),
  ('ferreteria-central-demo','P021','Guantes de trabajo',12000,40,'Guantes resistentes para labores de ferretería.',9),
  ('ferreteria-andinos-demo','P021','Guantes de trabajo',12000,40,'Guantes resistentes para labores de ferretería.',9),
  ('ferreteria-hogar-demo','P021','Guantes de trabajo',12000,40,'Guantes resistentes para labores de ferretería.',9),
  ('ferreteria-tornillo-demo','P021','Guantes de trabajo',12000,40,'Guantes resistentes para labores de ferretería.',9),

  ('ferreteria-norte-demo','P022','Cinta métrica 5 metros',14000,35,'Cinta métrica retráctil para medición.',1),
  ('ferreteria-central-demo','P022','Cinta métrica 5 metros',14000,35,'Cinta métrica retráctil para medición.',1),
  ('ferreteria-andinos-demo','P022','Cinta métrica 5 metros',14000,35,'Cinta métrica retráctil para medición.',1),
  ('ferreteria-hogar-demo','P022','Cinta métrica 5 metros',14000,35,'Cinta métrica retráctil para medición.',1),
  ('ferreteria-tornillo-demo','P022','Cinta métrica 5 metros',14000,35,'Cinta métrica retráctil para medición.',1),

  ('ferreteria-norte-demo','P023','Silicona transparente',16000,25,'Sellador de silicona para juntas y reparaciones.',9),
  ('ferreteria-central-demo','P023','Silicona transparente',16000,25,'Sellador de silicona para juntas y reparaciones.',9),
  ('ferreteria-andinos-demo','P023','Silicona transparente',16000,25,'Sellador de silicona para juntas y reparaciones.',9),
  ('ferreteria-hogar-demo','P023','Silicona transparente',16000,25,'Sellador de silicona para juntas y reparaciones.',9),
  ('ferreteria-tornillo-demo','P023','Silicona transparente',16000,25,'Sellador de silicona para juntas y reparaciones.',9),

  ('ferreteria-norte-demo','P024','Brocha plana 2 pulgadas',9000,30,'Brocha para aplicación de pintura y selladores.',2),
  ('ferreteria-central-demo','P024','Brocha plana 2 pulgadas',9000,30,'Brocha para aplicación de pintura y selladores.',2),
  ('ferreteria-andinos-demo','P024','Brocha plana 2 pulgadas',9000,30,'Brocha para aplicación de pintura y selladores.',2),
  ('ferreteria-hogar-demo','P024','Brocha plana 2 pulgadas',9000,30,'Brocha para aplicación de pintura y selladores.',2),
  ('ferreteria-tornillo-demo','P024','Brocha plana 2 pulgadas',9000,30,'Brocha para aplicación de pintura y selladores.',2),

  ('ferreteria-norte-demo','P025','Candado de seguridad',22000,20,'Candado metálico con llaves para uso general.',9),
  ('ferreteria-central-demo','P025','Candado de seguridad',22000,20,'Candado metálico con llaves para uso general.',9),
  ('ferreteria-andinos-demo','P025','Candado de seguridad',22000,20,'Candado metálico con llaves para uso general.',9),
  ('ferreteria-hogar-demo','P025','Candado de seguridad',22000,20,'Candado metálico con llaves para uso general.',9),
  ('ferreteria-tornillo-demo','P025','Candado de seguridad',22000,20,'Candado metálico con llaves para uso general.',9);

START TRANSACTION;

INSERT INTO `tenants`
  (`nombre`,`slug`,`documento`,`correo`,`telefono`,`direccion`,`estado`)
VALUES
  ('Ferretería Norte Demo','ferreteria-norte-demo','900000001','contacto.norte@demo.invalid','3000000001','Bogotá, Colombia','Activo'),
  ('Ferretería Central Demo','ferreteria-central-demo','900000002','contacto.central@demo.invalid','3000000002','Medellín, Colombia','Activo'),
  ('Ferretería Andinos Demo','ferreteria-andinos-demo','900000003','contacto.andinos@demo.invalid','3000000003','Pasto, Colombia','Activo'),
  ('Ferretería Hogar Demo','ferreteria-hogar-demo','900000004','contacto.hogar@demo.invalid','3000000004','Cali, Colombia','Activo'),
  ('Ferretería Tornillo Demo','ferreteria-tornillo-demo','900000005','contacto.tornillo@demo.invalid','3000000005','Barranquilla, Colombia','Activo')
ON DUPLICATE KEY UPDATE `slug` = VALUES(`slug`);

INSERT INTO `usuario`
  (`tipoDocumentoUsuario`,`documentoUsuario`,`nombresUsuario`,`apellidosUsuario`,`correo`,`claveUsuario`,`estadoUsuario`,`rol_idRol`,`fotoPerfil`,`tenant_id`)
SELECT seed.`tipoDocumento`, seed.`documento`, seed.`nombres`, seed.`apellidos`,
       seed.`correo`, seed.`clave`, 'Activo', 1, NULL, t.`id`
FROM (
  SELECT 'CC' AS `tipoDocumento`, '900000001' AS `documento`, 'Carlos' AS `nombres`, 'Norte Demo' AS `apellidos`, 'admin.norte@demo.invalid' AS `correo`, '$2y$10$mgEICkO6kDrA9/.H4V4pCOkeXK9Ovi5FscumgVSj9I5GJk9yXUBR.' AS `clave`, 'ferreteria-norte-demo' AS `tenant_slug`
  UNION ALL SELECT 'CC','900000002','Camila','Central Demo','admin.central@demo.invalid','$2y$10$UqcVv0kpC6G2iVrFuuab0.jVvTgJzV9TpGmQKqQmszKvLqZXU/OH.','ferreteria-central-demo'
  UNION ALL SELECT 'CC','900000003','Andrés','Andinos Demo','admin.andinos@demo.invalid','$2y$10$MF2fg6RZB7JsW8KluDYsoOq5PDQUSt.d.QWAMKYt7.7HPNh3ak/Mu','ferreteria-andinos-demo'
  UNION ALL SELECT 'CC','900000004','Laura','Hogar Demo','admin.hogar@demo.invalid','$2y$10$l8tbNCc7cBo3WvPCBRbkVenz93UKwxLcTEup/E9rdUUqh18kOKO4.','ferreteria-hogar-demo'
  UNION ALL SELECT 'CC','900000005','Diego','Tornillo Demo','admin.tornillo@demo.invalid','$2y$10$gEButUXf8/CR0MO0JOzHA.ftDEBBmsOuARXaZQ33MNvaNwaeH4T2m','ferreteria-tornillo-demo'
) AS seed
JOIN `tenants` t ON t.`slug` = seed.`tenant_slug`
WHERE NOT EXISTS (
  SELECT 1 FROM `usuario` u WHERE u.`correo` = seed.`correo`
);

INSERT INTO `productos`
  (`codigoProducto`,`nombreProductos`,`valorProducto`,`stockProducto`,`descripcionProducto`,`nombreCategoria`,`imagen`,`tenant_id`)
SELECT seed.`codigoProducto`, seed.`nombreProductos`, seed.`valorProducto`,
       seed.`stockProducto`, seed.`descripcionProducto`, seed.`nombreCategoria`,
       NULL, t.`id`
FROM `seed_productos_demo` seed
JOIN `tenants` t ON t.`slug` = seed.`tenant_slug`
WHERE NOT EXISTS (
  SELECT 1
  FROM `productos` p
  WHERE p.`tenant_id` = t.`id`
    AND p.`codigoProducto` = seed.`codigoProducto`
);

COMMIT;

DROP TEMPORARY TABLE `seed_productos_demo`;

-- Verificar resultado: cada ferreteria debe tener un administrador y 25 productos.
SELECT t.`id`, t.`nombre`, t.`slug`,
       COUNT(DISTINCT CASE WHEN u.`rol_idRol` = 1 THEN u.`idUsuario` END) AS `administradores`,
       COUNT(DISTINCT p.`idProducto`) AS `productos`
FROM `tenants` t
LEFT JOIN `usuario` u ON u.`tenant_id` = t.`id` AND u.`rol_idRol` = 1
LEFT JOIN `productos` p ON p.`tenant_id` = t.`id`
WHERE t.`slug` IN (
  'ferreteria-norte-demo',
  'ferreteria-central-demo',
  'ferreteria-andinos-demo',
  'ferreteria-hogar-demo',
  'ferreteria-tornillo-demo'
)
GROUP BY t.`id`, t.`nombre`, t.`slug`
ORDER BY t.`slug`;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
