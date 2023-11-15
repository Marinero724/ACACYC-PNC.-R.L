-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2023 a las 04:35:29
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prestamo`
--
CREATE DATABASE IF NOT EXISTS `prestamo` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `prestamo`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aportes`
--

CREATE TABLE `aportes` (
  `idaporte` int(11) NOT NULL,
  `idcuentaahorro` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `aporte` varchar(20) NOT NULL,
  `saldo` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `aportes`
--

INSERT INTO `aportes` (`idaporte`, `idcuentaahorro`, `idcliente`, `fecha`, `aporte`, `saldo`) VALUES
(11, 7, 57863297, '2023-11-15', '10', '10'),
(12, 7, 57863297, '2023-11-15', '10', '20'),
(13, 7, 57863297, '2023-11-15', '10', '30'),
(14, 7, 57863297, '2023-11-15', '10', '40'),
(15, 7, 57863297, '2023-11-15', '10', '50'),
(16, 7, 57863297, '2023-11-15', '10', '60');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` varchar(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `direccion` varchar(250) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nombre`, `direccion`, `telefono`, `estado`) VALUES
('007800291', 'Vilma Angelica Sanches Sanches', 'Ilopango, San Salvador', '63130000', 1),
('009664974', 'TERESA DE JESUS LOPEZ ROSALES', 'BO EL CALVARIO', '76978872', 1),
('012190502', 'MORELIA ELIZABETH VALDEZ DE SALAZAR', 'LOS NARANJOS, CAS SAMARIA', '64209132', 1),
('012191752', 'VICTOR STANLEY LARA ESPINOZA', 'RES PINARES DE SUIZA POL 16 #28', '77292748', 1),
('013136200', 'VERONICA PATRICIA MURCIA DE LAZO', 'RES MEXICALY CL MEXICO, AV ASESECO # 19A', '78330560', 1),
('026280482', 'MANUEL 0SMIN ROMERO GRANADOS', 'SALAMAR, LA REFORMA', '77097667', 1),
('027849019', 'ELIANA RAQUEL CRESPIN HERNANDEZ', 'COL ZACAMIL EDIFICIO  9 APTO 23', '77348989', 1),
('037410121', 'MACLIN JUD HERNANDEZ FLORES', 'LOT LOS GIRASOLES CTON TRES CEIBAS LOTE # 19', '61507126', 0),
('038508032', 'ELISA SARAI DIAZ ALVAREZ', 'COL VENTURA PERLA CALLE PRINCIPAL FTE CASA PERRO VAGO', '61063009', 1),
('038863775', 'GERARDO ANTONIO GUZMAN ', 'COL SAN RAFAEL PJE 2 CASA # 8', '71862101', 1),
('047107940', 'CRISTINA MARIA ALEGRIA PACAS', '17 CL PTE 4to/6to AV SUR', '77458541', 0),
('048915621', 'DORA NELLY HENRIQUEZ CASANGA', 'RPTO LAS MARGARITAS NORTE PJE 2 PTE POL D 93', '61915264', 1),
('050408486', 'JOSE ORLANDO SALGADO MEJIA', 'COL GUADALUPE PJE #1 KM 135 #7', '62593410', 0),
('053156224', 'ERICK OSWALDO VASQUEZ TEJADA', 'SAN VICENTE, CAS PARAJE GALAN', '75632094', 1),
('057290363', 'MARIA JOSE GIRON CHICA', 'URB SANTISIMA TRINIDAD PJE 16 POL 17 BK H # 32', '61029562', 1),
('057425963', 'Jorge Miguel Castros Cabezas', 'Ahuachapan, Atiquizalla', '78486852', 1),
('057863297', 'Julio Ernesto Sanches Ventura ', 'Res santa lucia pasaje 3 pol 29', '61822703', 1),
('057863298', 'Dagoberto Ulises Perez Monchez', 'senda de san patricio pje 3 pol r casa 74', '78541263', 1),
('057863299', 'Raul Isaac Martinez Hernandez ', 'residencia montes 3 pasaje 5 calle 4 casa 3', '75423598', 1),
('059114408', 'GUADALUPE DE JESUS MARAVILLA ROQUE', 'COL SANTA LUCIA POL C # 15 DOR', '77848664', 1),
('475248652', 'Camila Fernanda Rodrigues', 'La libertad, Antiguo Cuscatlan ', '74753652', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentasdeahorro`
--

CREATE TABLE `cuentasdeahorro` (
  `idcuenta` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `concepto` varchar(250) NOT NULL,
  `fechaapertura` varchar(250) NOT NULL,
  `fechadepago` varchar(200) NOT NULL,
  `cuotadeahorro` varchar(200) NOT NULL,
  `saldo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cuentasdeahorro`
--

INSERT INTO `cuentasdeahorro` (`idcuenta`, `idcliente`, `concepto`, `fechaapertura`, `fechadepago`, `cuotadeahorro`, `saldo`) VALUES
(7, 57863297, 'DESCUENTO EN PLANILLA', '2023-11-14 ', '2023-11-14', '10', '70');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `idgasto` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `concepto` varchar(50) NOT NULL,
  `gasto` decimal(16,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `idpago` int(11) NOT NULL,
  `idprestamo` int(11) NOT NULL,
  `duiCliente` varchar(9) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `cuota` decimal(16,2) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`idpago`, `idprestamo`, `duiCliente`, `usuario`, `fecha`, `cuota`, `saldo`) VALUES
(20, 111, '57863298', 'Dagoberto Marinero', '2023-11-11 00:00:00', 100.00, 3200),
(21, 111, '57863298', 'Dagoberto Marinero', '2023-11-11 00:00:00', 100.00, 3100),
(22, 111, '57863298', 'Dagoberto Marinero', '2023-11-11 00:00:00', 100.00, 3000),
(23, 111, '57863298', 'Dagoberto Marinero', '2023-11-11 00:00:00', 100.00, 2900),
(24, 111, '57863298', 'Dagoberto Marinero', '2023-11-11 00:00:00', 2900.00, 0),
(25, 1, '9664974', 'Dagoberto Marinero', '2023-11-15 00:00:00', 159.72, 5750),
(26, 111, '57863298', 'Dagoberto Marinero', '2023-11-15 00:00:00', 100.00, 0),
(27, 114, '012191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 1035),
(28, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 1013),
(29, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 992),
(30, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 970),
(31, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 949),
(32, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 927),
(33, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 906),
(34, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 884),
(35, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 863),
(36, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 841),
(37, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 819),
(38, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 798),
(39, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 776),
(40, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 755),
(41, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 733),
(42, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 712),
(43, 114, '12191752', 'Dagoberto Marinero', '2023-11-15 00:00:00', 21.56, 690);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `permiso` varchar(50) NOT NULL,
  `Descripcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `permiso`, `Descripcion`) VALUES
