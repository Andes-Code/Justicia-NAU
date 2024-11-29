-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2024 a las 20:32:31
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtener_reporte` (IN `p_pais` VARCHAR(100), IN `p_provincia` VARCHAR(100), IN `p_localidad` VARCHAR(100), IN `p_tematica` VARCHAR(100), IN `p_mes` VARCHAR(7))   BEGIN
    SELECT 
        mes.mes,
        IFNULL(pets.cantidadPeticiones, 0) AS cantidadPeticiones,
        IFNULL(local.cantidadPeticionesLocalidad, 0) AS cantidadPeticionesLocalidad,
        IFNULL(tema.cantidadPeticionesTematica, 0) AS cantidadPeticionesTematica
    FROM 
        (
            -- Subconsulta para generar la lista de meses
            SELECT DISTINCT DATE_FORMAT(fecha, '%Y-%m') AS mes
            FROM peticion
        ) AS mes

    LEFT JOIN
        (
            -- Contar peticiones totales por mes
            SELECT 
                DATE_FORMAT(fecha, '%Y-%m') AS mes,
                COUNT(nroPet) AS cantidadPeticiones
            FROM peticion
            GROUP BY mes
        ) pets ON mes.mes = pets.mes

    LEFT JOIN
        (
            -- Contar peticiones en una localidad específica
            SELECT 
                DATE_FORMAT(fecha, '%Y-%m') AS mes,
                COUNT(nroPet) AS cantidadPeticionesLocalidad
            FROM peticion
            WHERE 
                nombrePais = p_pais AND    -- Usar parámetro de país
                nombreProv = p_provincia AND  -- Usar parámetro de provincia
                nombreLoc = p_localidad   -- Usar parámetro de localidad
            GROUP BY mes
        ) local ON mes.mes = local.mes

    LEFT JOIN
        (
            -- Contar peticiones en una localidad con una temática específica
            SELECT 
                DATE_FORMAT(peticion.fecha, '%Y-%m') AS mes,
                COUNT(peticion.nroPet) AS cantidadPeticionesTematica
            FROM peticion
            INNER JOIN trata ON peticion.nroPet = trata.nroPet
            WHERE 
                peticion.nombrePais = p_pais AND   -- Usar parámetro de país
                peticion.nombreProv = p_provincia AND  -- Usar parámetro de provincia
                peticion.nombreLoc = p_localidad AND   -- Usar parámetro de localidad
                trata.nombreTem = p_tematica   -- Usar parámetro de temática
            GROUP BY mes
        ) tema ON mes.mes = tema.mes
    WHERE mes.mes = p_mes;  -- Filtrar por el mes especificado
END$$

DELIMITER ;

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
-- Estructura de tabla para la tabla `estatuto`
--

CREATE TABLE `estatuto` (
  `correo` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estatuto`
--

INSERT INTO `estatuto` (`correo`) VALUES
('yoanaa@gmail.com');

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

--
-- Volcado de datos para la tabla `firma`
--

