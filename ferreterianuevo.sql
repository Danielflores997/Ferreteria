-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2026 a las 04:04:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ferreterianuevo`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Compras_Superiores` ()   BEGIN
SELECT c.nombre, c.apellido, SUM(d.precio * v.cantidad) AS total_compras
FROM clientes c
JOIN ventas v ON c.id_cliente = v.id_cliente
JOIN detalles_venta d ON v.id_venta = d.id_venta
GROUP BY c.nombre, c.apellido
HAVING total_compras > 100000;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Productos_Bajo_Stock` ()   BEGIN
    SELECT nombreProductos, stockProducto
    FROM productos
    WHERE stockProducto < 10;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Productos_Vendidos` ()   BEGIN
SELECT p.nombre, SUM(d.cantidad) AS total_vendido
FROM productos p
JOIN detalles_venta d ON p.id_producto = d.id_producto
JOIN ventas v ON d.id_venta = v.id_venta
WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
GROUP BY p.nombre
ORDER BY total_vendido DESC
LIMIT 6;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `uno` ()   BEGIN
	
  
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Ventas_Categoria_Mes` ()   BEGIN
SELECT c.nombre AS categoria, SUM(d.precio * v.cantidad) AS total_ventas
FROM ventas v
JOIN detalles_venta d ON v.id_venta = d.id_venta
JOIN productos p ON d.id_producto = p.id_producto
JOIN categorias c ON p.id_categoria = c.id_categoria
WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
GROUP BY c.nombre;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombreCategoria` varchar(100) NOT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombreCategoria`, `tenant_id`) VALUES
(1, 'HERRAMIENTAS', 1),
(2, 'PINTURAS', 1),
(3, 'CEMENTOS', 1),
(4, 'HERRAMIENTAS ELECTRICAS', 1),
(5, 'CARPINTERIA', 1),
(6, 'TORNILLLERIA', 1),
(7, 'PLOMERIA', 1),
(8, 'JARDINERIA', 1),
(9, 'ACCESORIOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `tipoDocumentoCliente` enum('CC','TI','CE') NOT NULL DEFAULT 'CC',
  `documentoCliente` varchar(20) NOT NULL,
  `nombresCliente` varchar(100) NOT NULL,
  `apellidosCliente` varchar(100) NOT NULL,
  `telefonoCliente` varchar(20) NOT NULL,
  `direccionCliente` varchar(100) NOT NULL,
  `estadoCliente` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `tipoDocumentoCliente`, `documentoCliente`, `nombresCliente`, `apellidosCliente`, `telefonoCliente`, `direccionCliente`, `estadoCliente`, `tenant_id`) VALUES
(1, 'TI', '21243534', 'Juan', 'Pérez', '3157568987', 'Calle 321, Ciudad', 'Activo', 1),
(2, 'CC', '987654321', 'María', 'Gómez', '9876543210', 'Carrera 456, Ciudad', 'Inactivo', 1),
(3, 'CC', '246813579', 'Carlos', 'López', '2468135790', 'Avenida 789, Ciudad', 'Activo', 1),
(4, 'CC', '135792468', 'Laura', 'Rodríguez', '1357924680', 'Calle 567, Ciudad', 'Activo', 1),
(5, 'CC', '864209753', 'Ana', 'Ramírez', '8642097530', 'Carrera 890, Ciudad', 'Inactivo', 1),
(6, 'CC', '579642813', 'Andrés', 'Sánchez', '5796428130', 'Avenida 1234, Ciudad', 'Activo', 1),
(7, 'CC', '310725846', 'Sofía', 'Torres', '3107258460', 'Calle 5678, Ciudad', 'Inactivo', 1),
(8, 'CC', '951462807', 'Alejandro', 'Castro', '9514628070', 'Carrera 9012, Ciudad', 'Activo', 1),
(9, 'CC', '207536184', 'Andrea', 'Morales', '2075361840', 'Avenida 3456, Ciudad', 'Inactivo', 1),
(10, 'CC', '468175923', 'David', 'Jiménez', '4681759230', 'Calle 7890, Ciudad', 'Activo', 1),
(11, 'CC', '726943851', 'Natalia', 'Herrera', '7269438510', 'Carrera 12345, Ciudad', 'Inactivo', 1),
(12, 'CC', '358291674', 'Roberto', 'Ortega', '3582916740', 'Avenida 67890, Ciudad', 'Activo', 1),
(13, 'CC', '612835947', 'Carolina', 'Vargas', '6128359470', 'Calle 12345, Ciudad', 'Activo', 1),
(14, 'CC', '973461528', 'Luis', 'Castro', '9734615280', 'Carrera 67890, Ciudad', 'Inactivo', 1),
(15, 'CC', '245890173', 'Laura', 'Molina', '2458901730', 'Avenida 123456, Ciudad	', 'Activo', 1),
(16, 'CC', '481357926', 'José', 'Ríos', '4813579260', 'Calle 789012, Ciudad', 'Inactivo', 1),
(17, 'CC', '936427510', 'Daniela', 'Guzmán', '9364275100', 'Carrera 345678, Ciudad', 'Activo', 1),
(18, 'CC', '719264583', 'Pedro', 'Silva', '7192645830', 'Avenida 901234, Ciudad', 'Inactivo', 1),
(19, 'CC', '205819347', 'Andrés', 'Rojas', '2058193470', 'Carrera 2367, Ciudad', 'Inactivo', 1),
(21, 'CC', '1000320746', 'daniel', 'flores', '8152606466', '522 Mcdounough st', 'Inactivo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `usuario_id`, `producto_id`, `cantidad`, `fecha`, `tenant_id`) VALUES
(1, 20, 63, 1, '2024-03-02 04:36:51', 1),
(2, 20, 2, 1, '2024-03-02 04:36:51', 1),
(3, 20, 1, 1, '2024-03-02 04:36:51', 1),
(4, 20, 10, 1, '2024-03-03 04:36:51', 1),
(5, 22, 31, 1, '2024-03-04 04:37:41', 1),
(6, 22, 39, 1, '2024-03-04 04:37:41', 1),
(7, 22, 44, 1, '2024-03-05 04:37:41', 1),
(8, 22, 42, 1, '2024-03-07 04:37:41', 1),
(9, 22, 4, 1, '2024-03-14 04:37:41', 1),
(10, 22, 60, 2, '2024-03-16 04:37:41', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

CREATE TABLE `detallefactura` (
  `idDetalleFactura` int(11) NOT NULL,
  `factura_idFactura` int(11) NOT NULL,
  `productos_idProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valorProductoVenta` decimal(10,0) NOT NULL,
  `totalDetalle` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallefactura`
