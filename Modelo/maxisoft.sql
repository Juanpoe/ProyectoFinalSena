-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2023 a las 21:33:25
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `maxisoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendamiento`
--

CREATE TABLE `agendamiento` (
  `IdAgendamiento` int(10) NOT NULL,
  `IdUsuario` int(50) NOT NULL,
  `IdServicio` int(50) NOT NULL,
  `IdHerramientaInsumo` varchar(50) NOT NULL,
  `NombreCliente` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `FechaServicio` date NOT NULL,
  `DireccionCliente` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TelefonoCliente` bigint(15) NOT NULL,
  `Estado` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `agendamiento`
--

INSERT INTO `agendamiento` (`IdAgendamiento`, `IdUsuario`, `IdServicio`, `IdHerramientaInsumo`, `NombreCliente`, `Descripcion`, `FechaServicio`, `DireccionCliente`, `TelefonoCliente`, `Estado`) VALUES
(1, 8, 1, 'Ninguno', 'Dabidsa', '                 ok', '2023-07-29', 'Mi casa', 3173139588, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientadanada`
--

CREATE TABLE `herramientadanada` (
  `IdHerramientaDanada` int(10) NOT NULL,
  `IdPrestamo` int(10) NOT NULL,
  `CantidadElemento` int(20) NOT NULL,
  `Observacion` varchar(200) NOT NULL,
  `Estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `herramientadanada`
--

INSERT INTO `herramientadanada` (`IdHerramientaDanada`, `IdPrestamo`, `CantidadElemento`, `Observacion`, `Estado`) VALUES
(20, 104, 3, 'cuando lo use, exproto', 1),
(21, 105, 0, 'se cayó', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientainsumo`
--

CREATE TABLE `herramientainsumo` (
  `IdHerramientaInsumo` int(11) NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Tipo` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `Categoria` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `Medida` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `herramientainsumo`
--

INSERT INTO `herramientainsumo` (`IdHerramientaInsumo`, `Nombre`, `Tipo`, `Categoria`, `Descripcion`, `Cantidad`, `Medida`, `Estado`) VALUES
(87, 'Destornillador', 'Herramienta', 'Manual', 'Para destornillar tornillos', 14, 'U', 1),
(92, 'pico', 'Herramienta', 'Manual', 'para picar1', 12, 'U', 1),
(93, 'ponchadora', 'Herramienta', 'Manual', 'blanca y casi negra', 12, 'U', 1),
(96, 'Cable UTP', 'Insumo', 'Cable', 'Para la instalacion de wifi', 123, 'Km', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumoagenda`
--

CREATE TABLE `insumoagenda` (
  `IdInsumoAgenda` int(11) NOT NULL,
  `IdHerramientaInsumo` varchar(50) NOT NULL,
  `IdAgendamiento` int(11) NOT NULL,
  `Cantidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `insumoagenda`
--

INSERT INTO `insumoagenda` (`IdInsumoAgenda`, `IdHerramientaInsumo`, `IdAgendamiento`, `Cantidad`) VALUES
(1, 'Ninguno', 1, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedad`
--

CREATE TABLE `novedad` (
  `IdNovedad` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `Peticion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Descripcion` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `FechaRegistro` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FechaInicio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FechaFinal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `HoraInicio` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `HoraFinal` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `EstadoNovedad` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `novedad`
--

INSERT INTO `novedad` (`IdNovedad`, `IdUsuario`, `Peticion`, `Descripcion`, `FechaRegistro`, `FechaInicio`, `FechaFinal`, `HoraInicio`, `HoraFinal`, `EstadoNovedad`) VALUES
(1, 8, 'DIARREA CRONICA', 'Casi me muero', '29/06/2023 22:04:01', '2023-08-23', '2023-08-31', '15:13', '16:14', 2),
(5, 5, 'Dia libre', 'Tengo una cita medica', '14/07/2023 19:13:23', '2023-07-16', '2023-07-17', '13:14', '15:12', 0),
(14, 22, 'SALIDA DE VIAJE', 'tengo una salida de viaje a santa marta', '18/08/2023 14:57:10', '2023-09-02', '2023-09-07', '08:00', '14:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `IdPrestamo` int(10) NOT NULL,
  `IdUsuario` int(10) NOT NULL,
  `IdHerramientaInsumo` int(10) NOT NULL,
  `FechaPrestamo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CantidadElemento` int(11) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`IdPrestamo`, `IdUsuario`, `IdHerramientaInsumo`, `FechaPrestamo`, `CantidadElemento`, `Estado`) VALUES
(103, 1, 87, '03-08-2023', 0, 0),
(104, 1, 87, '03-08-2023', 0, 0),
(105, 1, 87, '03-08-2023', 0, 0),
(106, 1, 87, '10-08-2023', 0, 0),
(107, 1, 92, '11-08-2023', 0, 0),
(108, 1, 93, '11-08-2023', 0, 0),
(109, 1, 87, '11-08-2023', 11, 1),
(110, 1, 92, '11-08-2023', 12, 1),
(111, 22, 87, '18-08-2023', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `IdRol` int(50) NOT NULL,
  `NombreRol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Rol` int(10) NOT NULL,
  `Permisos` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FechaRol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EstadoRol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`IdRol`, `NombreRol`, `Rol`, `Permisos`, `FechaRol`, `EstadoRol`) VALUES
(1, 'Administrador', 1, '1,1,1,1,1,1,1', '07-06-2023 12:24:08', '1'),
(2, 'Vendedores', 0, '0,0,0,0,0,1,0', '07-06-2023 12:24:08', '1'),
(3, 'Practicante demorado', 0, '1,1,1,1,1,1,1', '07-06-2023 12:24:08', '1'),
(10, 'Semi Administrador', 1, '1,1,0,0,0,1,1', '16-06-2023 07:12:36', '1'),
(16, 'cosa normal', 0, '0,0,1,1,0,0,0', '22-06-2023 12:38:38', '1'),
(19, 'Binario', 1, '0,1,1,1,0,0,0', '02-07-2023 10:49:29', '1'),
(35, 'seguimiento', 0, '1,1,1,1,1,1,1', '24-07-2023 03:25:45', '1'),
(36, 'Director de baños', 1, '0,1,1,1,0,0,0', '25-07-2023 03:49:44', '1'),
(37, 'añadír cosas', 1, '0,1,1,0,0,0,0', '27-07-2023 12:50:55', '1'),
(38, 'SubGerente', 1, '1,1,1,0,0,0,0', '27-07-2023 04:12:50', '0'),
(39, 'Novato', 1, '1,0,0,0,0,0,0', '27-07-2023 04:15:26', '1'),
(40, 'Novato de baños4', 1, '0,1,0,0,0,0,0', '27-07-2023 04:22:09', '1'),
(41, 'Val', 1, '1,0,1,1,1,1,0', '18-08-2023 02:44:05', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `IdServicio` int(50) NOT NULL,
  `NombreServicio` varchar(30) NOT NULL,
  `EstadoServicio` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`IdServicio`, `NombreServicio`, `EstadoServicio`) VALUES
(1, 'Cambio de Router', '1'),
(2, 'Cambio de Antena', '0'),
(3, 'Mejor dicho', '0'),
(4, 'Cambio de Servicio', '1'),
(5, 'Servicio de Interne 500MB', '1'),
(6, 'Servicio de internet 600MB', '1'),
(15, 'Cambio de megas', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudprestamo`
--

CREATE TABLE `solicitudprestamo` (
  `IdSolicitudPrestamo` int(11) NOT NULL,
  `IdHerramientaInsumo` int(11) NOT NULL,
  `IdUsuario` int(11) NOT NULL,
  `CantidadSolicitud` int(11) NOT NULL,
  `Observacion` varchar(200) NOT NULL,
  `FechaSolicitud` varchar(20) NOT NULL,
  `Estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(50) NOT NULL,
  `IdRol` int(20) NOT NULL,
  `Nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Apellido` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TipoDocumento` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Documento` bigint(30) NOT NULL,
  `Correo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Contrasena` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telefono` bigint(20) NOT NULL,
  `Direccion` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `IdRol`, `Nombre`, `Apellido`, `TipoDocumento`, `Documento`, `Correo`, `Contrasena`, `Telefono`, `Direccion`, `Estado`) VALUES
(1, 1, 'Pablo', 'Franco', 'Cédula', 1234, 'oe@gmail.com', '6a6189213a862710e0176352cde959d5f6d5037aa10d10eb60154d4e8f65d93252eacc18b4e2133e1a9232d5d86c2eb03e421d71b3c31d7ae773c14981ce9390', 301, 'szs', 1),
(2, 3, 'Danila Andresa', 'Arango Chavarriaga', 'Cédula', 1011310101, 'dana@gmail.com', '6a6189213a862710e0176352cde959d5f6d5037aa10d10eb60154d4e8f65d93252eacc18b4e2133e1a9232d5d86c2eb03e421d71b3c31d7ae773c14981ce9390', 3244723715, 'aya', 1),
(3, 3, 'Alvaro', 'Alvarado', 'Cédula', 12341234, 'alvaro@gmail.com', '6a6189213a862710e0176352cde959d5f6d5037aa10d10eb60154d4e8f65d93252eacc18b4e2133e1a9232d5d86c2eb03e421d71b3c31d7ae773c14981ce9390', 1234123490, 'Mi casa', 1),
(4, 3, 'Alvaro', 'Andresa', 'Cédula', 123456789, 'alvarado@gmail.com', '6a6189213a862710e0176352cde959d5f6d5037aa10d10eb60154d4e8f65d93252eacc18b4e2133e1a9232d5d86c2eb03e421d71b3c31d7ae773c14981ce9390', 2147483642, 'Mi casa', 0),
(5, 2, 'Yenny', 'Durango', 'Cédula', 12345776543, 'yenny@gmail.com', '5259f4d271b51646c436f5df78ee2ac11b292fc8749b67005ad10261eac08ae6a46aab458c94824f689658ef8cfe17b27118ab22512e295fc63352ce3f201453', 3159076568, 'Mi casa del lado', 1),
(6, 16, 'paco', 'pacosteco', 'Tarjeta de identidad', 12038134, 'paco@gmail.com', '0bb66d489c087e32be726ce3276fe29495885976f823a75c3436615b7017aff97f006d17a159ce3a5b2cc9f02c1e4993ebe22035e4f85caacf3cfbe2e7d8fce4', 2147483647, 'peaco', 0),
(7, 1, 'Tester dev', 'Master dev', 'Cédula', 1234567890, 'tron@gmail.com', 'c28737f05631a328a37fe35a14d10a4f327f025738de66f6f7fbdc2da600f41fd86f8f83a3df2650e8958f53ab98beee424c806b9151be7cd8e3cffda260c025', 3008775520, 'Por aya pues', 0),
(8, 10, 'Yeison Miguel Piñereés', 'Barrios Monterrosa Piñerez', 'Cédula', 1051899899, 'yb@gmail.com', '56f0db74ac4af69ac63b28953e3553b7e05d5cb9b49fd73e0d69c74278fe720dfbdca72dc50f74eaec4c4384d42bb08bf7078356e438dcb982342d652771a79e', 3215263434, 'Cra 23 Cl 34 - 34', 1),
(9, 3, 'Juan Mifguel Jose', 'Pedrosa Pedroza Pedroza', 'Cédula', 1234567898, 'juan@gmail.com', '56f0db74ac4af69ac63b28953e3553b7e05d5cb9b49fd73e0d69c74278fe720dfbdca72dc50f74eaec4c4384d42bb08bf7078356e438dcb982342d652771a79e', 3173139588, 'Cra 45 cl 66', 1),
(20, 1, 'Alvaro', 'juanes ', 'Cédula', 5412634127, 'oeoe@gmail.com', '1ebcf8f20bbd97aefdab06940bafb2a63332f2f827ffb80983784db58ca7f89d4f71778641de3ceb033b5b1e73140f8dac544f0c90ca761b5535b6d2447041ff', 987654321, '0987654321', 1),
(22, 1, 'Val', 'Berrio', 'Cédula', 123045923, 'val@gnail.com', '0910218ae810e21acf4ea7038faa6de00d0dd349e8395677935060b68fd90dc6cf4c6e90f6df0b4cadb5d0d4b1e32aa2db58155dc6851158c46e34df54a8839b', 2890384789, 'calle 109 # 24', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agendamiento`
--
ALTER TABLE `agendamiento`
  ADD PRIMARY KEY (`IdAgendamiento`),
  ADD KEY `IdUsuario` (`IdUsuario`),
  ADD KEY `IdServicio` (`IdServicio`);

--
-- Indices de la tabla `herramientadanada`
--
ALTER TABLE `herramientadanada`
  ADD PRIMARY KEY (`IdHerramientaDanada`),
  ADD KEY `IdPrestamo` (`IdPrestamo`);

--
-- Indices de la tabla `herramientainsumo`
--
ALTER TABLE `herramientainsumo`
  ADD PRIMARY KEY (`IdHerramientaInsumo`);

--
-- Indices de la tabla `insumoagenda`
--
ALTER TABLE `insumoagenda`
  ADD PRIMARY KEY (`IdInsumoAgenda`),
  ADD KEY `IdAgendamiento` (`IdAgendamiento`),
  ADD KEY `IdHerramientaInsumo` (`IdHerramientaInsumo`);

--
-- Indices de la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD PRIMARY KEY (`IdNovedad`),
  ADD KEY `IdEmpleado` (`IdUsuario`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`IdPrestamo`),
  ADD KEY `id_empleado` (`IdUsuario`),
  ADD KEY `IdHerramientaInsumo` (`IdHerramientaInsumo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`IdServicio`);

--
-- Indices de la tabla `solicitudprestamo`
--
ALTER TABLE `solicitudprestamo`
  ADD PRIMARY KEY (`IdSolicitudPrestamo`),
  ADD KEY `IdHerramientaInsumo` (`IdHerramientaInsumo`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`),
  ADD KEY `IdRol` (`IdRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendamiento`
--
ALTER TABLE `agendamiento`
  MODIFY `IdAgendamiento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `herramientadanada`
--
ALTER TABLE `herramientadanada`
  MODIFY `IdHerramientaDanada` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `herramientainsumo`
--
ALTER TABLE `herramientainsumo`
  MODIFY `IdHerramientaInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `insumoagenda`
--
ALTER TABLE `insumoagenda`
  MODIFY `IdInsumoAgenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `novedad`
--
ALTER TABLE `novedad`
  MODIFY `IdNovedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `IdPrestamo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `IdRol` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `IdServicio` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `solicitudprestamo`
--
ALTER TABLE `solicitudprestamo`
  MODIFY `IdSolicitudPrestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agendamiento`
--
ALTER TABLE `agendamiento`
  ADD CONSTRAINT `agendamiento_ibfk_3` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `agendamiento_ibfk_4` FOREIGN KEY (`IdServicio`) REFERENCES `servicio` (`IdServicio`);

--
-- Filtros para la tabla `herramientadanada`
--
ALTER TABLE `herramientadanada`
  ADD CONSTRAINT `herramientadanada_ibfk_1` FOREIGN KEY (`IdPrestamo`) REFERENCES `prestamo` (`IdPrestamo`);

--
-- Filtros para la tabla `insumoagenda`
--
ALTER TABLE `insumoagenda`
  ADD CONSTRAINT `insumoagenda_ibfk_1` FOREIGN KEY (`IdAgendamiento`) REFERENCES `agendamiento` (`IdAgendamiento`);

--
-- Filtros para la tabla `novedad`
--
ALTER TABLE `novedad`
  ADD CONSTRAINT `novedad_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`);

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`IdHerramientaInsumo`) REFERENCES `herramientainsumo` (`IdHerramientaInsumo`);

--
-- Filtros para la tabla `solicitudprestamo`
--
ALTER TABLE `solicitudprestamo`
  ADD CONSTRAINT `solicitudprestamo_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `solicitudprestamo_ibfk_2` FOREIGN KEY (`IdHerramientaInsumo`) REFERENCES `herramientainsumo` (`IdHerramientaInsumo`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`IdRol`) REFERENCES `rol` (`IdRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