(1, 'Escritorio', 'Recepcion'),
(2, 'Clientes', 'Analista de creditos'),
(3, 'prestamo', 'Gestor de cobros'),
(4, 'Pagos', 'Atencion al cliente'),
(5, 'usuario', 'Cajas'),
(6, 'Gastos', 'Supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `idprestamo` bigint(20) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `fprestamo` datetime NOT NULL,
  `monto` decimal(16,2) NOT NULL,
  `interes` decimal(16,2) NOT NULL,
  `saldo` decimal(16,2) NOT NULL,
  `fpago` datetime DEFAULT NULL,
  `cuota` decimal(16,2) NOT NULL,
  `plazo` varchar(20) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`idprestamo`, `idcliente`, `usuario`, `fprestamo`, `monto`, `interes`, `saldo`, `fpago`, `cuota`, `plazo`, `estado`) VALUES
(1, 9664974, 'Dagoberto Marinero', '2023-11-14 19:14:26', 5000.00, 15.00, 5590.28, '2023-12-16 00:00:00', 159.72, '36', 1),
(111, 57863298, 'Dagoberto Marinero', '2023-11-06 22:21:23', 3000.00, 20.00, -100.00, '2023-12-08 00:00:00', 100.00, '36', 1),
(113, 9664974, 'Dagoberto Marinero', '2023-11-14 19:11:08', 500.00, 15.00, 415.28, '2023-12-16 00:00:00', 11.98, '48', 1),
(114, 12191752, 'Dagoberto Marinero', '2023-11-14 19:13:04', 900.00, 15.00, 668.48, '2023-12-16 00:00:00', 21.56, '48', 1),
(115, 27849019, 'Dagoberto Marinero', '2023-11-14 19:13:24', 7000.00, 15.00, 8050.00, '2023-12-16 00:00:00', 167.71, '48', 1),
(116, 26280482, 'Dagoberto Marinero', '2023-11-14 19:18:13', 8000.00, 15.00, 9200.00, '2023-12-16 00:00:00', 153.33, '60', 1),
(117, 13136200, 'Dagoberto Marinero', '2023-11-14 19:19:32', 800.00, 13.00, 904.00, '2023-12-16 00:00:00', 25.11, '36', 1),
(118, 38508032, 'Dagoberto Marinero', '2023-11-14 19:19:49', 700.00, 13.00, 791.00, '2023-12-16 00:00:00', 16.48, '48', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempo`
--

CREATE TABLE `tiempo` (
  `id_tiempo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `mes` int(11) NOT NULL,
  `dia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `idPermiso` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `user` varchar(20) NOT NULL,
  `pass` varchar(64) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `idPermiso`, `nombre`, `departamento`, `telefono`, `user`, `pass`, `imagen`, `estado`) VALUES
(1, 6, 'Raul Escobar', 'Comercial', '61822712', 'raulE', 'admin', NULL, 1),
(4, 5, 'Juan Sanches', 'Cobros', '78485868', 'juan', '4321', '', 1),
(5, 6, 'Dagoberto Marinero', 'IT', '78330047', 'Dago', 'dago', ' ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariopermi`
--

CREATE TABLE `usuariopermi` (
  `idusuariopermi` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idpermiso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuariopermi`
--

INSERT INTO `usuariopermi` (`idusuariopermi`, `idusuario`, `idpermiso`) VALUES
(24, 3, 1),
(25, 3, 2),
(26, 3, 3),
(27, 3, 4),
(28, 3, 5),
(29, 3, 6),
(30, 3, 7),
(31, 4, 1),
(32, 4, 2),
(33, 4, 3),
(34, 4, 4),
(35, 5, 5),
(36, 4, 6),
(37, 4, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aportes`
--
ALTER TABLE `aportes`
  ADD PRIMARY KEY (`idaporte`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `cuentasdeahorro`
--
ALTER TABLE `cuentasdeahorro`
  ADD PRIMARY KEY (`idcuenta`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`idgasto`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`idpago`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`idprestamo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `usuariopermi`
--
ALTER TABLE `usuariopermi`
  ADD PRIMARY KEY (`idusuariopermi`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aportes`
--
ALTER TABLE `aportes`
  MODIFY `idaporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `cuentasdeahorro`
--
ALTER TABLE `cuentasdeahorro`
  MODIFY `idcuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `idpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `idprestamo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