--

INSERT INTO `detallefactura` (`idDetalleFactura`, `factura_idFactura`, `productos_idProducto`, `cantidad`, `valorProductoVenta`, `totalDetalle`) VALUES
(1, 1, 5, 2, 25000, 50000),
(2, 1, 1, 1, 15000, 15000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `idDetallePedido` int(11) NOT NULL,
  `cantidadPedido` int(11) NOT NULL,
  `producto_idProducto` int(11) NOT NULL,
  `totalDetallePedido` decimal(10,0) NOT NULL,
  `pedido_idPedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`idDetallePedido`, `cantidadPedido`, `producto_idProducto`, `totalDetallePedido`, `pedido_idPedido`) VALUES
(1, 3, 1, 58999, 1),
(2, 2, 5, 650000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `idFactura` int(11) NOT NULL,
  `fechaFactura` date NOT NULL,
  `subtotalfactura` decimal(10,0) NOT NULL,
  `impuesto` int(11) NOT NULL,
  `valorTotalFactura` decimal(10,0) NOT NULL,
  `cliente_idCliente` int(11) NOT NULL,
  `usuario_idUsuario` int(11) NOT NULL,
  `pedido_idPedido` int(11) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`idFactura`, `fechaFactura`, `subtotalfactura`, `impuesto`, `valorTotalFactura`, `cliente_idCliente`, `usuario_idUsuario`, `pedido_idPedido`, `tenant_id`) VALUES
(1, '2023-06-11', 258900, 15, 890000, 12, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `inventario_por_categoria`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `inventario_por_categoria` (
`nombreCategoria` varchar(100)
,`totalProductos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `fechaPedido` date NOT NULL,
  `cliente_idCliente` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idPedido`, `fechaPedido`, `cliente_idCliente`, `tenant_id`) VALUES
(1, '2023-06-30', 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `Nombre` varchar(20) DEFAULT NULL,
  `Apellido` varchar(20) DEFAULT NULL,
  `Direccion` varchar(50) DEFAULT NULL,
  `Telefono` int(20) DEFAULT NULL,
  `Correo` varchar(50) DEFAULT NULL,
  `Motivo` varchar(250) DEFAULT NULL,
  `Estado` enum('Si','No') DEFAULT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peticiones`
--

INSERT INTO `peticiones` (`Nombre`, `Apellido`, `Direccion`, `Telefono`, `Correo`, `Motivo`, `Estado`, `tenant_id`) VALUES
('daniel', 'flores', '522 Mcdounough st', 2147483647, 'daniflores@gmail.com', 'a david no le funcionan los mensajes para quejarse, ayudenlo plis', 'Si', 1),
('armando', 'pizos', '522 Mcdounough st', 2147483647, 'armandopizos@hotmail.com', 'Mensaje con 100 caracteres:\r\n\"Producto defectuoso, exijo un reemplazo.\"\r\n\r\nMensaje con 150 caractere', 'No', 1),
('cristian', 'gray', 'kr 13f este 91b 17 sur', 313, 'cristian@gmail.com', 'el martillo no martilla bien', 'No', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(11) NOT NULL,
  `codigoProducto` varchar(20) NOT NULL,
  `nombreProductos` varchar(100) NOT NULL,
  `valorProducto` decimal(10,2) NOT NULL,
  `stockProducto` int(11) NOT NULL,
  `descripcionProducto` varchar(250) NOT NULL,
  `nombreCategoria` int(11) NOT NULL,
  `imagen` varchar(250) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `codigoProducto`, `nombreProductos`, `valorProducto`, `stockProducto`, `descripcionProducto`, `nombreCategoria`, `imagen`, `tenant_id`) VALUES
(1, 'P001', 'Martillo Thompson', 20000.00, 40, 'De bola mango anti deslizante', 1, 'https://www.electromanferonline.com/2262-large_default/martillo-cabeza-bola-de-bronce-1-12-lb-cabo-fibra.jpg', 1),
(2, 'P002', 'Destornillador Stanley', 10000.00, 85, 'Estornillador Punta plana Color Negro', 1, 'https://iprpartesyrepuestos.com/wp-content/uploads/2018/09/510-0009-3.jpg', 1),
(3, 'P003', 'Taladro Makita', 150000.00, 20, 'Capacidad de Broquero (13MM)', 4, 'https://belltec.com.co/6754-large_default/taladro-de-rotacion-38-makita-450-watts-6413.jpg\r\n', 1),
(4, 'P004', 'Cinta Métrica Stanley', 8000.00, 100, 'Cubierta Negra apto para carpinteria', 1, 'https://belltec.com.co/16912-large_default/cinta-metrica-global-plus-8-mts-1pulg-stanley-30626.jpg\r\n', 1),
(5, 'P005', 'Llave Ajustable Incolma', 18000.00, 40, 'Acero inoxidable para tuerca de 18\'\'', 1, 'https://belltec.com.co/11417-large_default/llave-ajustable-6-pulgadas-cromada-stanley-87431.jpg\r\n', 1),
(6, 'P006', 'Sierra de Mano GRÜNTEK', 30000.00, 30, 'Apto para jardineria y mango de madera de roble', 4, 'https://m.media-amazon.com/images/I/61mVXBtQkkL.jpg\r\n', 1),
(7, 'P007', 'Brocas BLACK & DECKER', 12000.00, 60, 'Brocas para manposteria de 1/8\"', 1, 'https://www.incolma.com/wp-content/uploads/2022/04/Brocas-HSS-Barracuda-e1624672193286.png', 1),
(8, 'P008', 'Clavos Incolma', 5000.00, 200, 'Clavos Punta de acero para pared tipo pesado', 5, 'https://i0.wp.com/pinturasyyesos.com/wp-content/uploads/2021/02/clavos-corsan-comun.jpg?fit=800%2C800&ssl=1\r\n', 1),
(9, 'P009', 'Pintura Vinitex Pintuco', 35000.00, 15, 'Especialmente para exteriores y proteccion UV', 2, 'https://www.pinturastorcaza.com/wp-content/uploads/2020/03/poliuretano-pg-compressed.jpg\r\n', 1),
(10, 'P010', 'Guantes de Trabajo KIM', 10000.00, 50, 'Protección anti-fluido y tipo pesado', 9, 'https://static.stihl.com/upload/assetmanager/modell_imagefilename/scaled/zoom/bf2132560e4b48ffb236e0d96c62e3d6.jpg\r\n', 1),
(11, 'P011', 'Sierra Circular Dewalt', 250000.00, 10, 'Sierra de 5500 RPM tipo industrial Amarillo', 4, 'https://plazavea.vteximg.com.br/arquivos/ids/21436393-512-512/image-9ae83aea62204d93ab09113f4e414731.jpg', 1),
(12, 'P012', 'Llave de Tubo Stanley', 22000.00, 35, 'Apto para todo tipo de tuberia antioxidante', 7, 'https://www.reedmfgco.com/assets/Images/Products/Wrenches/Pipe-Wrenches-Heavy-Duty-Straight/02120-RW8-RGB__PadWzEyODAsODQ2LCJGRkZGRkYiLDBd.jpg\r\n', 1),
(13, 'P013', 'Pegamento Carpincol', 8000.00, 80, 'Adhesivo exclusivo para madera ', 3, 'https://www.electromanferonline.com/730-large_default/boxer-evoluci%C3%B3n-x-gal%C3%B3n.jpg\r\n', 1),
(14, 'P014', 'Lija Abracol', 5000.00, 150, 'Lija de agua con papel para madera y acrilico', 5, 'https://ferreteriaonlinelevallejoaz.com/wp-content/uploads/2021/04/350.jpg', 1),
(15, 'P015', 'Tornillos Incolma', 6000.00, 100, 'Punta de acero especialmente para pared de concreto', 6, 'https://schecomex.com/wp-content/uploads/2020/09/Tornillos-para-madera-.jpg\r\n', 1),
(16, 'P016', 'Taladro Inalámbrico Stanley', 180000.00, 25, 'Larga duracion y adaptable al trabajo rutinario', 4, 'https://dotacionesadomicilio.com/wp-content/uploads/2022/04/taladro-inalambrico-dewalt-20v-nuevo-original-dotaciones-a-domicilio-15.jpg\r\n', 1),
(17, 'P017', 'Nivel Incolma', 40000.00, 20, 'Preciso y multimedida de color Gris plata', 1, 'https://perusupply.com/218-large_default/nivel-de-mano-24-truper.jpg\r\n', 1),
(18, 'P018', 'Pinzas Stanley', 15000.00, 45, 'Antioxidante y de caucho anti desplizante', 1, 'https://i0.wp.com/pinturasyyesos.com/wp-content/uploads/2021/02/alicate-8-pretul.jpg?fit=800%2C800&ssl=1\r\n', 1),
(19, 'P019', 'Serrucho GRÜNTEK', 25000.00, 30, 'Mayor precision y mas durabilidad', 5, 'https://jpdrywallsystem.com/wp-content/uploads/2019/11/serrucho.jpg\r\n', 1),
(20, 'P020', 'Escuadra Fabell Castell', 10000.00, 70, 'Acero anti-oxidable numeracion clara', 1, 'https://www.dateriumsystem.com/appfiles/clientes/308/catalogo/ESCUADRA-ACERO-MANGO-ALUMINIO-ALYCO-197392-PRINCIPAL.jpg\r\n', 1),
(21, 'P021', 'Cepillo Metálico Incolma', 12000.00, 60, 'Limpieza profunda con cerdas de titanio', 1, 'https://rodapin.com/wp-content/uploads/2021/04/48200-cepillo-metalico-curvo-estandar.jpg\r\n', 1),
(22, 'P022', 'Pala Stanley', 55000.00, 10, 'Multiproposito para construccion y jardineria', 1, 'https://codecam.com.co/wp-content/uploads/2021/07/PALA-ANTICHISPA-scaled.jpg\r\n', 1),
(23, 'P023', 'Tijeras de Podar Stanley', 25000.00, 25, 'Mango flexible color negro metalizado', 8, 'https://guantesterry.com/wp-content/uploads/2019/08/TIJERA-PODA-7-BELLOTA.jpg\r\n', 1),
(24, 'P024', 'Grifo Bocherinni', 50000.00, 10, 'Cubierta de plata apto para la cocina', 7, 'https://www.ferreteriabervar.com/cdn/shop/products/GRIFO_CORNETA_BRONCE_1_2_47d39945-28b6-4378-b16c-5d23d6e9fd2a.png?v=1660225900', 1),
(25, 'P025', 'Linterna Phillips', 15000.00, 40, 'Recargable de tecnologia LED y mayor distancia', 1, 'https://losvictorinos.co/cdn/shop/products/Linterna_tactica_recargable_P50_VTR-193_9.png?v=1680125631', 1),
(26, 'P026', 'Cerradura YALE', 20000.00, 30, 'Calibre pesado para exteriores Blanca', 9, 'https://ps.felinux.co/456-large_default/cerradura-de-seguridad-auxiliar-antitaladro-mha.jpg\r\n', 1),
(27, 'P027', 'Soplete Ingrill', 45000.00, 20, 'Apto para ahumadores nuestro kit soplete, fácil y cómodo a la hora de usarlo.', 7, 'https://ferreteriatecnica.co/cdn/shop/products/SOPLETE-2200-DREMEL_800x.jpg?v=1613568517', 1),
(29, 'P029', 'Cables Eléctricos Centelsa', 10000.00, 100, 'Cable de cobre tipo 8 rollo de 100 mts', 1, 'https://bricable.com/wp-content/themes/bricable-theme/imgs/caja_bricable.jpg', 1),
(30, 'P030', 'Destornillador de Precisión', 15000.00, 50, 'Herramienta', 1, 'https://img.pccomponentes.com/articles/5/54609/startech-kit-destornilladores-precision.jpg\r\n', 1),
(31, 'P031', 'Pintura Blanca Kolor', 25000.00, 10, 'Especialmente para exteriores y antideslizante', 2, 'https://admintienda.coval.com.co/backend/admin/backend/web/archivosDelCliente/items/images/20210602120033-INTERIOR-PAREDES-Vinilico-Blanco-Caneca-5-Galones-Ico-850202106021200335145.jpg\r\n', 1),
(32, 'P032', 'Taladro Percutor Black and Decker', 95000.00, 10, 'Naranja especialmente para trabajo tipo pesado', 4, 'https://www.loencuentras.com.co/1389-large_default/taladro-percutor-12-profesional-850-w-.jpg\r\n', 1),
(33, 'P033', 'Martillo de Carpintero Incolma', 13000.00, 40, 'Martillo Para Roble y MDF', 1, 'https://m.media-amazon.com/images/I/31BUQrbTgpL.jpg', 1),
(34, 'P034', 'Pintura en Aerosol Vinitex', 19000.00, 40, 'Anti fluidos y mayor durabilidad', 2, 'https://i.linio.com/p/c79f94590f73dde1443ee1be3151a737-product.jpg\r\n', 1),
(35, 'P035', 'Cemento Gris Cemex', 29000.00, 45, 'Cemento Para Construccion tipo Portland', 3, 'https://ferropaz.com/img/p/3/7/37-thickbox_default.jpg\r\n', 1),
(36, 'P036', 'Cemento Blanco Corona', 35000.00, 20, 'Cemento Para Ceramica de secado facil', 3, 'https://centroferreteromafer.com/wp-content/uploads/2019/06/CEMENTO-BLANCO-ARGOS.jpg\r\n', 1),
(37, 'P037', 'Pulidora Para Pisos Abracol', 110000.00, 9, 'Disco Fino para mayor brillo ', 4, 'https://i0.wp.com/aspiradoras-ventas.com/wp-content/uploads/sites/5/2020/08/D-2015-1.jpg?fit=600%2C600&ssl=1', 1),
(38, 'P038', 'Varsol Para Madera Alaska', 10000.00, 50, 'disolvente efectivo para diluir pinturas a base deaceite', 5, 'https://pisolimpio.com.co/wp-content/uploads/3815.jpg\r\n', 1),
(39, 'P039', 'Rodillo Para Pintura Goya', 10000.00, 60, 'Rodillo Para Pintar Fachadas mango anti desplizante', 2, 'https://m.media-amazon.com/images/I/61-CXpx5LvL.jpg\r\n', 1),
(40, 'P040', 'Mortero Holcim', 23000.00, 35, 'Mezcla Facil para interiores', 3, 'https://cdn.homedepot.com.mx/productos/981862/981862-z.jpg\r\n', 1),
(41, 'P041', 'Adhesivo Para Ceramica Corona', 25000.00, 20, 'Pegante Especial Para Todo Tipo De Ceramica', 3, 'https://www.argos.com.pa/wp-content/uploads/2021/09/pegamento-ceramica.jpg\r\n', 1),
(42, 'P042', 'Brocha Goya', 5000.00, 40, 'Mango de madera y mas resistente', 2, 'https://m.media-amazon.com/images/I/71YmeD-PlEL._AC_UF894,1000_QL80_.jpg', 1),
(43, 'P043', 'Espatula Goya', 6000.00, 30, 'Mayor Acabo En Interiores', 2, 'https://www.herragro.com/shop/152-large_default/espatula-flexible-2.jpg\r\n', 1),
(44, 'P044', 'Diluyente de Pintura Alaska', 10000.00, 15, 'Retirar La Pintura En Materiales Delicadas', 2, 'https://d2o812a6k13pkp.cloudfront.net/fit-in/455x455/Productos/40386088_0120220525095101.jpg', 1),
(45, 'P045', 'Grava', 15000.00, 150, 'Complemento Para Construccion En General', 3, 'https://www.materialesmae.com/ferreteria-cuautitlan/grava-texcoco.jpg\r\n', 1),
(46, 'P046', 'Arena', 15000.00, 150, 'Complemento Para Construccion En General', 3, 'https://static5.depositphotos.com/1006597/458/i/450/depositphotos_4585145-stock-photo-pile-of-sand.jpg\r\n', 1),
(47, 'P047', 'Cepillo Electrico Dewalt', 80000.00, 15, 'Elimina Las Impuras Facilmente 700 W', 4, 'https://belltec.com.co/11133-large_default/cepillo-makita-kp0800.jpg\r\n', 1),
(48, 'P048', 'Sierra Caladora Bauker', 100000.00, 50, '800 w + 2 hojas de repuesto + Laser Rojo', 4, 'https://www.atrial.com.co/wp-content/uploads/2021/05/sierra-caladora-profesional-550-w-7da.jpg\r\n', 1),
(49, 'P049', 'Tornillo Cabeza Hexagonal Incolma', 1000.00, 100, 'Aptos Para Los Muebles', 6, 'https://hechitools.com/cdn/shop/products/LLADEDETRINQUETEEXTENDIBLET7214.jpg?v=1651768820\r\n', 1),
(50, 'P050', 'Tornillo Autoroscante Incolma', 500.00, 200, 'Facil Para Ajustar Cuadros', 6, 'https://www.fisa.com.co/496-home_default/juego-llaves-fijas-86-970-stanley.jpg\r\n', 1),
(51, 'P051', 'Tornillo de Fijacion Incolma', 600.00, 100, 'Aptos Para Fijar Estructuras Metalicas', 6, 'https://thorsmex.mx/wp-content/uploads/2022/08/tornillo-cabeza-plana.jpg', 1),
(52, 'P052', 'Tornillo de Acero inoxidable Incolma', 1000.00, 200, 'Aptos Para Exteriores', 6, 'https://m.media-amazon.com/images/I/61Iv8YrXkLL._AC_UF894,1000_QL80_.jpg', 1),
(53, 'P053', 'Tornillo de Rosca Metrica Incolma', 350.00, 50, 'Apto para Vehiculos Y Motos', 6, 'https://blog.bextok.com/wp-content/uploads/2017/03/iStock-529328169-e1490544032846.jpg', 1),
(54, 'P054', 'Codo PVC Pavco Wavin', 2500.00, 30, 'Exclusivo Para Transporte de Agua Potable', 1, 'https://d2j6dbq0eux0bg.cloudfront.net/images/28326070/2880507065.jpg\r\n', 1),
(55, 'P055', 'Tubo de Cobre', 10000.00, 150, 'Para el calentador 1/2\" 6 Mts', 7, 'https://cdn.homedepot.com.mx/productos/625300/625300-d.jpg\r\n', 1),
(56, 'P056', 'Tubo flexible Pavco Wavin', 3000.00, 50, 'TUBO PVC AGUA 3/4\" 5 M C/R PAVCO', 7, 'https://akl.com.pe/805-large_default/tubo-pvc-agua-34-5-m-cr-pavco.jpg', 1),
(57, 'P057', 'Sifon Grival', 5000.00, 30, 'Sifón flexible Grival 1½” y 1¼” para lavamanos y lavaplatos', 7, 'https://admintienda.coval.com.co/backend/admin/backend/web/archivosDelCliente/items/images/20220311122908-COMPLEMENTOS-SIFONES-Sifon-en-P-Gris-con-adaptador-Grival-2090202203111229089270.jpg\r\n', 1),
(58, 'P058', 'Rastrillo Incolma', 8000.00, 30, 'Para barrer el cesped Dientes antioxidantes', 8, 'https://zummar.com/wp-content/uploads/2022/06/rastrillo-jardinero-16-dientes-mango-6-fibra-de-vidrio-truper-R-16AMF.jpg', 1),
(59, 'P059', 'Guantes Para Jardineria KIM', 5000.00, 45, 'Para Proteger de Las Ramas Rotas Color Amarillo', 8, 'https://bosquesa.com.do/website_files/products/8.jpg\r\n', 1),
(60, 'P060', 'Regadera Incolma', 10000.00, 25, 'Para Hidratar Las Plantas verde jungla', 1, 'https://www.ecured.cu/images/3/33/Regaderaaa2.jpg\r\n', 1),
(61, 'P061', 'llave YALE', 3000.00, 8, 'Anti oxidante Plateado para tipo pesado', 1, 'https://www.cofan.es/images/content/1024x682/web1_31309999_01.jpg', 1),
(62, 'P062', 'pintura negra Kolor', 31000.00, 10, 'para superficies externas para el carro y moto', 2, 'https://s.cornershopapp.com/product-images/232590.jpg', 1),
(63, 'P063', 'Base para bombillo SKAFTET', 7800.00, 5, 'base para bombillo para el escritorio', 1, 'https://http2.mlstatic.com/D_NQ_NP_849936-MLV70505450149_072023-O.webp', 1),
(97, 'T001', 'Taladro El Tornillo Pro', 180000.00, 15, 'Taladro industrial exclusivo', 4, 'https://belltec.com.co/6754-large_default/taladro-de-rotacion-38-makita-450-watts-6413.jpg', 2),
(98, 'T002', 'Martillo El Tornillo', 25000.00, 30, 'Martillo profesional', 1, 'https://www.electromanferonline.com/2262-large_default/martillo-cabeza-bola-de-bronce-1-12-lb-cabo-fibra.jpg', 2),
(99, 'U001', 'Llave La Tuerca', 20000.00, 25, 'Llave ajustable premium', 1, 'https://belltec.com.co/11417-large_default/llave-ajustable-6-pulgadas-cromada-stanley-87431.jpg', 3);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_mas_vendidos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `productos_mas_vendidos` (
`nombreProductos` varchar(100)
,`totalVentas` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `productos_vendidos_por_mes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `productos_vendidos_por_mes` (
`mes` int(2)
,`cantidadProductos` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idProveedor` int(11) NOT NULL,
  `nombreProveedor` varchar(100) NOT NULL,
  `apellidoProveedor` varchar(100) NOT NULL,
  `telefonoProveedor` varchar(20) NOT NULL,
  `direccionProveedor` varchar(100) NOT NULL,
  `correoProveedor` varchar(45) NOT NULL,
  `tenant_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idProveedor`, `nombreProveedor`, `apellidoProveedor`, `telefonoProveedor`, `direccionProveedor`, `correoProveedor`, `tenant_id`) VALUES
(3566769, 'Ferromaq', '', '777-333-9999', 'Avenida de los Flores 877', 'ferromaq@gmail.com', 1),
(3783678, 'Suministros', 'Martínez', '666-777-8888', 'Paseo de la Montaña 567', 'ventas@suministrosmartinez.com', 1),
(7986614, 'Ferretería', 'Luna', '555-222-1111', 'Calle de la Luna 234', 'contacto@ferreterialuna.com', 1),
(8737837, 'Materiales', 'Rivas', '555-555-5555', 'Plaza Mayor 789', 'contacto@materialesrivas.com', 1),
(8975757, 'Proveedora daniel', 'Vargas', '555-888-9999', 'Avenida de la Playa 78', 'ventas@proveedoravargas.com', 1),
(9874576, 'Suministros', 'Herrera', '555-666-4444', 'Paseo del Bosque 567', 'info@suministrosherrera.com', 1),
(18165164, 'Ferreacero', 'Conway', '3187659087', 'Calle Principal 321', 'info@ferreacero23.com', 1),
(23556457, 'Ferretería', 'Torres', '555-444-3333', 'Calle de los Pinos 123', 'ventas@ferreteriatorres.com', 1),
(25383783, 'Herrajes', 'López', '555-987-6543', 'Avenida del Sol 654', 'ventas@herrajeslopez.com', 1),
(27867452, 'Ferretería', 'Gómez', '555-111-2222', 'Calle del Parque 234', 'info@ferreteriagomez.com', 1),
(34556435, 'Proveedora', 'Pacheco', '555-444-2222', 'Plaza de la Fuente 456', 'ventas@proveedorapacheco.com', 1),
(54653525, 'Comercial', 'Ferroplast', '555-666-7777', 'Plaza del Mercado 456', 'info@comercialferroplast.com', 1),
(96574216, 'Ferretería', 'Silva', '555-222-7777', 'Avenida de las Palmas 890', 'ventas@ferreteriasilva.com', 1),
(903465434, 'Comercial', 'Morales', '555-888-5555', 'Calle del Río 123', 'contacto@comercialmorales.com', 1),
(1000320746, 'daniel', 'Conway', '8152606466', '522 Mcdounough st', 'contacto23@ferromaq.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombreRol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombreRol`) VALUES
(1, 'Adminstrador'),
(2, 'Vendedor'),
(3, 'SuperAdmin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tenants`
--

CREATE TABLE `tenants` (
  `idTenant` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tenants`
--

INSERT INTO `tenants` (`idTenant`, `nombre`, `slug`, `logo`, `correo`, `telefono`, `direccion`, `estado`, `fecha_creacion`) VALUES
(1, 'Ferretería Meissen', 'meissen', '/Ferreteria-mvc/imagenes/tenants/meissen.png', 'contacto@meissen.com', '3001112233', 'Calle 1 #23-45', 'Activo', '2026-10-12 18:36:30'),
(2, 'Ferretería El Tornillo', 'tornillo', '/Ferreteria-mvc/imagenes/tenants/tornillo.jpg', 'contacto@tornillo.com', '3004445566', 'Carrera 7 #12-34', 'Activo', '2026-10-12 18:36:30'),
(3, 'Ferretería La Tuerca', 'tuerca', '/Ferreteria-mvc/imagenes/tenants/tuerca.jpg', 'contacto@tuerca.com', '3007778899', 'Avenida 5 #67-89', 'Activo', '2026-10-12 18:36:30');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `total_ventas_por_producto`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `total_ventas_por_producto` (
`nombreProductos` varchar(100)
,`totalVentas` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `tipoDocumentoUsuario` enum('CC','TI','CE') NOT NULL DEFAULT 'CC',
  `documentoUsuario` int(20) NOT NULL,
  `nombresUsuario` varchar(100) NOT NULL,
  `apellidosUsuario` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `claveUsuario` varchar(50) NOT NULL,
  `estadoUsuario` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `rol_idRol` int(11) NOT NULL,
  `fotoPerfil` varchar(250) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `tipoDocumentoUsuario`, `documentoUsuario`, `nombresUsuario`, `apellidosUsuario`, `correo`, `claveUsuario`, `estadoUsuario`, `rol_idRol`, `fotoPerfil`, `tenant_id`) VALUES
(1, 'TI', 99752136, 'Juan    ', 'Pérez    ', 'juanperez@gmail.com', 'juan369', 'Activo', 2, NULL, 1),
(2, 'CC', 987654321, 'María   ', 'López    ', 'maria.lopez@example.com', 'maria5678', 'Inactivo', 2, NULL, 1),
(3, 'CE', 12345678, 'Carlos  ', 'Gómez    ', 'carlos.gomez@example.com', 'carlos9823', 'Activo', 2, NULL, 1),
(4, 'CC', 789123456, 'Pedro   ', 'Ramírez  ', 'pedroramirez@example.com', 'pedro5309', 'Inactivo', 1, NULL, 1),
(5, 'CC', 321654987, 'Ana     ', 'Rodríguez| ', 'Rodríguez@example.com', 'ana2716', 'Activo', 2, NULL, 1),
(6, 'CE', 87654321, 'Andrés  ', 'Silva    ', 'Silva@example.com', 'andres4992', 'Inactivo', 2, NULL, 1),
(7, 'CC', 654987321, 'Carolina', 'Vargas', 'carolina.vargas@example.com', 'carolina7248', 'Activo', 2, NULL, 1),
(8, 'CC', 234567891, 'Daniel  ', 'Martínez ', 'daniel.martinez@example.com', 'daniel2083', 'Inactivo', 2, NULL, 1),
(9, 'CC', 987654321, 'José    ', 'Castro   ', 'jose.castro@example.com', 'jose7529', 'Inactivo', 2, NULL, 1),
(10, 'CC', 456789123, 'Alejandro', 'Gómez', 'alejandrogomez@example.com', 'alejandro6165', 'Activo', 1, NULL, 1),
(11, 'CC', 789123456, 'Andrea', 'Herrera', 'andreaherrera@example.com', 'andreaherrera', 'Activo', 2, NULL, 1),
(12, 'CC', 321654987, 'Andrés  ', 'González ', 'Gonzalez@example.com', 'andres9614', 'Inactivo', 2, NULL, 1),
(13, 'CC', 1000320746, 'Daniel Mauricio', 'Flores Rueda', 'daniflores5492@gmail.com', 'daniel', 'Activo', 1, 'https://www.mundodeportivo.com/alfabeta/hero/2023/11/halo-infinite.1699531337.9737.jpg?width=768&aspect_ratio=16:9&format=nowebp', 1),
(14, 'CC', 27867867, 'carolina', 'rueda', 'adrianiyarueda@gmail.com', '1234', 'Activo', 2, 'https://img.freepik.com/vector-premium/angel-dibujos-animados-halo-fondo-rosa_712485-1527.jpg', 1),
(20, 'CC', 3543645, 'armando', 'pizos', 'casas23@gmail.com', '23', 'Activo', 0, 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDABQODxIPDRQSEBIXFRQYHjIhHhwcHj0sLiQySUBMS0dARkVQWnNiUFVtVkVGZIhlbXd7gYKBTmCNl4x9lnN+gXz/2wBDARUXFx4aHjshITt8U0ZTfHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHx8fHz/wAARCAJ5AaYDASI', 1),
(22, 'CC', 342435345, 'timmy', 'torner', 'padrinos@gmail.com', 'cosmo', 'Activo', 0, 'https://cdn.pixabay.com/photo/2022/07/22/10/42/man-7337829_640.jpg', 1),
(25, 'CC', 987654321, 'Super', 'Admin', 'superadmin@ferreterias.com', '123456', 'Activo', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `valor_facturas_cliente`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `valor_facturas_cliente` (
`nombresCliente` varchar(100)
,`promedioValorFactura` decimal(14,4)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idVenta` int(11) NOT NULL,
  `idcodigo` varchar(45) NOT NULL,
  `producto` varchar(45) DEFAULT NULL,
  `precio_unitario` int(45) DEFAULT NULL,
  `cantidad` int(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `Categoria` varchar(45) DEFAULT NULL,
  `fecha_venta` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVenta`, `idcodigo`, `producto`, `precio_unitario`, `cantidad`, `descripcion`, `Categoria`, `fecha_venta`) VALUES
(1, 'P068', 'llaves respuesto', 60000, 10, 'llaves con mucha fuerza', '5', '2024-02-17'),
(2, 'P001', 'martillo', 35000, 8, 'para clavos', '1', '2024-02-18'),
(3, 'P001', 'Martillo', 35000, 8, 'llaves con mucha fuerza', '1', '2024-02-19'),
(4, 'P001', 'Martillo', 35000, 10, 'llaves con mucha fuerza', '1', '2024-02-20'),
(6, 'P063', 'Base para bombillo', 35000, 3, 'fluorecente', '1', '2024-02-20'),
(8, 'P064', 'caja fuerte', 15000, 3, 'muy fuerte', '1', '2024-03-06');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ventas_por_cliente`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `ventas_por_cliente` (
`nombresCliente` varchar(100)
,`totalVentas` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `inventario_por_categoria`
--
DROP TABLE IF EXISTS `inventario_por_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inventario_por_categoria`  AS SELECT `categoria`.`nombreCategoria` AS `nombreCategoria`, count(`productos`.`idProducto`) AS `totalProductos` FROM (`categoria` join `productos` on(`categoria`.`idCategoria` = `productos`.`nombreCategoria`)) GROUP BY `categoria`.`nombreCategoria` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_mas_vendidos`
--
DROP TABLE IF EXISTS `productos_mas_vendidos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_mas_vendidos`  AS SELECT `productos`.`nombreProductos` AS `nombreProductos`, sum(`detallefactura`.`cantidad`) AS `totalVentas` FROM (`detallefactura` join `productos` on(`detallefactura`.`productos_idProducto` = `productos`.`idProducto`)) GROUP BY `productos`.`nombreProductos` ORDER BY sum(`detallefactura`.`cantidad`) DESC LIMIT 0, 5 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `productos_vendidos_por_mes`
--
DROP TABLE IF EXISTS `productos_vendidos_por_mes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `productos_vendidos_por_mes`  AS SELECT month(`factura`.`fechaFactura`) AS `mes`, count(`detallefactura`.`idDetalleFactura`) AS `cantidadProductos` FROM (`factura` join `detallefactura` on(`detallefactura`.`factura_idFactura` = `factura`.`idFactura`)) GROUP BY month(`factura`.`fechaFactura`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `total_ventas_por_producto`
--
DROP TABLE IF EXISTS `total_ventas_por_producto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_ventas_por_producto`  AS SELECT `productos`.`nombreProductos` AS `nombreProductos`, sum(`detallefactura`.`cantidad`) AS `totalVentas` FROM (`detallefactura` join `productos` on(`detallefactura`.`productos_idProducto` = `productos`.`idProducto`)) GROUP BY `productos`.`nombreProductos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `valor_facturas_cliente`
--
DROP TABLE IF EXISTS `valor_facturas_cliente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `valor_facturas_cliente`  AS SELECT `cliente`.`nombresCliente` AS `nombresCliente`, avg(`factura`.`valorTotalFactura`) AS `promedioValorFactura` FROM (`cliente` join `factura` on(`cliente`.`idCliente` = `factura`.`cliente_idCliente`)) GROUP BY `cliente`.`nombresCliente` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `ventas_por_cliente`
--
DROP TABLE IF EXISTS `ventas_por_cliente`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ventas_por_cliente`  AS SELECT `cliente`.`nombresCliente` AS `nombresCliente`, sum(`factura`.`valorTotalFactura`) AS `totalVentas` FROM (`cliente` join `factura` on(`factura`.`cliente_idCliente` = `cliente`.`idCliente`)) GROUP BY `cliente`.`nombresCliente` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD PRIMARY KEY (`idDetalleFactura`),
  ADD KEY `factura_idFactura` (`factura_idFactura`),
  ADD KEY `productos_idProducto` (`productos_idProducto`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`idDetallePedido`),
  ADD KEY `pedido_idPedido` (`pedido_idPedido`),
  ADD KEY `producto_idProducto` (`producto_idProducto`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`idFactura`),
  ADD KEY `cliente_idCliente` (`cliente_idCliente`),
  ADD KEY `usuario_idUsuario` (`usuario_idUsuario`),
  ADD KEY `pedido_idPedido` (`pedido_idPedido`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `cliente_idCliente` (`cliente_idCliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `categoria_idCategoria` (`nombreCategoria`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idProveedor`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`idTenant`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `rol_idRol` (`rol_idRol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  MODIFY `idDetalleFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `idDetallePedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `idFactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000320747;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tenants`
--
ALTER TABLE `tenants`
  MODIFY `idTenant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `detallefactura_ibfk_1` FOREIGN KEY (`factura_idFactura`) REFERENCES `factura` (`idFactura`),
  ADD CONSTRAINT `detallefactura_ibfk_2` FOREIGN KEY (`productos_idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`pedido_idPedido`) REFERENCES `pedido` (`idPedido`),
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`producto_idProducto`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`cliente_idCliente`) REFERENCES `cliente` (`idCliente`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `factura_ibfk_3` FOREIGN KEY (`pedido_idPedido`) REFERENCES `pedido` (`idPedido`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`cliente_idCliente`) REFERENCES `cliente` (`idCliente`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`nombreCategoria`) REFERENCES `categoria` (`idCategoria`);

--
-- Filtros para la tabla `rol`
--
ALTER TABLE `rol`
  ADD CONSTRAINT `rol_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `usuario` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
