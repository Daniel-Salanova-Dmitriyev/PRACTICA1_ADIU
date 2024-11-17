-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2024 a las 16:12:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd2oracle`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `procedure_3Avisos` ()   BEGIN
	INSERT INTO aviso (avi_titulo, avi_descripcion, avi_fecha, avi_con_id, avi_ven_id, avi_lin_id) VALUES ("INCIDENCIA 1" ,"DESC 1", CURRENT_TIMESTAMP, 1,1,1)
	,("INCIDENCIA 2" ,"DESC 2", CURRENT_TIMESTAMP, 1,1,1),("INCIDENCIA 3" ,"DESC 3", CURRENT_TIMESTAMP, 1,1,1);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procedure_cambiarEstado` (`vendedor` INT(5))   BEGIN
	DECLARE avisos int;
	DECLARE cursorAviso CURSOR FOR select COUNT(avi_id) AS avisos from aviso where avi_ven_id = vendedor;
	
	OPEN cursorAviso;
		fetch cursorAviso into avisos;
	CLOSE cursorAviso;
	
	IF avisos > 3 THEN
		IF avisos < 6 THEN
			UPDATE vendedor SET ven_estado = "SOSPECHOSO" where ven_id = vendedor;
		ELSE
			UPDATE vendedor SET ven_estado = "MALO" where ven_id = vendedor;
		END IF;
    	END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auxlinea`
--

CREATE TABLE `auxlinea` (
  `axl_id` int(20) NOT NULL,
  `axl_cantidad` int(3) NOT NULL,
  `axl_almacen` tinyint(1) NOT NULL,
  `axl_diaSinLlegar` int(2) NOT NULL,
  `axl_axp_id` int(15) NOT NULL,
  `axl_vnt_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auxlinea`
--

INSERT INTO `auxlinea` (`axl_id`, `axl_cantidad`, `axl_almacen`, `axl_diaSinLlegar`, `axl_axp_id`, `axl_vnt_id`) VALUES
(3, 1, 0, 2, 2, 1),
(4, 1, 0, 2, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auxpedido`
--

