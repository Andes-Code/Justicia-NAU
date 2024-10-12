-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2024 a las 02:47:14
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
('javier milei', 'presidente de la republica arg', 1),
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
  `nroPet` int(11) NOT NULL,
  `correo` char(40) NOT NULL,
  `comentario` tinytext DEFAULT NULL,
  `anon` int(1) NOT NULL DEFAULT 0,
  `fecha` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `firma`
--

INSERT INTO `firma` (`nroPet`, `correo`, `comentario`, `anon`, `fecha`) VALUES
(2, 'gsanti.sg17@gmail.com', 'fua bro estas loco', 0, '2024-08-20'),
(2, 'gsanti.sg2002@gmail.com', NULL, 0, '2024-07-16'),
(2, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(4, 'gsanti.sg17@gmail.com', '', 0, '2024-08-22'),
(4, 'santigimenez.20020817@gmail.com', 'firma nueva', 0, '2024-08-09'),
(5, 'gsanti.sg17@gmail.com', '', 0, '2024-08-07'),
(5, 'santigimenez.20020817@gmail.com', 'soy gay', 1, '2024-08-03'),
(10, 'gsanti.sg17@gmail.com', '', 1, '2024-08-07'),
(10, 'santigimenez.20020817@gmail.com', 'esta firma es anonima', 1, '2024-08-09'),
(27, 'gsanti.sg17@gmail.com', '', 0, '2024-08-07'),
(27, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-03'),
(28, 'caballerolautarodev@gmail.com', 'Me encanta!', 0, '2024-08-28'),
(28, 'gsanti.sg17@gmail.com', '', 1, '2024-08-07'),
(28, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-09'),
(29, 'gsanti.sg17@gmail.com', '', 1, '2024-08-07'),
(29, 'mariangelesgmnz@gmail.com', 'Estoy de acuerdo ', 0, '2024-08-09'),
(29, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-19'),
(30, 'aaa@a.com', '', 0, '2024-08-22'),
(30, 'gsanti.sg17@gmail.com', '', 0, '2024-08-20'),
(30, 'santigimenez.20020817@gmail.com', '', 1, '2024-08-21'),
(31, 'aaa@a.com', '', 0, '2024-08-22'),
(31, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-19'),
(34, 'gsanti.sg17@gmail.com', NULL, 0, '2024-08-21'),
(34, 'gsanti.sg2002@gmail.com', NULL, 0, '0000-00-00'),
(34, 'mariangelesgmnz@gmail.com', NULL, 0, '0000-00-00'),
(34, 'penelope@cruz.com', NULL, 0, '0000-00-00'),
(34, 'sannntis1708@gmail.com', NULL, 0, '0000-00-00'),
(34, 'santigimenez.20020817@gmail.com', NULL, 0, '0000-00-00'),
(34, 'santutu@gmail.com', NULL, 0, '0000-00-00'),
(34, 'usuario10@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario11@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario12@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario13@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario14@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario15@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario1@example.com', NULL, 0, '0000-00-00'),
(34, 'usuario2@example.com', NULL, 0, '0000-00-00'),
(34, 'usuario3@example.com', NULL, 0, '0000-00-00'),
(34, 'usuario4@example.com', NULL, 0, '0000-00-00'),
(34, 'usuario5@example.com', NULL, 0, '0000-00-00'),
(34, 'usuario6@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario7@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario8@example.com', NULL, 0, '2024-08-21'),
(34, 'usuario9@example.com', NULL, 0, '2024-08-21'),
(41, 'gsanti.sg17@gmail.com', 'aaaaaaaaa poteito', 1, '2024-08-20'),
(41, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(47, 'santigimenez.20020817@gmail.com', '', 1, '2024-08-20'),
(48, 'gsanti.sg17@gmail.com', '', 0, '2024-08-20'),
(48, 'santigimenez.20020817@gmail.com', 'a', 0, '2024-08-20'),
(50, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(51, 'santigimenez.20020817@gmail.com', '', 1, '2024-08-20'),
(52, 'aaa@a.com', '', 0, '2024-08-22'),
(52, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(53, 'santigimenez.20020817@gmail.com', '', 1, '2024-08-20'),
(58, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(59, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(61, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(62, 'gsanti.sg17@gmail.com', 'hola soy yo', 0, '2024-08-20'),
(62, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(63, 'gsanti.sg17@gmail.com', '', 0, '2024-08-20'),
(63, 'santigimenez.20020817@gmail.com', '', 0, '2024-08-20'),
(65, 'gsanti.sg17@gmail.com', '', 0, '2024-08-28'),
(65, 'santigimenez.20020817@gmail.com', 'que?&#13;&#10;', 1, '2024-08-20'),
(68, 'santigimenez.20020817@gmail.com', '', 1, '2024-08-29'),
(69, 'caballerolautarodev@gmail.com', '', 0, '2024-08-28'),
(72, 'caballerolautarodev@gmail.com', 'Hola qué tal', 0, '2024-08-28'),
(73, 'caballerolautarodev@gmail.com', '', 0, '2024-08-28'),
(73, 'santigimenez.20020817@gmail.com', 'tiene razon', 1, '2024-08-28'),
(74, 'santigimenez.20020817@gmail.com', 'estoiy de acuerdo', 0, '2024-08-29'),
(76, 'gsanti.sg17@gmail.com', '', 1, '2024-09-03');

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
(76, 1, 'jpg');

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

--
-- Volcado de datos para la tabla `ipdir`
--

INSERT INTO `ipdir` (`ip`) VALUES
('12.54.232.21'),
('192.168.10.162');

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
(2, -2, 100, 'desarrollador loco', 'soy el desarrollador loco, estoy medio loquito y me pican los cocos, esto es un lorem ipsum ultra caserito', '2024-07-15 00:00:00', 'santigimenez.20020817@gmail.com', 'gobierno de san juan', 'argentina', 'san juan', 'caucete', NULL),
(3, 0, 1000, 'desarrollador freelancer', 'asdasdde php::penepe', '2024-07-15 00:00:00', 'santigimenez.20020817@gmail.com', 'javier milei', 'argentina', 'san juan', 'caucete', NULL),
(4, 0, 300, 'Desarrollador 3 peiticionando', 'Esto es una peticion realizada en el dia de la fecha para probar el funcionamiento de la base de datos y el sistema en su etapa temprana', '2024-07-16 00:00:00', 'gsanti.sg17@gmail.com', NULL, NULL, NULL, NULL, NULL),
(5, 0, 500, 'Peticion con 2 imagenes', 'esta es una peticion creada para probar como se ve el post cuando cuenta con dos imagenes, posteriormente se creara uno que contenga tres imagenes', '2024-07-19 00:00:00', 'gsanti.sg2002@gmail.com', NULL, 'argentina', 'san juan', 'caucete', NULL),
(10, 0, 12500, 'penelopecrus soy', 'penelope crus estuvo aqui haciendo esta peticion', '2024-07-25 00:00:00', 'santigimenez.20020817@gmail.com', 'javier milei', 'argentina', 'san juan', 'caucete', NULL),
(27, 0, 150000, 'esta e sla lalalal peticion 1 ajkndlaksnmd', 'jamdsflkadñljnasdlan sdjlansdkjans dlkaj sdlka msldmasl dmasdkam fpwfjawoenf gfqwnsñdlkf d fdqknd odfi sdofn ajdfn ñJNF SADFN MWIFEJ MOAÑNF ', '2024-07-29 00:00:00', 'santigimenez.20020817@gmail.com', 'javier milei', NULL, NULL, NULL, NULL),
(28, -2, 101, 'Soy Juan Horacio Gonzalez', 'Hola! Esta es mi primera petición. Estoy muy contento de estar aquí y poder colaborar con todos ustedes. Espero poder contribuir con toda buena causa y ayudar al mundo a ser un lugar mejor', '2024-07-30 00:00:00', 'penelope@cruz.com', 'gobierno de san juan', NULL, NULL, NULL, NULL),
(29, 0, 5000, 'Mal gasto del dinero publico', 'La semana pasada se dio a conocer que el gobierno provincial brindará dinero publico a los municipios para la pavimentación de las calles, y la intendente del departamento de Caucete, en lugar de arreglar las calles céntricas, donde mas trafico hay, prefiere arreglar las calles de los barrios sin darle ninguna importancia a las calles céntricas, valga la redundancia', '2024-08-05 00:00:00', 'santigimenez.20020817@gmail.com', 'romina rosas', NULL, NULL, NULL, NULL),
(30, 0, 200, 'Calle de Aberastain rotas', 'Jsjsisisjbsbdbsjwjwbdbdjdkdksnsnsn ss nskzkxoslsnwns. Zksns snksosksbw wnskodkdbs qnskoxlwbs. Xkskosknsbbdksklsknbs noxknsb. Akdoplwnbjaiikdn bien fjkxlskksnwndndksisknq sndndkdkkb! Kei; si jejeje! Si jwjxuwbskdke! Sjwnfisyw? Ysbskfyb! Dndkskeknt hols bwisooakrn ffyd? Bnksklskqnenndllslskkkskskskskskskskskskskskdkjddjdjjddjjdjdbebevevevevevvevevevevevevevevvevvevevevvevevevevememememmemeememmememammamamamamamsmmrmrmrmrmrmrmrmrmrmisisiaiaiaiaiisajbwbfndnkfkknsn. Dnkdkfijdbsb f fndmkdksksjwjjd', '2024-08-09 00:00:00', 'mariangelesgmnz@gmail.com', NULL, NULL, NULL, NULL, NULL),
(31, 0, 850, 'estoy loquita sapeeeee', 'esta es una peticion donde declaro estar loquita saaape poruq elas locquitas como yo no pueden ser encerradas sape chupate una japi', '2024-08-19 00:00:00', 'santigimenez.20020817@gmail.com', 'romina rosas', NULL, NULL, NULL, NULL),
(33, -2, 1001, 'asdasdasdasd', 'asdasdasdasd asdasdasdasd asdasdasdasd.l.lll asdasdasdasd asdasdasdasd asdasdasdasdasdasda asdasdasd', '2024-08-19 20:05:04', 'mariangelesgmnz@gmail.com', 'gobierno de san juan', 'argentina', 'san juan', 'caucete', NULL),
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
(66, -1, 1030, 'en guanajuato hay gays', 'todos son gays en guanajuato me tienen cansadp desde juanguato', '2024-08-22 20:30:42', 'gsanti.sg17@gmail.com', NULL, NULL, NULL, NULL, NULL),
(67, -1, 1010, 'peticion para probar vistas', 'esta peticion quiere probar la vista de las peticiones nuevas, no eliminar ni aceptar', '2024-08-22 20:41:21', 'gsanti.sg17@gmail.com', 'gobierno de san juan', NULL, NULL, NULL, NULL),
(68, 0, 350, 'en caucete sib gays', 'todos los cauceteeros son gays y s emueven en cabras porque para el caballo no les alcanza', '2024-08-26 15:39:20', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(69, 0, 102, 'peticion para crear destino', 'esta peticion busca crear un destino a traves de la creacion de la peticion', '2024-08-26 17:45:59', 'santigimenez.20020817@gmail.com', 'si funciono', NULL, NULL, NULL, NULL),
(70, -1, 103, 'esta oeticion es igual que la anterior', 'quiero crear el destino = &#34;si funciono&#34; para combinar el destino de la peticion anterior', '2024-08-26 17:47:05', 'santigimenez.20020817@gmail.com', 'si funciono', NULL, NULL, NULL, NULL),
(71, 0, 104, 'peticion para eliminarle el destino', 'esta peticion crea el destino eliminar para testear la app', '2024-08-26 17:57:30', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(72, 0, 105, 'esta peticion 2 verifica que se pueda eliminar el destino', 'tambien verifica un bug encontrado en tematicas que aparecio con la peticion anterior', '2024-08-26 18:00:09', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(73, 0, 777, 'El ECO está muy caro', 'Las tarifas de ECO son demasiado caras e impagables', '2024-08-28 13:30:55', 'caballerolautarodev@gmail.com', 'Gobierno de San Juan', NULL, NULL, NULL, NULL),
(74, 0, 101, 'aaaaaaa aaaaaaaaaa', 'aaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaa', '2024-08-28 13:40:02', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(75, -1, 101, 'aaaaaaaaaa aaaaaaaaaa', ' aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-08-28 13:54:25', 'santigimenez.20020817@gmail.com', NULL, NULL, NULL, NULL, NULL),
(76, 0, 101, 'aaaaaa aaaaaaaaaaa', 'aaaaaaaaaaa aaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaa', '2024-08-29 16:06:40', 'santigimenez.20020817@gmail.com', 'javier milei', NULL, NULL, NULL, NULL);

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
`nroPet` int(11)
,`titulo` char(100)
,`correo` char(40)
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
(76, 'religion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `correo` char(40) NOT NULL,
  `nombreUsuario` char(25) NOT NULL,
  `contrasena` char(60) NOT NULL,
  `verificado` int(1) NOT NULL DEFAULT 0,
  `sancion` int(3) NOT NULL DEFAULT 0,
  `imagen` char(43) NOT NULL DEFAULT 'default.png',
  `valoracion` int(11) NOT NULL DEFAULT 0,
  `nombreRol` char(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`correo`, `nombreUsuario`, `contrasena`, `verificado`, `sancion`, `imagen`, `valoracion`, `nombreRol`) VALUES
('aaa@a.com', 'si', '$2y$10$pENpaMhH7MwzPKnKtd51c.j9nqRKAPAkoeFiWrqEMCNOwAX37Zd3W', 0, 0, 'default.png', 15, 'user'),
('caballerolautarodev@gmail.com', 'Lauro', '$2y$10$ODq6g4PXA/Yfo32jBsZQWeUn2cqTcSAdqZc6cLVuZYPe1wPrGc3.6', 0, 0, 'default.png', 50, 'user'),
('gsanti.sg17@gmail.com', '', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'gsanti.sg17.gmail.com.jpg', 70, 'moderador'),
('gsanti.sg2002@gmail.com', 'santiago gimenez', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 30, 'gsanti.sg2002.gmail.com.jpeg', 30, 'user'),
('mariangelesgmnz@gmail.com', 'Maribr', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 30, 'default.png', 45, 'user'),
('penelope@cruz.com', 'Juan Horacio', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 60, 'default.png', 15, 'user'),
('sannntis1708@gmail.com', '', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 30, 'user'),
('santigimenez.20020817@gmail.com', 'santiago gimenez', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 90, 'santigimenez.20020817.gmail.com.jpg', 720, 'admin'),
('santutu@gmail.com', 'penelope crus', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 0, 'user'),
('unsj@edu.com.ar', 'aguelito', '$2y$10$fIxmZ7jNIvcfveef6d1FXuh6NoYRB9PTh2QRKxcCQQVggZPrjs1/a', 0, 0, 'default.png', 0, 'user'),
('usuario10@example.com', 'user 10 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 30, 'default.png', 30, 'user'),
('usuario11@example.com', 'user 11 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario12@example.com', 'user 12 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario13@example.com', 'user 13 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario14@example.com', 'user 14 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 30, 'default.png', 30, 'user'),
('usuario15@example.com', 'user 15 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario1@example.com', 'user 1 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario2@example.com', 'user 2 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario3@example.com', 'user 3 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario4@example.com', 'user 4 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario5@example.com', 'user 5 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 30, 'default.png', 30, 'user'),
('usuario6@example.com', 'user 6 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 30, 'default.png', 30, 'user'),
('usuario7@example.com', 'user 7 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario8@example.com', 'user 8 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user'),
('usuario9@example.com', 'user 9 gpt', '$2y$10$2n0LmfRd1fe9B1XAFfLIlukVdQ.wAW0w3.2ZY3JVSE7x6fEIh2.Xi', 0, 0, 'default.png', 60, 'user');

-- --------------------------------------------------------

--
-- Estructura para la vista `peticion_objetivo`
--
DROP TABLE IF EXISTS `peticion_objetivo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `peticion_objetivo`  AS SELECT `peticion`.`nroPet` AS `nroPet`, `peticion`.`titulo` AS `titulo`, `peticion`.`correo` AS `correo`, `peticion`.`objFirmas` AS `objetivo`, `firmas`.`firmas` AS `firmas` FROM (`peticion` join (select `firma`.`nroPet` AS `nroPet`,count(0) AS `firmas` from `firma` group by `firma`.`nroPet`) `firmas` on(`peticion`.`nroPet` = `firmas`.`nroPet`)) ;

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
  ADD PRIMARY KEY (`nroPet`,`correo`),
  ADD KEY `correo` (`correo`);

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
-- AUTO_INCREMENT de la tabla `peticion`
--
ALTER TABLE `peticion`
  MODIFY `nroPet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
-- Filtros para la tabla `firma`
--
ALTER TABLE `firma`
  ADD CONSTRAINT `firma_ibfk_1` FOREIGN KEY (`nroPet`) REFERENCES `peticion` (`nroPet`),
  ADD CONSTRAINT `firma_ibfk_2` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`) ON UPDATE CASCADE;

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
