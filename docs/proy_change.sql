-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2024 a las 05:37:00
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
-- Base de datos: `proy_change`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abarca`
--

CREATE TABLE `abarca` (
  `nroEnc` int(11) NOT NULL,
  `nombreTem` char(20) NOT NULL,
  `puestoInt` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliado`
--

CREATE TABLE `afiliado` (
  `correo` char(40) NOT NULL,
  `fechaN` date DEFAULT NULL,
  `firmaAnon` int(1) DEFAULT 0,
  `TFA` int(1) DEFAULT 0,
  `nombrePais` char(25) NOT NULL,
  `nombreProv` char(25) NOT NULL,
  `nombreLoc` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destino`
--

CREATE TABLE `destino` (
  `nombreDest` char(30) NOT NULL,
  `descr` char(40) DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destino`
--

INSERT INTO `destino` (`nombreDest`, `descr`, `estado`) VALUES
('gobierno de san juan', '', 1),
('intendente de chimbas', '', 0),
('javier milei', 'presidente de la republica arg', 1),
('javueb maluco', '', 0),
('min de salud', 'enfermedades, salud publica, hospitales', 1),
('romina rosas', 'Intendente de caucete 2022-2026', 1),
('si funciono', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `nroEnc` int(11) NOT NULL,
  `fecha` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `firma`
--

CREATE TABLE `firma` (
  `idFirma` int(11) NOT NULL,
  `nroPet` int(11) NOT NULL,
  `correo` char(40) NOT NULL DEFAULT '',
  `ip` char(45) NOT NULL DEFAULT '0.0.0.0',
  `comentario` tinytext NOT NULL DEFAULT '',
  `anon` int(1) NOT NULL DEFAULT 0,
  `fecha` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `nroPet` int(11) NOT NULL,
  `nroImg` int(11) NOT NULL,
  `extension` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `informe`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `informe` (
`mes` varchar(7)
,`cantidadPeticiones` bigint(21)
,`cantidadBajas` bigint(21)
,`cantidadAdmitidas` bigint(21)
,`cantidadExitosas` bigint(21)
,`cantidadNoAdmitidas` bigint(21)
,`cantidadUsuariosNuevos` bigint(21)
,`cantidadFirmas` bigint(21)
,`cantidadRegistradas` bigint(21)
,`cantidadNoRegistradas` bigint(21)
,`cantidadPublicas` bigint(21)
,`cantidadAnonimas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interesa`
--

CREATE TABLE `interesa` (
  `correo` char(40) NOT NULL,
  `nombreTem` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipdir`
--

CREATE TABLE `ipdir` (
  `ip` char(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `nombrePais` char(25) NOT NULL,
  `nombreProv` char(25) NOT NULL,
  `nombreLoc` char(30) NOT NULL,
  `estado` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`nombrePais`, `nombreProv`, `nombreLoc`, `estado`) VALUES
('argentina', 'san juan', 'caucete', 1),
('argentina', 'san juan', 'difunta correa', 1),
('argentina', 'san juan', 'san juan', 1),
('argentina', 'san juan', 'vallecito', 0),
('argentina', 'san juan', 'villa krause', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `nombrePais` char(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`nombrePais`) VALUES
('argentina'),
('bolivia'),
('brasil'),
('chile'),
('colombia'),
('costa rica'),
('cuba'),
('dominicana'),
('ecuador'),
('el salvador'),
('guatemala'),
('honduras'),
('méxico'),
('nicaragua'),
('panamá'),
('paraguay'),
('perú'),
('puerto rico'),
('uruguay'),
('venezuela');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticion`
--

CREATE TABLE `peticion` (
  `nroPet` int(11) NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0,
  `objFirmas` int(11) NOT NULL DEFAULT 0,
  `titulo` char(100) DEFAULT NULL,
  `cuerpo` text DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `correo` char(40) NOT NULL,
  `nombreDest` char(30) DEFAULT NULL,
  `nombrePais` char(25) DEFAULT NULL,
  `nombreProv` char(25) DEFAULT NULL,
  `nombreLoc` char(30) DEFAULT NULL,
  `nroPet_multiple` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticionmultiple`
--

CREATE TABLE `peticionmultiple` (
  `nroPet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticionplus`
--

CREATE TABLE `peticionplus` (
  `nroPet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `peticion_objetivo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `peticion_objetivo` (
`numero` int(11)
,`estado` int(1)
,`objetivo` int(11)
,`firmas` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `nombrePais` char(25) NOT NULL,
  `nombreProv` char(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`nombrePais`, `nombreProv`) VALUES
('argentina', 'buenos aires'),
('argentina', 'catamarca'),
('argentina', 'córdoba'),
('argentina', 'entre ríos'),
('argentina', 'la rioja'),
('argentina', 'mendoza'),
('argentina', 'san juan'),
('argentina', 'san luis'),
('argentina', 'santa fe'),
('argentina', 'tucumán'),
('bolivia', 'cochabamba'),
('bolivia', 'la paz'),
('bolivia', 'oruro'),
('bolivia', 'potosí'),
('bolivia', 'santa cruz'),
('brasil', 'bahia'),
('brasil', 'minas gerais'),
('brasil', 'paraná'),
('brasil', 'rio de janeiro'),
('brasil', 'são paulo'),
('chile', 'antofagasta'),
('chile', 'atacama'),
('chile', 'biobío'),
('chile', 'santiago'),
('chile', 'valparaíso'),
('colombia', 'antioquia'),
('colombia', 'bogotá'),
('colombia', 'cundinamarca'),
('colombia', 'santander'),
('colombia', 'valle del cauca'),
('costa rica', 'alajuela'),
('costa rica', 'cartago'),
('costa rica', 'heredia'),
('costa rica', 'puntarenas'),
('costa rica', 'san josé'),
('cuba', 'camagüey'),
('cuba', 'holguín'),
('cuba', 'la habana'),
('cuba', 'matanzas'),
('cuba', 'santiago de cuba'),
('dominicana', 'la vega'),
('dominicana', 'puerto plata'),
('dominicana', 'san cristóbal'),
('dominicana', 'santiago'),
('dominicana', 'santo domingo'),
('ecuador', 'azuay'),
('ecuador', 'esmeraldas'),
('ecuador', 'guayas'),
('ecuador', 'manabí'),
('ecuador', 'pichincha'),
('el salvador', 'la libertad'),
('el salvador', 'san salvador'),
('el salvador', 'santa ana'),
('el salvador', 'sonsonate'),
('el salvador', 'usulután'),
('guatemala', 'escuintla'),
('guatemala', 'guatemala'),
('guatemala', 'quetzaltenango'),
('guatemala', 'quiché'),
('guatemala', 'sacatepéquez'),
('honduras', 'atlántida'),
('honduras', 'choluteca'),
('honduras', 'cortés'),
('honduras', 'francisco morazán'),
('honduras', 'yoro'),
('méxico', 'ciudad de méxico'),
('méxico', 'jalisco'),
('méxico', 'nuevo león'),
('méxico', 'puebla'),
('méxico', 'veracruz'),
('nicaragua', 'chontales'),
('nicaragua', 'granada'),
('nicaragua', 'león'),
('nicaragua', 'managua'),
('nicaragua', 'matagalpa'),
('panamá', 'chiriquí'),
('panamá', 'coclé'),
('panamá', 'colón'),
('panamá', 'panamá'),
('panamá', 'veraguas'),
('paraguay', 'alto paraguay'),
('paraguay', 'asunción'),
('paraguay', 'central'),
('paraguay', 'cordillera'),
('paraguay', 'itapúa'),
('perú', 'arequipa'),
('perú', 'cusco'),
('perú', 'la libertad'),
('perú', 'lima'),
('perú', 'piura'),
('puerto rico', 'bayamón'),
('puerto rico', 'caguas'),
('puerto rico', 'mayagüez'),
('puerto rico', 'ponce'),
('puerto rico', 'san juan'),
('uruguay', 'canelones'),
('uruguay', 'colonia'),
('uruguay', 'maldonado'),
('uruguay', 'montevideo'),
('uruguay', 'salto'),
('venezuela', 'bolívar'),
('venezuela', 'caracas'),
('venezuela', 'lara'),
('venezuela', 'miranda'),
('venezuela', 'zulia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `nroRep` int(11) NOT NULL,
  `fechaDesde` date DEFAULT NULL,
  `fechaHasta` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `nombreRol` char(10) NOT NULL,
  `privilegios` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`nombreRol`, `privilegios`) VALUES
('admin', 10),
('moderador', 5),
('user', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tematica`
--

CREATE TABLE `tematica` (
  `nombreTem` char(20) NOT NULL,
  `descr` char(60) DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tematica`
--

INSERT INTO `tematica` (`nombreTem`, `descr`, `estado`) VALUES
('economia', 'dolar, peso, inflacion', 1),
('impuestos', 'tarifas, boletas, iva', 1),
('inseguridad', 'robos, miedo, delincuentes', 1),
('medio ambiente', 'hojas, poda, riego, suciedad', 1),
('obras publicas', 'veredas, calles, alumbrado', 1),
('prueba', '', 0),
('religion', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trata`
--

CREATE TABLE `trata` (
  `nroPet` int(11) NOT NULL,
  `nombreTem` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `correo` char(40) NOT NULL,
  `nombreUsuario` char(25) NOT NULL,
  `contrasena` char(60) NOT NULL,
  `fechaCreacion` date NOT NULL DEFAULT curdate(),
  `verificado` int(1) NOT NULL DEFAULT 0,
  `sancion` int(3) NOT NULL DEFAULT 0,
  `imagen` char(43) NOT NULL DEFAULT 'default.png',
  `valoracion` int(11) NOT NULL DEFAULT 0,
  `nombreRol` char(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `informe`
--
DROP TABLE IF EXISTS `informe`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `informe`  AS SELECT `mes`.`mes` AS `mes`, coalesce(`pets`.`cantidadPeticiones`,0) AS `cantidadPeticiones`, coalesce(`bajas`.`cantidadBajas`,0) AS `cantidadBajas`, coalesce(`admitidas`.`cantidadAdmitidas`,0) AS `cantidadAdmitidas`, coalesce(`exitosas`.`cantidadExitosas`,0) AS `cantidadExitosas`, coalesce(`noadmitidas`.`cantidadNoAdmitidas`,0) AS `cantidadNoAdmitidas`, coalesce(`usuarios`.`cantidadUsuariosNuevos`,0) AS `cantidadUsuariosNuevos`, coalesce(`firmas`.`cantidadFirmas`,0) AS `cantidadFirmas`, coalesce(`registradas`.`cantidadRegistradas`,0) AS `cantidadRegistradas`, coalesce(`noregistradas`.`cantidadNoRegistradas`,0) AS `cantidadNoRegistradas`, coalesce(`publicas`.`cantidadPublicas`,0) AS `cantidadPublicas`, coalesce(`anonimas`.`cantidadAnonimas`,0) AS `cantidadAnonimas` FROM ((((((((((((select distinct date_format(`peticion`.`fecha`,'%Y-%m') AS `mes` from `peticion` union select distinct date_format(`usuario`.`fechaCreacion`,'%Y-%m') AS `mes` from `usuario` union select distinct date_format(`firma`.`fecha`,'%Y-%m') AS `mes` from `firma`) `mes` left join (select date_format(`peticion`.`fecha`,'%Y-%m') AS `mes`,count(`peticion`.`nroPet`) AS `cantidadPeticiones` from `peticion` group by date_format(`peticion`.`fecha`,'%Y-%m')) `pets` on(`mes`.`mes` = `pets`.`mes`)) left join (select date_format(`peticion`.`fecha`,'%Y-%m') AS `mes`,count(`peticion`.`nroPet`) AS `cantidadBajas` from `peticion` where `peticion`.`estado` = -2 group by date_format(`peticion`.`fecha`,'%Y-%m')) `bajas` on(`mes`.`mes` = `bajas`.`mes`)) left join (select date_format(`peticion`.`fecha`,'%Y-%m') AS `mes`,count(`peticion`.`nroPet`) AS `cantidadAdmitidas` from `peticion` where `peticion`.`estado` >= 0 group by date_format(`peticion`.`fecha`,'%Y-%m')) `admitidas` on(`mes`.`mes` = `admitidas`.`mes`)) left join (select date_format(`peticion`.`fecha`,'%Y-%m') AS `mes`,count(`peticion`.`nroPet`) AS `cantidadNoAdmitidas` from `peticion` where `peticion`.`estado` = -1 group by date_format(`peticion`.`fecha`,'%Y-%m')) `noadmitidas` on(`mes`.`mes` = `noadmitidas`.`mes`)) left join (select date_format(`peticion`.`fecha`,'%Y-%m') AS `mes`,count(`peticion`.`nroPet`) AS `cantidadExitosas` from `peticion` where `peticion`.`estado` >= 1 group by date_format(`peticion`.`fecha`,'%Y-%m')) `exitosas` on(`mes`.`mes` = `exitosas`.`mes`)) left join (select date_format(`usuario`.`fechaCreacion`,'%Y-%m') AS `mes`,count(`usuario`.`correo`) AS `cantidadUsuariosNuevos` from `usuario` group by date_format(`usuario`.`fechaCreacion`,'%Y-%m')) `usuarios` on(`mes`.`mes` = `usuarios`.`mes`)) left join (select date_format(`firma`.`fecha`,'%Y-%m') AS `mes`,count(`firma`.`idFirma`) AS `cantidadFirmas` from `firma` group by date_format(`firma`.`fecha`,'%Y-%m')) `firmas` on(`mes`.`mes` = `firmas`.`mes`)) left join (select date_format(`firma`.`fecha`,'%Y-%m') AS `mes`,count(`firma`.`idFirma`) AS `cantidadRegistradas` from `firma` where `firma`.`correo` <> '' and `firma`.`ip` = '0.0.0.0' group by date_format(`firma`.`fecha`,'%Y-%m')) `registradas` on(`mes`.`mes` = `registradas`.`mes`)) left join (select date_format(`firma`.`fecha`,'%Y-%m') AS `mes`,count(`firma`.`idFirma`) AS `cantidadNoRegistradas` from `firma` where `firma`.`correo` = '' and `firma`.`ip` <> '0.0.0.0' group by date_format(`firma`.`fecha`,'%Y-%m')) `noregistradas` on(`mes`.`mes` = `noregistradas`.`mes`)) left join (select date_format(`firma`.`fecha`,'%Y-%m') AS `mes`,count(`firma`.`idFirma`) AS `cantidadPublicas` from `firma` where `firma`.`anon` = 0 group by date_format(`firma`.`fecha`,'%Y-%m')) `publicas` on(`mes`.`mes` = `publicas`.`mes`)) left join (select date_format(`firma`.`fecha`,'%Y-%m') AS `mes`,count(`firma`.`idFirma`) AS `cantidadAnonimas` from `firma` where `firma`.`anon` = 1 group by date_format(`firma`.`fecha`,'%Y-%m')) `anonimas` on(`mes`.`mes` = `anonimas`.`mes`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `peticion_objetivo`
--
DROP TABLE IF EXISTS `peticion_objetivo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `peticion_objetivo`  AS SELECT `p`.`nroPet` AS `numero`, `p`.`estado` AS `estado`, `p`.`objFirmas` AS `objetivo`, count(`f`.`nroPet`) AS `firmas` FROM (`peticion` `p` left join `firma` `f` on(`p`.`nroPet` = `f`.`nroPet`)) GROUP BY `p`.`nroPet`, `p`.`estado`, `p`.`objFirmas` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abarca`
--
ALTER TABLE `abarca`
  ADD PRIMARY KEY (`nroEnc`,`nombreTem`),
  ADD KEY `nombreTem` (`nombreTem`);

--
-- Indices de la tabla `afiliado`
--
ALTER TABLE `afiliado`
  ADD PRIMARY KEY (`correo`),
  ADD KEY `afiliado_ibfk_2` (`nombrePais`,`nombreProv`,`nombreLoc`);

--
-- Indices de la tabla `destino`
--
ALTER TABLE `destino`
  ADD PRIMARY KEY (`nombreDest`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`nroEnc`);

--
-- Indices de la tabla `firma`
--
ALTER TABLE `firma`
  ADD PRIMARY KEY (`idFirma`),
  ADD UNIQUE KEY `nroPet` (`nroPet`,`correo`,`ip`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`nroPet`,`nroImg`);

--
-- Indices de la tabla `interesa`
--
ALTER TABLE `interesa`
  ADD PRIMARY KEY (`correo`,`nombreTem`),
  ADD KEY `nombreTem` (`nombreTem`);

--
-- Indices de la tabla `ipdir`
--
ALTER TABLE `ipdir`
  ADD PRIMARY KEY (`ip`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`nombrePais`,`nombreProv`,`nombreLoc`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`nombrePais`);

--
-- Indices de la tabla `peticion`
--
ALTER TABLE `peticion`
  ADD PRIMARY KEY (`nroPet`),
  ADD KEY `correo` (`correo`),
  ADD KEY `nroPet_multiple` (`nroPet_multiple`),
  ADD KEY `peticion_ibfk_2` (`nombreDest`),
  ADD KEY `peticion_ibfk_3` (`nombrePais`,`nombreProv`,`nombreLoc`);

--
-- Indices de la tabla `peticionmultiple`
--
ALTER TABLE `peticionmultiple`
  ADD PRIMARY KEY (`nroPet`);

--
-- Indices de la tabla `peticionplus`
--
ALTER TABLE `peticionplus`
  ADD PRIMARY KEY (`nroPet`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`nombrePais`,`nombreProv`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`nroRep`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`nombreRol`);

--
-- Indices de la tabla `tematica`
--
ALTER TABLE `tematica`
  ADD PRIMARY KEY (`nombreTem`);

--
-- Indices de la tabla `trata`
--
ALTER TABLE `trata`
  ADD PRIMARY KEY (`nroPet`,`nombreTem`),
  ADD KEY `trata_ibfk_2` (`nombreTem`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`correo`),
  ADD KEY `nombreRol` (`nombreRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `nroEnc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `firma`
--
ALTER TABLE `firma`
  MODIFY `idFirma` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `peticion`
--
ALTER TABLE `peticion`
  MODIFY `nroPet` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `nroRep` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `abarca`
--
ALTER TABLE `abarca`
  ADD CONSTRAINT `abarca_ibfk_1` FOREIGN KEY (`nroEnc`) REFERENCES `encuesta` (`nroEnc`) ON UPDATE CASCADE,
  ADD CONSTRAINT `abarca_ibfk_2` FOREIGN KEY (`nombreTem`) REFERENCES `tematica` (`nombreTem`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `afiliado`
--
ALTER TABLE `afiliado`
  ADD CONSTRAINT `afiliado_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `afiliado_ibfk_2` FOREIGN KEY (`nombrePais`,`nombreProv`,`nombreLoc`) REFERENCES `localidad` (`nombrePais`, `nombreProv`, `nombreLoc`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `firma`
--
ALTER TABLE `firma`
  ADD CONSTRAINT `firma_ibfk_1` FOREIGN KEY (`nroPet`) REFERENCES `peticion` (`nroPet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `imagen_ibfk_1` FOREIGN KEY (`nroPet`) REFERENCES `peticion` (`nroPet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `interesa`
--
ALTER TABLE `interesa`
  ADD CONSTRAINT `interesa_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `interesa_ibfk_2` FOREIGN KEY (`nombreTem`) REFERENCES `tematica` (`nombreTem`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `localidad_ibfk_1` FOREIGN KEY (`nombrePais`,`nombreProv`) REFERENCES `provincia` (`nombrePais`, `nombreProv`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `peticion`
--
ALTER TABLE `peticion`
  ADD CONSTRAINT `peticion_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peticion_ibfk_2` FOREIGN KEY (`nombreDest`) REFERENCES `destino` (`nombreDest`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `peticion_ibfk_3` FOREIGN KEY (`nombrePais`,`nombreProv`,`nombreLoc`) REFERENCES `localidad` (`nombrePais`, `nombreProv`, `nombreLoc`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `peticion_ibfk_4` FOREIGN KEY (`nroPet_multiple`) REFERENCES `peticionmultiple` (`nroPet`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `peticionmultiple`
--
ALTER TABLE `peticionmultiple`
  ADD CONSTRAINT `peticionmultiple_ibfk_1` FOREIGN KEY (`nroPet`) REFERENCES `peticion` (`nroPet`) ON DELETE CASCADE;

--
-- Filtros para la tabla `peticionplus`
--
ALTER TABLE `peticionplus`
  ADD CONSTRAINT `peticionplus_ibfk_1` FOREIGN KEY (`nroPet`) REFERENCES `peticion` (`nroPet`) ON DELETE CASCADE;

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `provincia_ibfk_1` FOREIGN KEY (`nombrePais`) REFERENCES `pais` (`nombrePais`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `trata`
--
ALTER TABLE `trata`
  ADD CONSTRAINT `trata_ibfk_1` FOREIGN KEY (`nroPet`) REFERENCES `peticion` (`nroPet`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `trata_ibfk_2` FOREIGN KEY (`nombreTem`) REFERENCES `tematica` (`nombreTem`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`nombreRol`) REFERENCES `rol` (`nombreRol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