INSERT INTO `firma` (`idFirma`, `nroPet`, `correo`, `ip`, `comentario`, `anon`, `fecha`) VALUES
(1, 2, 'gsanti.sg17@gmail.com', '0.0.0.0', 'fua bro estas loco', 0, '2024-08-20'),
(2, 2, 'gsanti.sg2002@gmail.com', '0.0.0.0', '', 0, '2024-07-16'),
(3, 2, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 0, '2024-08-20'),
(4, 4, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-22'),
(5, 4, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'firma nueva', 0, '2024-08-09'),
(6, 5, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-07'),
(7, 5, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'soy gay', 1, '2024-08-03'),
(8, 10, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 1, '2024-08-07'),
(10, 27, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-07'),
(11, 27, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 0, '2024-08-03'),
(12, 28, 'caballerolautarodev@gmail.com', '0.0.0.0', 'Me encanta!', 0, '2024-08-28'),
(13, 28, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 1, '2024-08-07'),
(14, 28, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 0, '2024-08-09'),
(15, 29, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 1, '2024-08-07'),
(16, 29, 'mariangelesgmnz@gmail.com', '0.0.0.0', 'Estoy de acuerdo ', 0, '2024-08-09'),
(18, 30, 'aaa@a.com', '0.0.0.0', '', 0, '2024-08-22'),
(19, 30, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-20'),
(20, 30, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 1, '2024-08-21'),
(21, 31, 'aaa@a.com', '0.0.0.0', '', 0, '2024-08-22'),
(23, 34, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-21'),
(24, 34, 'gsanti.sg2002@gmail.com', '0.0.0.0', '', 0, '0000-00-00'),
(25, 34, 'mariangelesgmnz@gmail.com', '0.0.0.0', '', 0, '0000-00-00'),
(26, 34, 'penelope@cruz.com', '0.0.0.0', '', 0, '0000-00-00'),
(27, 34, 'sannntis1708@gmail.com', '0.0.0.0', '', 0, '0000-00-00'),
(29, 34, 'santutu@gmail.com', '0.0.0.0', '', 0, '0000-00-00'),
(30, 34, 'usuario10@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(31, 34, 'usuario11@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(32, 34, 'usuario12@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(33, 34, 'usuario13@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(34, 34, 'usuario14@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(35, 34, 'usuario15@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(36, 34, 'usuario1@example.com', '0.0.0.0', '', 0, '0000-00-00'),
(37, 34, 'usuario2@example.com', '0.0.0.0', '', 0, '0000-00-00'),
(38, 34, 'usuario3@example.com', '0.0.0.0', '', 0, '0000-00-00'),
(39, 34, 'usuario4@example.com', '0.0.0.0', '', 0, '0000-00-00'),
(40, 34, 'usuario5@example.com', '0.0.0.0', '', 0, '0000-00-00'),
(41, 34, 'usuario6@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(42, 34, 'usuario7@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(43, 34, 'usuario8@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(44, 34, 'usuario9@example.com', '0.0.0.0', '', 0, '2024-08-21'),
(45, 41, 'gsanti.sg17@gmail.com', '0.0.0.0', 'aaaaaaaaa poteito', 1, '2024-08-20'),
(46, 41, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 0, '2024-08-20'),
(47, 47, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 1, '2024-08-20'),
(48, 48, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-20'),
(51, 51, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 1, '2024-08-20'),
(52, 52, 'aaa@a.com', '0.0.0.0', '', 0, '2024-08-22'),
(54, 53, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 1, '2024-08-20'),
(55, 58, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 0, '2024-08-20'),
(56, 59, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 0, '2024-08-20'),
(58, 62, 'gsanti.sg17@gmail.com', '0.0.0.0', 'hola soy yo', 0, '2024-08-20'),
(60, 63, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-20'),
(62, 65, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 0, '2024-08-28'),
(65, 69, 'caballerolautarodev@gmail.com', '0.0.0.0', '', 0, '2024-08-28'),
(66, 72, 'caballerolautarodev@gmail.com', '0.0.0.0', 'Hola qué tal', 0, '2024-08-28'),
(67, 73, 'caballerolautarodev@gmail.com', '0.0.0.0', '', 0, '2024-08-28'),
(70, 76, 'gsanti.sg17@gmail.com', '0.0.0.0', '', 1, '2024-09-03'),
(73, 76, '', '::1', '', 0, '2024-09-09'),
(74, 74, '', '::1', '', 0, '2024-09-09'),
(77, 74, '', '190.176.43.39', '', 0, '2024-09-09'),
(78, 73, '', '190.176.43.39', '', 0, '2024-09-09'),
(79, 72, '', '190.176.43.39', '', 0, '2024-09-09'),
(80, 71, '', '190.176.43.39', '', 1, '2024-09-09'),
(81, 76, '', '190.176.43.39', '', 1, '2024-09-09'),
(82, 69, '', '190.176.43.39', 'Aaa', 1, '2024-09-09'),
(83, 68, '', '190.176.43.39', 'Oooo', 0, '2024-09-09'),
(84, 65, '', '190.176.43.39', '', 0, '2024-09-09'),
(85, 62, '', '190.176.43.39', '', 0, '2024-09-09'),
(86, 76, '', '186.141.229.41', '', 0, '2024-09-09'),
(90, 10, '', '::1', 'aaaa', 1, '2024-09-10'),
(95, 76, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'aaa ultima firma', 0, '2024-09-16'),
(101, 3, 'santigimenez.20020817@gmail.com', '0.0.0.0', '', 0, '2024-09-17'),
(103, 31, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'joer tio', 0, '2024-09-20'),
(105, 74, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'aaaa', 0, '2024-09-20'),
(106, 10, 'caballerolautarodev@gmail.com', '0.0.0.0', '', 1, '2024-09-20'),
(107, 29, 'caballerolautarodev@gmail.com', '0.0.0.0', '', 1, '2024-09-20'),
(128, 65, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'hh', 0, '2024-11-27'),
(130, 63, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'pelele', 0, '2024-11-27'),
(132, 50, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'gaga', 0, '2024-11-27'),
(134, 34, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'SOY MUY FACHERO', 0, '2024-11-27'),
(135, 71, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'chi', 1, '2024-11-28'),
(136, 68, 'santigimenez.20020817@gmail.com', '0.0.0.0', 'jiji', 0, '2024-11-28'),
(137, 37, 'yoanaa@gmail.com', '0.0.0.0', '', 0, '2024-11-28'),
(138, 38, 'yoanaa@gmail.com', '0.0.0.0', '', 0, '2024-11-28'),
(139, 35, 'yoanaa@gmail.com', '0.0.0.0', '', 0, '2024-11-28'),
(140, 33, 'yoanaa@gmail.com', '0.0.0.0', '', 0, '2024-11-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `nroPet` int(11) NOT NULL,
  `nroImg` int(11) NOT NULL,
  `extension` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`nroPet`, `nroImg`, `extension`) VALUES
(2, 1, 'jpeg'),
(2, 2, 'jpeg'),
(2, 3, 'png'),
(2, 4, 'png'),
(3, 1, 'jpeg'),
(3, 2, 'jpg'),
(3, 3, 'jpeg'),
(4, 1, 'jpg'),
(5, 1, 'jpeg'),
(5, 2, 'jpg'),
(27, 1, 'png'),
(27, 2, 'jpg'),
(27, 3, 'jpg'),
(27, 4, 'png'),
(28, 1, 'jpg'),
(29, 1, 'png'),
(29, 2, 'png'),
(30, 1, 'jpg'),
(31, 1, 'png'),
(66, 1, 'jpeg'),
(73, 1, 'jpeg'),
(73, 2, 'jpeg'),
(76, 1, 'jpg'),
(78, 1, 'png'),
(79, 1, 'png');

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

--
-- Volcado de datos para la tabla `interesa`
--

INSERT INTO `interesa` (`correo`, `nombreTem`) VALUES
('caballerolautarodev@gmail.com', 'economia'),
('caballerolautarodev@gmail.com', 'inseguridad'),
('santigimenez.20020817@gmail.com', 'economia'),
('santigimenez.20020817@gmail.com', 'inseguridad'),
('santigimenez.20020817@gmail.com', 'obras publicas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ipdir`
--

CREATE TABLE `ipdir` (
  `ip` char(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ipdir`
--

INSERT INTO `ipdir` (`ip`) VALUES
('186.141.229.41'),
('190.176.43.39'),
('::1');

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

--
-- Volcado de datos para la tabla `peticion`
--

INSERT INTO `peticion` (`nroPet`, `estado`, `objFirmas`, `titulo`, `cuerpo`, `fecha`, `correo`, `nombreDest`, `nombrePais`, `nombreProv`, `nombreLoc`, `nroPet_multiple`) VALUES
(2, -1, 100, 'desarrollador loco', 'soy el desarrollador loco, estoy medio loquito y me pican los cocos, esto es un lorem ipsum ultra caserito', '2024-07-15 00:00:00', 'santigimenez.20020817@gmail.com', 'gobierno de san juan', 'argentina', 'san juan', 'caucete', NULL),
(3, -1, 1000, 'desarrollador freelancer', 'asdasdde php::penepe', '2024-07-15 00:00:00', 'santigimenez.20020817@gmail.com', 'javier milei', 'argentina', 'san juan', 'caucete', NULL),
(4, 0, 300, 'Desarrollador 3 peiticionando', 'Esto es una peticion realizada en el dia de la fecha para probar el funcionamiento de la base de datos y el sistema en su etapa temprana', '2024-07-16 00:00:00', 'gsanti.sg17@gmail.com', NULL, NULL, NULL, NULL, NULL),
(5, 0, 500, 'Peticion con 2 imagenes', 'esta es una peticion creada para probar como se ve el post cuando cuenta con dos imagenes, posteriormente se creara uno que contenga tres imagenes', '2024-07-19 00:00:00', 'gsanti.sg2002@gmail.com', NULL, 'argentina', 'san juan', 'caucete', NULL),
(10, 0, 12500, 'penelopecrus soy', 'penelope crus estuvo aqui haciendo esta peticion', '2024-07-25 00:00:00', 'santigimenez.20020817@gmail.com', 'javier milei', 'argentina', 'san juan', 'caucete', NULL),
(27, 1, 150000, 'esta e sla lalalal peticion 1 ajkndlaksnmd', 'jamdsflkadñljnasdlan sdjlansdkjans dlkaj sdlka msldmasl dmasdkam fpwfjawoenf gfqwnsñdlkf d fdqknd odfi sdofn ajdfn ñJNF SADFN MWIFEJ MOAÑNF ', '2024-07-29 00:00:00', 'santigimenez.20020817@gmail.com', 'javier milei', NULL, NULL, NULL, NULL),
(28, -1, 101, 'Soy Juan Horacio Gonzalez', 'Hola! Esta es mi primera petición. Estoy muy contento de estar aquí y poder colaborar con todos ustedes. Espero poder contribuir con toda buena causa y ayudar al mundo a ser un lugar mejor', '2024-07-30 00:00:00', 'penelope@cruz.com', 'gobierno de san juan', NULL, NULL, NULL, NULL),
(29, -1, 5000, 'Mal gasto del dinero publico', 'La semana pasada se dio a conocer que el gobierno provincial brindará dinero publico a los municipios para la pavimentación de las calles, y la intendente del departamento de Caucete, en lugar de arreglar las calles céntricas, donde mas trafico hay, prefiere arreglar las calles de los barrios sin darle ninguna importancia a las calles céntricas, valga la redundancia', '2024-08-05 00:00:00', 'santigimenez.20020817@gmail.com', 'romina rosas', NULL, NULL, NULL, NULL),
(30, -1, 200, 'Calle de Aberastain rotas', 'Jsjsisisjbsbdbsjwjwbdbdjdkdksnsnsn ss nskzkxoslsnwns. Zksns snksosksbw wnskodkdbs qnskoxlwbs. Xkskosknsbbdksklsknbs noxknsb. Akdoplwnbjaiikdn bien fjkxlskksnwndndksisknq sndndkdkkb! Kei; si jejeje! Si jwjxuwbskdke! Sjwnfisyw? Ysbskfyb! Dndkskeknt hols bwisooakrn ffyd? Bnksklskqnenndllslskkkskskskskskskskskskskskdkjddjdjjddjjdjdbebevevevevevvevevevevevevevevvevvevevevvevevevevememememmemeememmememammamamamamamsmmrmrmrmrmrmrmrmrmrmisisiaiaiaiaiisajbwbfndnkfkknsn. Dnkdkfijdbsb f fndmkdksksjwjjd', '2024-08-09 00:00:00', 'mariangelesgmnz@gmail.com', NULL, NULL, NULL, NULL, NULL),
(31, 1, 850, 'estoy loquita sapeeeee', 'esta es una peticion donde declaro estar loquita saaape poruq elas locquitas como yo no pueden ser encerradas sape chupate una japi', '2024-08-19 00:00:00', 'santigimenez.20020817@gmail.com', 'romina rosas', NULL, NULL, NULL, NULL),
(33, 0, 1001, 'asdasdasdasd', 'asdasdasdasd asdasdasdasd asdasdasdasd.l.lll asdasdasdasd asdasdasdasd asdasdasdasdasdasda asdasdasd', '2024-08-19 20:05:04', 'mariangelesgmnz@gmail.com', 'gobierno de san juan', 'argentina', 'san juan', 'caucete', NULL),
(34, 0, 1001, 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', 'asdasdasdasd asdasdasdasd asdasdasdasd.l.lll asdasdasdasd asdasdasdasd asdasdasdasdasdasda asdasdasd', '2024-08-19 20:06:03', 'mariangelesgmnz@gmail.com', 'gobierno de san juan', 'argentina', 'san juan', 'caucete', NULL),
(35, 0, 103, 'queeee peto que pasa tio como estas', 'iejejei pero que pasa cahvales todo bien todo correcto? y yo quw me alegro maderfakers. Como estais? yo bien no', '2024-08-19 21:16:05', 'sannntis1708@gmail.com', NULL, NULL, NULL, NULL, NULL),
(36, 0, 1200, 'Implementación de programas de reciclaje', 'Solicito que se implementen programas de reciclaje en nuestra comunidad para reducir el impacto ambiental.', '2024-08-20 15:38:27', 'usuario6@example.com', NULL, NULL, NULL, NULL, NULL),
(37, 0, 700, 'Ampliación de horarios en bibliotecas públicas', 'Pedimos que se amplíen los horarios de las bibliotecas públicas para estudiantes y trabajadores.', '2024-08-20 15:38:27', 'usuario7@example.com', NULL, NULL, NULL, NULL, NULL),
(38, 0, 400, 'Control de ruido en zonas residenciales', 'Exigimos la regulación del ruido en zonas residenciales debido al constante tráfico y construcciones.', '2024-08-20 15:38:27', 'usuario8@example.com', NULL, NULL, NULL, NULL, NULL),
(39, 0, 900, 'Iluminación pública en parques', 'Requerimos que se instale iluminación adecuada en los parques para mayor seguridad nocturna.', '2024-08-20 15:38:27', 'usuario9@example.com', NULL, NULL, NULL, NULL, NULL),
(40, 0, 600, 'Creación de ciclovías', 'Solicito la creación de ciclovías seguras para fomentar el uso de bicicletas como medio de transporte sostenible.', '2024-08-20 15:38:27', 'usuario10@example.com', NULL, NULL, NULL, NULL, NULL),
(41, 0, 1300, 'Prohibición del uso de plástico de un solo uso', 'Pedimos la prohibición del plástico de un solo uso en mercados y tiendas locales.', '2024-08-20 15:38:27', 'usuario11@example.com', NULL, NULL, NULL, NULL, NULL),
(42, 0, 1100, 'Mejora de servicios de atención al ciudadano', 'Solicito que se mejoren los servicios de atención al ciudadano en las oficinas gubernamentales.', '2024-08-20 15:38:27', 'usuario12@example.com', NULL, NULL, NULL, NULL, NULL),
(43, 0, 500, 'Restauración de monumentos históricos', 'Pedimos la restauración de los monumentos históricos que han sido descuidados en los últimos años.', '2024-08-20 15:38:27', 'usuario13@example.com', NULL, NULL, NULL, NULL, NULL),
(44, 0, 2500, 'Aumento de presupuesto para educación', 'Solicito un aumento en el presupuesto destinado a la educación para mejorar la infraestructura de las escuelas.', '2024-08-20 15:38:27', 'usuario14@example.com', NULL, NULL, NULL, NULL, NULL),
(45, 0, 1800, 'Accesibilidad en transporte público para personas con discapacidad', 'Exigimos que el transporte público sea más accesible para personas con discapacidad.', '2024-08-20 15:38:27', 'usuario15@example.com', NULL, NULL, NULL, NULL, NULL),
(46, 0, 1000, 'Mejora del servicio de transporte público', 'Solicito que se mejore el servicio de transporte público debido a constantes retrasos y mal estado de los vehículos.', '2024-08-20 15:38:36', 'usuario1@example.com', NULL, NULL, NULL, NULL, NULL),
(47, 0, 500, 'Protección de áreas verdes', 'Insto a las autoridades a preservar las áreas verdes en nuestro distrito, evitando proyectos que destruyan el medio ambiente.', '2024-08-20 15:38:36', 'usuario2@example.com', NULL, NULL, NULL, NULL, NULL),
(48, 0, 2000, 'Aumento de seguridad en las calles', 'Exigimos mayor presencia policial en nuestras calles debido al aumento de robos en las últimas semanas.', '2024-08-20 15:38:36', 'usuario3@example.com', NULL, NULL, NULL, NULL, NULL),
(49, 0, 1500, 'Mejora en la atención del hospital local', 'Pedimos una mejora en la calidad de atención en el hospital local, ya que los tiempos de espera son excesivos.', '2024-08-20 15:38:36', 'usuario4@example.com', NULL, NULL, NULL, NULL, NULL),
(50, 0, 800, 'Reparación urgente de las calles', 'Solicitamos la reparación inmediata de las calles principales que se encuentran en mal estado.', '2024-08-20 15:38:36', 'usuario5@example.com', NULL, NULL, NULL, NULL, NULL),
(51, 0, 1000, 'Implementación de más espacios deportivos', 'Solicitamos la creación de nuevos espacios deportivos para fomentar la actividad física en la comunidad.', '2024-08-20 15:39:57', 'usuario1@example.com', NULL, NULL, NULL, NULL, NULL),
(52, 0, 1600, 'Instalación de cámaras de seguridad', 'Pedimos la instalación de cámaras de seguridad en zonas vulnerables para reducir la criminalidad.', '2024-08-20 15:39:57', 'usuario2@example.com', NULL, NULL, NULL, NULL, NULL),
(53, 0, 2000, 'Reducción de tarifas de transporte público', 'Solicito una revisión y reducción de las tarifas del transporte público, ya que son demasiado altas.', '2024-08-20 15:39:57', 'usuario3@example.com', NULL, NULL, NULL, NULL, NULL),
(54, 0, 1200, 'Construcción de más parques infantiles', 'Exigimos la construcción de más parques infantiles para el desarrollo y recreación de los niños.', '2024-08-20 15:39:57', 'usuario4@example.com', NULL, NULL, NULL, NULL, NULL),
(55, -2, 900, 'Revisión de los impuestos municipales', 'Solicito una revisión de los impuestos municipales, ya que han aumentado sin una mejora en los servicios.', '2024-08-20 15:39:57', 'usuario5@example.com', NULL, NULL, NULL, NULL, NULL),
(56, -2, 1400, 'Prohibición de la tala indiscriminada', 'Solicito la prohibición inmediata de la tala de árboles en áreas protegidas.', '2024-08-20 15:39:57', 'usuario6@example.com', NULL, NULL, NULL, NULL, NULL),
(57, 0, 1500, 'Acceso a internet gratuito en áreas públicas', 'Pedimos que se ofrezca acceso gratuito a internet en plazas y parques públicos.', '2024-08-20 15:39:57', 'usuario7@example.com', NULL, NULL, NULL, NULL, NULL),
(58, 0, 1800, 'Aumento de fondos para la protección animal', 'Solicito que se aumenten los fondos destinados a la protección de animales callejeros.', '2024-08-20 15:39:57', 'usuario8@example.com', NULL, NULL, NULL, NULL, NULL),
(59, 0, 500, 'Regulación del uso de drones en zonas residenciales', 'Exigimos la regulación del uso de drones en zonas residenciales por motivos de privacidad.', '2024-08-20 15:39:57', 'usuario9@example.com', NULL, NULL, NULL, NULL, NULL),
(60, -2, 1000, 'Creación de centros comunitarios para jóvenes', 'Pedimos la creación de centros comunitarios para que los jóvenes puedan participar en actividades recreativas.', '2024-08-20 15:39:57', 'usuario10@example.com', NULL, NULL, NULL, NULL, NULL),
(61, 0, 1300, 'Ampliación de rutas de transporte nocturno', 'Solicito la ampliación de las rutas de transporte público nocturno para trabajadores y estudiantes.', '2024-08-20 15:39:57', 'usuario11@example.com', NULL, NULL, NULL, NULL, NULL),
(62, 0, 1700, 'Fomentar el uso de energías renovables', 'Solicitamos la promoción de proyectos de energía renovable en nuestra comunidad.', '2024-08-20 15:39:57', 'usuario12@example.com', NULL, NULL, NULL, NULL, NULL),
(63, 0, 1100, 'Aumento de servicios de salud mental', 'Pedimos un aumento en los servicios de salud mental disponibles en hospitales públicos.', '2024-08-20 15:39:57', 'usuario13@example.com', NULL, NULL, NULL, NULL, NULL),
(64, -2, 2000, 'Construcción de refugios para personas sin hogar', 'Solicito la construcción de refugios que brinden apoyo a personas sin hogar.', '2024-08-20 15:39:57', 'usuario14@example.com', NULL, NULL, NULL, NULL, NULL),
(65, 0, 1600, 'Mayor control en la emisión de licencias de construcción', 'Exigimos un control más estricto en la emisión de licencias de construcción en zonas residenciales.', '2024-08-20 15:39:57', 'usuario15@example.com', NULL, NULL, NULL, NULL, NULL),
(66, 0, 1030, 'en guanajuato hay gays', 'todos son gays en guanajuato me tienen cansadp desde juanguato', '2024-08-22 20:30:42', 'gsanti.sg17@gmail.com', NULL, NULL, NULL, NULL, NULL),
(67, 0, 1010, 'peticion para probar vistas', 'esta peticion quiere probar la vista de las peticiones nuevas, no eliminar ni aceptar', '2024-08-22 20:41:21', 'gsanti.sg17@gmail.com', 'gobierno de san juan', NULL, NULL, NULL, NULL),
(68, 0, 350, 'en caucete sib gays', 'todos los cauceteeros son gays y s emueven en cabras porque para el caballo no les alcanza', '2024-08-26 15:39:20', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(69, 1, 102, 'peticion para crear destino', 'esta peticion busca crear un destino a traves de la creacion de la peticion', '2024-08-26 17:45:59', 'santigimenez.20020817@gmail.com', 'si funciono', NULL, NULL, NULL, NULL),
(70, 0, 103, 'esta oeticion es igual que la anterior', 'quiero crear el destino = &#34;si funciono&#34; para combinar el destino de la peticion anterior', '2024-08-26 17:47:05', 'santigimenez.20020817@gmail.com', 'si funciono', NULL, NULL, NULL, NULL),
(71, 0, 104, 'peticion para eliminarle el destino', 'esta peticion crea el destino eliminar para testear la app', '2024-08-26 17:57:30', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(72, 0, 105, 'esta peticion 2 verifica que se pueda eliminar el destino', 'tambien verifica un bug encontrado en tematicas que aparecio con la peticion anterior', '2024-08-26 18:00:09', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(73, 0, 777, 'El ECO está muy caro', 'Las tarifas de ECO son demasiado caras e impagables', '2024-08-28 13:30:55', 'caballerolautarodev@gmail.com', 'Gobierno de San Juan', NULL, NULL, NULL, NULL),
(74, 1, 3, 'aaaaaaa aaaaaaaaaa', 'aaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaa', '2024-08-28 13:40:02', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(75, 0, 101, 'aaaaaaaaaa aaaaaaaaaa', ' aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-08-28 13:54:25', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(76, 2, 5, 'aaaaaa aaaaaaaaaaa', 'aaaaaaaaaaa aaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaa', '2024-08-29 16:06:40', 'santigimenez.20020817@gmail.com', 'javier milei', NULL, NULL, NULL, NULL),
(77, 0, 5000, 'precio caro cafe havana', 'quiero quejarme de los precios exagerados de la cafeteria havana en san juan', '2024-09-20 16:03:29', 'santigimenez.20020817@gmail.com', 'intendente de chimbas', NULL, NULL, NULL, NULL),
(78, 0, 5, 'caca pipi popo', 'cacaca lalalal lololo lelelele pepepe lilili lululu', '2024-10-11 00:19:37', 'santigimenez.20020817@gmail.com', 'javueb maluco', NULL, NULL, NULL, NULL),
(79, 0, 5, 'propiedad de bigdic', 'esra es la propiedad del bigdic facha', '2024-11-04 23:47:12', 'bigdic@gmail.com', NULL, 'argentina', 'san juan', 'caucete', NULL);

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
-- Estructura de tabla para la tabla `pruebafirma`
--

CREATE TABLE `pruebafirma` (
  `idFirma` int(11) NOT NULL,
  `nroPet` int(11) NOT NULL,
  `correo` char(40) NOT NULL DEFAULT '',
  `ip` char(45) NOT NULL DEFAULT '0.0.0.0',
  `comentario` tinytext DEFAULT NULL,
  `anon` int(1) DEFAULT 0,
  `fecha` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pruebafirma`
--

INSERT INTO `pruebafirma` (`idFirma`, `nroPet`, `correo`, `ip`, `comentario`, `anon`, `fecha`) VALUES
(5, 76, '', '12.54.232.21', NULL, 0, '0000-00-00');

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

--
-- Volcado de datos para la tabla `trata`
--

INSERT INTO `trata` (`nroPet`, `nombreTem`) VALUES
(2, 'economia'),
(3, 'economia'),
(3, 'inseguridad'),
(10, 'economia'),
(10, 'inseguridad'),
(27, 'economia'),
(28, 'obras publicas'),
(29, 'economia'),
(29, 'obras publicas'),
(31, 'inseguridad'),
(67, 'economia'),
(68, 'economia'),
(68, 'obras publicas'),
(73, 'impuestos'),
(73, 'obras publicas'),
(76, 'religion'),
(78, 'prueba');

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
  `nombreRol` char(10) NOT NULL DEFAULT 'user',
  `google_id` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`correo`, `nombreUsuario`, `contrasena`, `fechaCreacion`, `verificado`, `sancion`, `imagen`, `valoracion`, `nombreRol`, `google_id`) VALUES
('aaa@a.com', 'si', '$2y$10$pENpaMhH7MwzPKnKtd51c.j9nqRKAPAkoeFiWrqEMCNOwAX37Zd3W', '2024-07-10', 0, 10, 'default.png', 15, 'user', NULL),
('bigdic@gmail.com', 'bigdica', '$2y$10$/NGG/htN15I/TUdnwtwDVOax2HOfmUVU/ooKCRumEvRNnAgD3R6rS', '2024-11-04', 0, 0, 'bigdic.gmail.com.png', 0, 'user', NULL),
('caballerolautarodev@gmail.com', 'Lauro', '$2y$10$ODq6g4PXA/Yfo32jBsZQWeUn2cqTcSAdqZc6cLVuZYPe1wPrGc3.6', '2024-07-11', 0, 0, 'default.png', 60, 'user', NULL),
('gabriel.eder68@gmail.com', 'Gabriel', '$2y$10$IE1hu6OMoxCYQC9ghrbvaO//.8O5f6EJgyORdBVHjMv4nwyVSihRK', '2024-09-20', 0, 0, 'default.png', 0, 'moderador', NULL),
('gsanti.sg17@gmail.com', '', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-06-12', 0, 0, 'gsanti.sg17.gmail.com.jpg', 70, 'moderador', NULL),
('gsanti.sg2002@gmail.com', 'santiago gimenez', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 30, 'gsanti.sg2002.gmail.com.jpeg', 30, 'user', NULL),
('mariangelesgmnz@gmail.com', 'Maribr', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 30, 'default.png', 75, 'user', NULL),
('penelope@cruz.com', 'Juan Horacio', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 60, 'default.png', 15, 'user', NULL),
('sannntis1708@gmail.com', '', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'moderador', NULL),
('santigimenez.20020817@gmail.com', 'santiago gimenez', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 90, 'santigimenez.20020817.gmail.com.jpeg', 965, 'admin', NULL),
('santutu@gmail.com', 'penelope crus', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 0, 'user', NULL),
('soyo@gmail.com', '123456789soyo', '$2y$10$pPpwT4j44gCmn9Cf7GqTpuQMd2lVmNHN87HVpAJEIbFEBU0eb8N5K', '2024-11-27', 0, 0, 'default.png', 0, 'user', NULL),
('soyoa@gmail.com', '123456789soyoa', '$2y$10$DcdQCYM2G.5wy6oXQHHrT.wwmMmnSEEr5tJ53jkQ/CM6B1Nv.92ri', '2024-11-27', 0, 0, 'default.png', 0, 'user', NULL),
('soyoan@gmail.com', '123456789soyoan', '$2y$10$looTyuWuOnBvgSpbra54nuMAMpHnDcbkO7ooDnd1yK5zuE70dvfl.', '2024-11-27', 0, 0, 'default.png', 0, 'user', NULL),
('tecnova.stc@gmail.com', 'Santiago Gimenez', '$2y$10$EicBZvtf.wz3X60VSYUXCeCl1TE2FEkKTS1Tqp8SUgaVEdT4iNgTG', '2024-11-28', 0, 0, 'default.png', 0, 'user', '108446857575140929746'),
('unsj@edu.com.ar', 'aguelito', '$2y$10$fIxmZ7jNIvcfveef6d1FXuh6NoYRB9PTh2QRKxcCQQVggZPrjs1/a', '2024-09-18', 0, 0, 'default.png', 0, 'user', NULL),
('usuario10@example.com', 'user 10 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 30, 'default.png', 30, 'user', NULL),
('usuario11@example.com', 'user 11 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario12@example.com', 'user 12 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario13@example.com', 'user 13 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario14@example.com', 'user 14 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 30, 'default.png', 30, 'user', NULL),
('usuario15@example.com', 'user 15 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario1@example.com', 'user 1 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario2@example.com', 'user 2 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario3@example.com', 'user 3 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario4@example.com', 'user 4 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('usuario5@example.com', 'user 5 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 30, 'default.png', 30, 'user', NULL),
('usuario6@example.com', 'user 6 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 30, 'default.png', 30, 'user', NULL),
('usuario7@example.com', 'user 7 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 90, 'user', NULL),
('usuario8@example.com', 'user 8 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 90, 'user', NULL),
('usuario9@example.com', 'user 9 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', '2024-09-18', 0, 0, 'default.png', 60, 'user', NULL),
('yoan@gmail.com', '123456789yoan', '$2y$10$AE7ODRAoeddq.jMv39o8kOMjSWMBPRDm2pzKFhOXihHX5qSUOC7SC', '2024-11-27', 0, 0, 'default.png', 0, 'user', NULL),
('yoanaa@gmail.com', '123456789yoanaa', '$2y$10$KWXUWOuMRT6y/2yLvdEYk.Lzu13tmvXSClOURlinkvEoyK9HF7YLS', '2024-11-27', 0, 0, 'default.png', 20, 'user', NULL),
('yoano@gmail.com', '123456789yoano', '$2y$10$6Bnn01/kEJNfaxrvF2xcDOapM3H4KV5G6tNMQZaQiaIpWt1NY6fLW', '2024-11-27', 0, 0, 'default.png', 0, 'user', NULL);

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
-- Indices de la tabla `estatuto`
--
ALTER TABLE `estatuto`
  ADD PRIMARY KEY (`correo`);

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
-- Indices de la tabla `pruebafirma`
--
ALTER TABLE `pruebafirma`
  ADD PRIMARY KEY (`idFirma`),
  ADD UNIQUE KEY `nroPet` (`nroPet`,`correo`,`ip`),
  ADD KEY `correo` (`correo`),
  ADD KEY `ip` (`ip`);

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
  MODIFY `idFirma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de la tabla `peticion`
--
ALTER TABLE `peticion`
  MODIFY `nroPet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `pruebafirma`
--
ALTER TABLE `pruebafirma`
  MODIFY `idFirma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Filtros para la tabla `estatuto`
--
ALTER TABLE `estatuto`
  ADD CONSTRAINT `estatuto_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`) ON UPDATE CASCADE;

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
-- Filtros para la tabla `pruebafirma`
--
ALTER TABLE `pruebafirma`
  ADD CONSTRAINT `pruebafirma_ibfk_1` FOREIGN KEY (`nroPet`) REFERENCES `peticion` (`nroPet`) ON DELETE CASCADE;

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