CREATE TABLE `auxpedido` (
  `axp_id` int(15) NOT NULL,
  `axp_fecha` date NOT NULL,
  `axp_pagado` tinyint(1) NOT NULL,
  `axp_tarjeta` varchar(25) NOT NULL,
  `axp_estado` varchar(25) NOT NULL,
  `axp_com_id` int(5) NOT NULL,
  `axp_dom_id` int(15) NOT NULL,
  `axp_dis_id` int(2) DEFAULT NULL,
  `axp_rep_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auxpedido`
--

INSERT INTO `auxpedido` (`axp_id`, `axp_fecha`, `axp_pagado`, `axp_tarjeta`, `axp_estado`, `axp_com_id`, `axp_dom_id`, `axp_dis_id`, `axp_rep_id`) VALUES
(2, '2023-12-14', 1, '312312', 'Pagado', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aviso`
--

CREATE TABLE `aviso` (
  `avi_id` int(5) NOT NULL,
  `avi_titulo` varchar(25) NOT NULL,
  `avi_descripcion` varchar(200) NOT NULL,
  `avi_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `avi_con_id` int(5) NOT NULL,
  `avi_ven_id` int(5) NOT NULL,
  `avi_lin_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aviso`
--

INSERT INTO `aviso` (`avi_id`, `avi_titulo`, `avi_descripcion`, `avi_fecha`, `avi_con_id`, `avi_ven_id`, `avi_lin_id`) VALUES
(1, 'INCIDENCIA 1', 'DESC 1', '2023-12-14 06:55:31', 1, 1, 1),
(2, 'INCIDENCIA 2', 'DESC 2', '2023-12-14 06:55:31', 1, 1, 1),
(3, 'INCIDENCIA 3', 'DESC 3', '2023-12-14 06:55:31', 1, 1, 1),
(4, 'INCIDENCIA 1', 'DESC 1', '2023-12-14 06:56:05', 1, 1, 1),
(5, 'INCIDENCIA 2', 'DESC 2', '2023-12-14 06:56:05', 1, 1, 1),
(6, 'INCIDENCIA 3', 'DESC 3', '2023-12-14 06:56:05', 1, 1, 1),
(7, 'INCIDENCIA 1', 'DESC 1', '2023-12-14 06:56:17', 1, 1, 1),
(8, 'INCIDENCIA 2', 'DESC 2', '2023-12-14 06:56:17', 1, 1, 1),
(9, 'INCIDENCIA 3', 'DESC 3', '2023-12-14 06:56:17', 1, 1, 1);

--
-- Disparadores `aviso`
--
DELIMITER $$
CREATE TRIGGER `trigger_cambiarEstado` BEFORE INSERT ON `aviso` FOR EACH ROW BEGIN
	call procedure_cambiarEstado(NEW.avi_ven_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calle`
--

CREATE TABLE `calle` (
  `cal_id` int(20) NOT NULL,
  `cal_nombre` varchar(50) NOT NULL,
  `cal_codigoPostal` int(5) NOT NULL,
  `cal_ciu_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calle`
--

INSERT INTO `calle` (`cal_id`, `cal_nombre`, `cal_codigoPostal`, `cal_ciu_id`) VALUES
(1, 'Calle Prado', 7011, 1),
(2, 'Calle Argentina', 7011, 1),
(3, 'Calle Pascual', 7011, 1),
(4, 'Calle Testing', 7011, 1),
(5, 'Calle Fofo', 7011, 1),
(6, 'Calle Madrid', 7012, 2),
(7, 'Texas Street', 9231, 3),
(8, 'Dallas Street', 3123, 4),
(9, 'Paris Carrer', 4321, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `ciu_id` int(10) NOT NULL,
  `ciu_nombre` varchar(25) NOT NULL,
  `ciu_coordenadas` varchar(12) NOT NULL,
  `ciu_zonaHoraria` varchar(12) NOT NULL,
  `ciu_pai_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`ciu_id`, `ciu_nombre`, `ciu_coordenadas`, `ciu_zonaHoraria`, `ciu_pai_id`) VALUES
(1, 'Barcelona', 'X12-Y23-Z32', 'UTC+0', 3),
(2, 'Madrid', 'X12-Y23-Z32', 'UTC+0', 3),
(3, 'Texas', 'X12-Y23-Z32', 'UTC-5', 1),
(4, 'Dallas', 'X12-Y23-Z32', 'UTC-8', 1),
(5, 'Paris', 'X12-Y23-Z32', 'UTC+0', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `cmt_id` int(20) NOT NULL,
  `cmt_descripcion` varchar(200) NOT NULL,
  `cmt_fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cmt_com_id` int(5) NOT NULL,
  `cmt_pro_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`cmt_id`, `cmt_descripcion`, `cmt_fecha`, `cmt_com_id`, `cmt_pro_id`) VALUES
(1, 'dasda', '2023-12-14 16:37:11', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprador`
--

CREATE TABLE `comprador` (
  `com_id` int(5) NOT NULL,
  `com_dni` varchar(15) NOT NULL,
  `com_nombre` varchar(25) NOT NULL,
  `com_apellido1` varchar(50) NOT NULL,
  `com_apellido2` varchar(50) DEFAULT NULL,
  `com_usuario` varchar(25) NOT NULL,
  `com_contraseña` varchar(25) NOT NULL,
  `com_telefono` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comprador`
--

INSERT INTO `comprador` (`com_id`, `com_dni`, `com_nombre`, `com_apellido1`, `com_apellido2`, `com_usuario`, `com_contraseña`, `com_telefono`) VALUES
(1, '123456789G', 'Pepe', 'Santolome', NULL, 'pepe', 'pepe', '123456789'),
(2, 'dani', 'dani', 'dani', NULL, 'dani', 'dani', 'dani');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlador`
--

CREATE TABLE `controlador` (
  `con_id` int(5) NOT NULL,
  `con_nombre` varchar(25) NOT NULL,
  `con_apellido1` varchar(50) NOT NULL,
  `con_apellido2` varchar(50) DEFAULT NULL,
  `con_usuario` varchar(25) NOT NULL,
  `con_contraseña` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `controlador`
--

INSERT INTO `controlador` (`con_id`, `con_nombre`, `con_apellido1`, `con_apellido2`, `con_usuario`, `con_contraseña`) VALUES
(1, 'con1', 'con1', 'con1', 'con1', 'con1'),
(2, 'c1', 'c1', 'c1', 'c1', 'c1'),
(3, 'dani', 'dani', 'dani', 'dani', 'dani');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distribuidora`
--

CREATE TABLE `distribuidora` (
  `dis_id` int(2) NOT NULL,
  `dis_nombre` varchar(25) NOT NULL,
  `dis_zog_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `distribuidora`
--

INSERT INTO `distribuidora` (`dis_id`, `dis_nombre`, `dis_zog_id`) VALUES
(1, 'Correos', 2),
(2, 'Seur', 2),
(3, 'Delivery Go', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilio`
--

CREATE TABLE `domicilio` (
  `dom_id` int(20) NOT NULL,
  `dom_numero` int(5) NOT NULL,
  `dom_letra` varchar(1) DEFAULT NULL,
  `dom_bloque` varchar(5) DEFAULT NULL,
  `dom_cal_id` int(20) NOT NULL,
  `dom_com_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `domicilio`
--

INSERT INTO `domicilio` (`dom_id`, `dom_numero`, `dom_letra`, `dom_bloque`, `dom_cal_id`, `dom_com_id`) VALUES
(1, 14, 'B', '', 6, 1),
(2, 14, '', '', 8, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `inc_id` int(20) NOT NULL,
  `inc_titulo` varchar(25) NOT NULL,
  `inc_descripcion` varchar(200) NOT NULL,
  `inc_tin_id` int(2) NOT NULL,
  `inc_ped_id` int(15) NOT NULL,
  `inc_ped_rep_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incidencia`
--

INSERT INTO `incidencia` (`inc_id`, `inc_titulo`, `inc_descripcion`, `inc_tin_id`, `inc_ped_id`, `inc_ped_rep_id`) VALUES
(1, 'tit1', 'desc1', 1, 1, 1),
(2, 'tit1', 'desc1', 4, 1, 1),
(3, 'tit1', 'desc1', 4, 1, 1),
(4, 'tit1', 'desc1', 4, 1, 1);

--
-- Disparadores `incidencia`
--
DELIMITER $$
CREATE TRIGGER `trigger_incidencia` AFTER INSERT ON `incidencia` FOR EACH ROW BEGIN
	DECLARE incidencias int(25);
	DECLARE tipo varchar(50);
	DECLARE cursorIncidencia CURSOR FOR select count(inc_id) AS contador FROM incidencia INNER JOIN tipoincidencia ON inc_tin_id = tin_id WHERE tin_nombre = "Comprador no encontrado" AND inc_ped_id = NEW.inc_ped_id;
	DECLARE cursorNombre CURSOR FOR select tin_nombre from tipoincidencia WHERE tin_id = NEW.inc_tin_id;
	
	OPEN cursorIncidencia;
		FETCH cursorIncidencia into incidencias;
	CLOSE cursorIncidencia;
	
	OPEN cursorNombre;
		FETCH cursorNombre into tipo;
	CLOSE cursorNombre;

	IF incidencias >= 3 THEN
		UPDATE pedido SET ped_estado = "Devolucion" WHERE ped_id = NEW.inc_ped_id;
	ELSE
		UPDATE pedido SET ped_estado = tipo WHERE ped_id = NEW.inc_ped_id;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea`
--

CREATE TABLE `linea` (
  `lin_id` int(20) NOT NULL,
  `lin_cantidad` int(3) NOT NULL,
  `lin_almacen` tinyint(1) DEFAULT 0,
  `lin_diaSinLlegar` int(2) DEFAULT 0,
  `lin_ped_id` int(15) NOT NULL,
  `lin_pro_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `linea`
--

INSERT INTO `linea` (`lin_id`, `lin_cantidad`, `lin_almacen`, `lin_diaSinLlegar`, `lin_ped_id`, `lin_pro_id`) VALUES
(1, 9, 0, 452, 1, 1),
(2, 1, 0, 452, 1, 2),
(3, 1, 0, 449, 2, 1),
(4, 1, 0, 449, 2, 2),
(5, 10, 0, 194, 3, 3),
(6, 1, 0, 0, 4, 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `lineasinllegar`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `lineasinllegar` (
`lin_id` int(20)
,`lin_cantidad` int(3)
,`lin_almacen` tinyint(1)
,`lin_diaSinLlegar` int(2)
,`lin_ped_id` int(15)
,`lin_pro_id` int(15)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `pai_id` int(3) NOT NULL,
  `pai_zog_id` int(2) NOT NULL,
  `pai_nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`pai_id`, `pai_zog_id`, `pai_nombre`) VALUES
(1, 1, 'Estado Unidos'),
(2, 1, 'Canada'),
(3, 2, 'España'),
(4, 2, 'Francia'),
(5, 3, 'Egipto'),
(6, 4, 'Kazajistan'),
(7, 5, 'Peru'),
(8, 6, 'Mexico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `ped_id` int(15) NOT NULL,
  `ped_fecha` date NOT NULL,
  `ped_pagado` tinyint(1) NOT NULL,
  `ped_tarjeta` varchar(25) NOT NULL,
  `ped_estado` varchar(25) NOT NULL,
  `ped_com_id` int(5) NOT NULL,
  `ped_dom_id` int(15) NOT NULL,
  `ped_dis_id` int(2) DEFAULT NULL,
  `ped_rep_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`ped_id`, `ped_fecha`, `ped_pagado`, `ped_tarjeta`, `ped_estado`, `ped_com_id`, `ped_dom_id`, `ped_dis_id`, `ped_rep_id`) VALUES
(1, '2023-12-11', 1, '31233123', 'Devolucion', 1, 1, 1, 1),
(2, '2023-12-14', 1, '312312', 'Pagado', 1, 1, NULL, NULL),
(3, '2023-12-14', 1, '3123213', 'Pagado', 1, 1, NULL, NULL),
(4, '2024-11-16', 1, '3213123', 'Pagado', 2, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `pro_id` int(10) NOT NULL,
  `pro_nombre` varchar(25) NOT NULL,
  `pro_descripcion` varchar(100) NOT NULL,
  `pro_medidas` varchar(25) NOT NULL,
  `pro_color` varchar(25) NOT NULL,
  `pro_imagen` varchar(25) NOT NULL,
  `pro_cantidad` int(3) NOT NULL,
  `pro_precio` int(4) NOT NULL,
  `pro_oferta` tinyint(1) NOT NULL,
  `pro_descuento` int(2) NOT NULL,
  `pro_ven_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`pro_id`, `pro_nombre`, `pro_descripcion`, `pro_medidas`, `pro_color`, `pro_imagen`, `pro_cantidad`, `pro_precio`, `pro_oferta`, `pro_descuento`, `pro_ven_id`) VALUES
(1, 'collar', 'dasda', '12', 'rojo', 'collar.jpg', 9, 100, 1, 25, 1),
(2, 'blusa', 'dasda', '12', 'blanco', 'blusa.jpg', 8, 100, 0, 25, 1),
(3, 'botas', 'dasda', '12', 'negro', 'botas.jpg', 0, 100, 1, 25, 1),
(4, 'camisa', 'dasda', '12', 'azul', 'camisa.jpg', 10, 100, 0, 25, 1),
(5, 'ps4', 'dasda', '12', 'rojo', 'ps4.jpg', 10, 100, 1, 25, 1),
(6, 'xbox', 'dasda', '12', 'blanco', 'xbox.jpg', 10, 100, 0, 25, 1),
(7, 'switch', 'dasda', '12', 'negro', 'switch.jpg', 10, 100, 0, 25, 1),
(8, 'psp', 'dasda', '12', 'azul', 'psp.jpg', 10, 100, 0, 25, 1),
(9, 'la fuente de vallecas', 'dasda', '12', 'rojo', 'vallecas.jpg', 10, 100, 0, 25, 1),
(10, 'quijote', 'dasda', '12', 'blanco', 'quijote.jpg', 10, 100, 0, 25, 1),
(11, 'marina', 'dasda', '12', 'negro', 'marina.jpg', 10, 100, 1, 25, 1),
(12, 'tres sombreros de copa', 'dasda', '12', 'azul', 'sombreros.jpg', 10, 100, 0, 25, 1),
(13, 'manzana', 'dasda', '12', 'rojo', 'manzana.jpg', 10, 100, 0, 25, 1),
(14, 'naranja', 'dasda', '12', 'blanco', 'naranja.jpg', 10, 100, 1, 25, 1),
(15, 'platano', 'dasda', '12', 'negro', 'platano.jpg', 10, 100, 0, 25, 1),
(16, 'kiwi', 'dasda', '12', 'azul', 'kiwi.jpg', 10, 100, 0, 25, 1),
(17, 'collar', 'dasda', '12', 'rojo', 'collar.jpg', 10, 85, 1, 25, 2),
(18, 'blusa', 'dasda', '12', 'blanco', 'blusa.jpg', 10, 125, 0, 25, 2),
(19, 'botas', 'dasda', '12', 'negro', 'botas.jpg', 10, 100, 1, 25, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidor`
--

CREATE TABLE `repartidor` (
  `rep_id` int(5) NOT NULL,
  `rep_dni` varchar(15) NOT NULL,
  `rep_nombre` varchar(25) NOT NULL,
  `rep_apellido1` varchar(50) NOT NULL,
  `rep_apellido2` varchar(50) DEFAULT NULL,
  `rep_telefono` varchar(25) NOT NULL,
  `rep_usuario` varchar(25) NOT NULL,
  `rep_contraseña` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `repartidor`
--

INSERT INTO `repartidor` (`rep_id`, `rep_dni`, `rep_nombre`, `rep_apellido1`, `rep_apellido2`, `rep_telefono`, `rep_usuario`, `rep_contraseña`) VALUES
(1, '312312A', 'rep1', 'rep1', 'rep1', '123123123', 'rep1', 'rep1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoincidencia`
--

CREATE TABLE `tipoincidencia` (
  `tin_id` int(2) NOT NULL,
  `tin_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoincidencia`
--

INSERT INTO `tipoincidencia` (`tin_id`, `tin_nombre`) VALUES
(1, 'En reparto'),
(2, 'Entregado en otro domicilio'),
(3, 'Entregado al comprador'),
(4, 'Comprador no encontrado'),
(5, 'Rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoproducto`
--

CREATE TABLE `tipoproducto` (
  `tpr_id` int(2) NOT NULL,
  `tpr_nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoproducto`
--

INSERT INTO `tipoproducto` (`tpr_id`, `tpr_nombre`) VALUES
(1, 'ropa'),
(2, 'tecnologia'),
(3, 'libros'),
(4, 'comida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipoxproducto`
--

CREATE TABLE `tipoxproducto` (
  `txp_id` int(20) NOT NULL,
  `txp_pro_id` int(10) NOT NULL,
  `txp_tpr_id` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipoxproducto`
--

INSERT INTO `tipoxproducto` (`txp_id`, `txp_pro_id`, `txp_tpr_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 3),
(10, 10, 3),
(11, 11, 3),
(12, 12, 3),
(13, 13, 4),
(14, 14, 4),
(15, 15, 4),
(16, 3, 1),
(17, 3, 1),
(18, 2, 1),
(19, 5, 2),
(20, 7, 2),
(21, 11, 3),
(22, 15, 4),
(23, 14, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedor`
--

CREATE TABLE `vendedor` (
  `ven_id` int(5) NOT NULL,
  `ven_dni` varchar(15) NOT NULL,
  `ven_nombre` varchar(25) NOT NULL,
  `ven_apellido1` varchar(50) NOT NULL,
  `ven_apellido2` varchar(50) DEFAULT NULL,
  `ven_usuario` varchar(25) NOT NULL,
  `ven_contraseña` varchar(25) NOT NULL,
  `ven_telefono` varchar(15) NOT NULL,
  `ven_estado` varchar(15) DEFAULT 'FIABLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedor`
--

INSERT INTO `vendedor` (`ven_id`, `ven_dni`, `ven_nombre`, `ven_apellido1`, `ven_apellido2`, `ven_usuario`, `ven_contraseña`, `ven_telefono`, `ven_estado`) VALUES
(1, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'MALO'),
(2, '412312', 'vendedor2', 'vendedor2', NULL, 'vendedor2', 'vendedor2', '+34 312312', 'FIABLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonageografica`
--

CREATE TABLE `zonageografica` (
  `zog_id` int(2) NOT NULL,
  `zog_nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zonageografica`
--

INSERT INTO `zonageografica` (`zog_id`, `zog_nombre`) VALUES
(1, 'America Norte'),
(2, 'Europa'),
(3, 'Africa'),
(4, 'Asia'),
(5, 'America Sur'),
(6, 'Centro America');

-- --------------------------------------------------------

--
-- Estructura para la vista `lineasinllegar`
--
DROP TABLE IF EXISTS `lineasinllegar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lineasinllegar`  AS SELECT `linea`.`lin_id` AS `lin_id`, `linea`.`lin_cantidad` AS `lin_cantidad`, `linea`.`lin_almacen` AS `lin_almacen`, `linea`.`lin_diaSinLlegar` AS `lin_diaSinLlegar`, `linea`.`lin_ped_id` AS `lin_ped_id`, `linea`.`lin_pro_id` AS `lin_pro_id` FROM (`linea` left join `aviso` on(`linea`.`lin_id` = `aviso`.`avi_lin_id`)) WHERE `linea`.`lin_diaSinLlegar` >= 5 AND `aviso`.`avi_id` is null ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auxlinea`
--
ALTER TABLE `auxlinea`
  ADD PRIMARY KEY (`axl_id`),
  ADD KEY `axl_axp_id` (`axl_axp_id`);

--
-- Indices de la tabla `auxpedido`
--
ALTER TABLE `auxpedido`
  ADD PRIMARY KEY (`axp_id`);

--
-- Indices de la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD PRIMARY KEY (`avi_id`),
  ADD KEY `avi_con_id` (`avi_con_id`),
  ADD KEY `avi_ven_id` (`avi_ven_id`),
  ADD KEY `avi_lin_id` (`avi_lin_id`);

--
-- Indices de la tabla `calle`
--
ALTER TABLE `calle`
  ADD PRIMARY KEY (`cal_id`),
  ADD KEY `cal_ciu_id` (`cal_ciu_id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`ciu_id`),
  ADD KEY `ciu_pai_id` (`ciu_pai_id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`cmt_id`),
  ADD KEY `cmt_com_id` (`cmt_com_id`),
  ADD KEY `cmt_pro_id` (`cmt_pro_id`);

--
-- Indices de la tabla `comprador`
--
ALTER TABLE `comprador`
  ADD PRIMARY KEY (`com_id`),
  ADD UNIQUE KEY `com_usuario` (`com_usuario`);

--
-- Indices de la tabla `controlador`
--
ALTER TABLE `controlador`
  ADD PRIMARY KEY (`con_id`),
  ADD UNIQUE KEY `con_usuario` (`con_usuario`);

--
-- Indices de la tabla `distribuidora`
--
ALTER TABLE `distribuidora`
  ADD PRIMARY KEY (`dis_id`),
  ADD KEY `dis_zog_id` (`dis_zog_id`);

--
-- Indices de la tabla `domicilio`
--
ALTER TABLE `domicilio`
  ADD PRIMARY KEY (`dom_id`),
  ADD KEY `dom_cal_id` (`dom_cal_id`),
  ADD KEY `dom_com_id` (`dom_com_id`);

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`inc_id`),
  ADD KEY `inc_tin_id` (`inc_tin_id`),
  ADD KEY `inc_ped_id` (`inc_ped_id`),
  ADD KEY `inc_ped_rep_id` (`inc_ped_rep_id`);

--
-- Indices de la tabla `linea`
--
ALTER TABLE `linea`
  ADD PRIMARY KEY (`lin_id`),
  ADD KEY `lin_ped_id` (`lin_ped_id`),
  ADD KEY `lin_pro_id` (`lin_pro_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`pai_id`),
  ADD KEY `pai_zog_id` (`pai_zog_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`ped_id`),
  ADD KEY `ped_com_id` (`ped_com_id`),
  ADD KEY `ped_dom_id` (`ped_dom_id`),
  ADD KEY `ped_dis_id` (`ped_dis_id`),
  ADD KEY `ped_rep_id` (`ped_rep_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `pro_ven_id` (`pro_ven_id`);

--
-- Indices de la tabla `repartidor`
--
ALTER TABLE `repartidor`
  ADD PRIMARY KEY (`rep_id`),
  ADD UNIQUE KEY `rep_usuario` (`rep_usuario`);

--
-- Indices de la tabla `tipoincidencia`
--
ALTER TABLE `tipoincidencia`
  ADD PRIMARY KEY (`tin_id`);

--
-- Indices de la tabla `tipoproducto`
--
ALTER TABLE `tipoproducto`
  ADD PRIMARY KEY (`tpr_id`);

--
-- Indices de la tabla `tipoxproducto`
--
ALTER TABLE `tipoxproducto`
  ADD PRIMARY KEY (`txp_id`),
  ADD KEY `txp_pro_id` (`txp_pro_id`),
  ADD KEY `txp_tpr_id` (`txp_tpr_id`);

--
-- Indices de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`ven_id`),
  ADD UNIQUE KEY `ven_usuario` (`ven_usuario`);

--
-- Indices de la tabla `zonageografica`
--
ALTER TABLE `zonageografica`
  ADD PRIMARY KEY (`zog_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aviso`
--
ALTER TABLE `aviso`
  MODIFY `avi_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `calle`
--
ALTER TABLE `calle`
  MODIFY `cal_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `ciu_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `cmt_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comprador`
--
ALTER TABLE `comprador`
  MODIFY `com_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `controlador`
--
ALTER TABLE `controlador`
  MODIFY `con_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `distribuidora`
--
ALTER TABLE `distribuidora`
  MODIFY `dis_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `domicilio`
--
ALTER TABLE `domicilio`
  MODIFY `dom_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `inc_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `linea`
--
ALTER TABLE `linea`
  MODIFY `lin_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `pai_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `ped_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `pro_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `repartidor`
--
ALTER TABLE `repartidor`
  MODIFY `rep_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipoincidencia`
--
ALTER TABLE `tipoincidencia`
  MODIFY `tin_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipoproducto`
--
ALTER TABLE `tipoproducto`
  MODIFY `tpr_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipoxproducto`
--
ALTER TABLE `tipoxproducto`
  MODIFY `txp_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `ven_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `zonageografica`
--
ALTER TABLE `zonageografica`
  MODIFY `zog_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auxlinea`
--
ALTER TABLE `auxlinea`
  ADD CONSTRAINT `auxlinea_ibfk_1` FOREIGN KEY (`axl_axp_id`) REFERENCES `auxpedido` (`axp_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD CONSTRAINT `aviso_ibfk_1` FOREIGN KEY (`avi_con_id`) REFERENCES `controlador` (`con_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aviso_ibfk_2` FOREIGN KEY (`avi_ven_id`) REFERENCES `vendedor` (`ven_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aviso_ibfk_3` FOREIGN KEY (`avi_lin_id`) REFERENCES `linea` (`lin_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `calle`
--
ALTER TABLE `calle`
  ADD CONSTRAINT `calle_ibfk_1` FOREIGN KEY (`cal_ciu_id`) REFERENCES `ciudad` (`ciu_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`ciu_pai_id`) REFERENCES `pais` (`pai_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`cmt_com_id`) REFERENCES `comprador` (`com_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`cmt_pro_id`) REFERENCES `producto` (`pro_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `distribuidora`
--
ALTER TABLE `distribuidora`
  ADD CONSTRAINT `distribuidora_ibfk_1` FOREIGN KEY (`dis_zog_id`) REFERENCES `zonageografica` (`zog_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `domicilio`
--
ALTER TABLE `domicilio`
  ADD CONSTRAINT `domicilio_ibfk_1` FOREIGN KEY (`dom_cal_id`) REFERENCES `calle` (`cal_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `domicilio_ibfk_2` FOREIGN KEY (`dom_com_id`) REFERENCES `comprador` (`com_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `incidencia_ibfk_1` FOREIGN KEY (`inc_tin_id`) REFERENCES `tipoincidencia` (`tin_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incidencia_ibfk_2` FOREIGN KEY (`inc_ped_id`) REFERENCES `pedido` (`ped_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incidencia_ibfk_3` FOREIGN KEY (`inc_ped_rep_id`) REFERENCES `pedido` (`ped_rep_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `linea`
--
ALTER TABLE `linea`
  ADD CONSTRAINT `linea_ibfk_1` FOREIGN KEY (`lin_ped_id`) REFERENCES `pedido` (`ped_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `linea_ibfk_2` FOREIGN KEY (`lin_pro_id`) REFERENCES `producto` (`pro_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pais`
--
ALTER TABLE `pais`
  ADD CONSTRAINT `pais_ibfk_1` FOREIGN KEY (`pai_zog_id`) REFERENCES `zonageografica` (`zog_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ped_com_id`) REFERENCES `comprador` (`com_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`ped_dom_id`) REFERENCES `domicilio` (`dom_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`ped_dis_id`) REFERENCES `distribuidora` (`dis_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_4` FOREIGN KEY (`ped_rep_id`) REFERENCES `repartidor` (`rep_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`pro_ven_id`) REFERENCES `vendedor` (`ven_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tipoxproducto`
--
ALTER TABLE `tipoxproducto`
  ADD CONSTRAINT `tipoxproducto_ibfk_1` FOREIGN KEY (`txp_pro_id`) REFERENCES `producto` (`pro_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tipoxproducto_ibfk_2` FOREIGN KEY (`txp_tpr_id`) REFERENCES `tipoproducto` (`tpr_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `copiaSeguridad` ON SCHEDULE EVERY 1 DAY STARTS '2023-11-09 23:59:59' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	INSERT INTO auxpedido select * from pedido where ped_fecha = CURRENT_DATE;
	INSERT INTO auxlinea select lin_id, lin_cantidad, lin_almacen, lin_diaSinLlegar, lin_ped_id, lin_pro_id from linea INNER JOIN pedido ON lin_ped_id = ped_id WHERE ped_fecha = CURRENT_DATE;
END$$

CREATE DEFINER=`root`@`localhost` EVENT `actualizarDiasSinLLegar` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-11-09 23:59:59' ON COMPLETION NOT PRESERVE ENABLE DO update linea set lin_diaSinLlegar = lin_diaSinLlegar + 1 WHERE lin_almacen = 0$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
