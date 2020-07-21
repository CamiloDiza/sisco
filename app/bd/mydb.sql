-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2020 a las 22:05:05
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda_cita`
--

CREATE TABLE `agenda_cita` (
  `id_agenda` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=sin agendar;1=pendiente;2=realizada;3=cancelada;4=incumplida',
  `profesional` int(11) NOT NULL,
  `paciente` int(11) DEFAULT NULL,
  `disp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `agenda_cita`
--

INSERT INTO `agenda_cita` (`id_agenda`, `fecha`, `hora`, `estado`, `profesional`, `paciente`, `disp_id`) VALUES
(73, '2020-02-12', '18:30:00', 1, 1, 1, 24),
(74, '2020-02-12', '19:15:00', 1, 1, 1, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `agenda` int(11) NOT NULL,
  `asistio` tinyint(1) NOT NULL,
  `motivo` varchar(500) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `diagnostico` varchar(500) DEFAULT NULL,
  `tratamiento` varchar(500) DEFAULT NULL,
  `remision` tinyint(1) DEFAULT NULL,
  `proxima_cita` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

CREATE TABLE `evaluacion` (
  `id_evaluacion` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `paciente` int(11) NOT NULL,
  `profesional` int(11) NOT NULL,
  `archivo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_disp`
--

CREATE TABLE `horario_disp` (
  `id_horario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `profesional` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horario_disp`
--

INSERT INTO `horario_disp` (`id_horario`, `fecha`, `hora_inicio`, `hora_fin`, `profesional`) VALUES
(24, '2020-02-12', '18:30:00', '20:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `tipo_paciente` int(11) NOT NULL,
  `edad` int(11) NOT NULL,
  `semestre` int(11) DEFAULT NULL,
  `jornada` varchar(10) DEFAULT NULL,
  `programa` int(11) DEFAULT NULL,
  `año_egreso` year(4) DEFAULT NULL,
  `responsable` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `usuario`, `tipo_paciente`, `edad`, `semestre`, `jornada`, `programa`, `año_egreso`, `responsable`) VALUES
(1, 5, 1, 18, 6, 'nocturna', 3, NULL, NULL),
(2, 6, 2, 33, NULL, NULL, NULL, 2015, NULL),
(3, 7, 3, 24, NULL, NULL, NULL, NULL, NULL),
(4, 8, 4, 48, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesional`
--

CREATE TABLE `profesional` (
  `id_profesional` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `tipo_prof` int(11) NOT NULL,
  `experiencia` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profesional`
--

INSERT INTO `profesional` (`id_profesional`, `usuario`, `tipo_prof`, `experiencia`) VALUES
(1, 2, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
(2, 3, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
(3, 4, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa_academico`
--

CREATE TABLE `programa_academico` (
  `id_programa` int(11) NOT NULL,
  `programa` varchar(45) NOT NULL,
  `snies` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `programa_academico`
--

INSERT INTO `programa_academico` (`id_programa`, `programa`, `snies`) VALUES
(1, 'Administración de empresas', ''),
(2, 'Contaduría publica', ''),
(3, 'Ingeniería de Sistemas', ''),
(4, 'Administración Agroindustrial', ''),
(5, 'Administración de Servicios de Salud', ''),
(6, 'Licenciatura en Pedagogía Infantil', ''),
(7, 'Licenciatura en Inglés', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsable`
--

CREATE TABLE `responsable` (
  `id_responsable` int(11) NOT NULL,
  `nombre_completo` varchar(45) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `responsable`
--

INSERT INTO `responsable` (`id_responsable`, `nombre_completo`, `telefono`, `email`) VALUES
(1, 'Acudiente Egresado', '3158746312', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_paciente`
--

CREATE TABLE `tipo_paciente` (
  `id_tipo_paciente` int(11) NOT NULL,
  `tipo_paciente` varchar(45) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_paciente`
--

INSERT INTO `tipo_paciente` (`id_tipo_paciente`, `tipo_paciente`, `descripcion`) VALUES
(1, 'Estudiante', NULL),
(2, 'Egresado', NULL),
(3, 'Vinculado', NULL),
(4, 'Docente', NULL),
(5, 'Administrativo', NULL),
(6, 'De planta', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_profesional`
--

CREATE TABLE `tipo_profesional` (
  `id_tipo_prof` int(11) NOT NULL,
  `tipo_profesional` varchar(45) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_profesional`
--

INSERT INTO `tipo_profesional` (`id_tipo_prof`, `tipo_profesional`, `descripcion`) VALUES
(1, 'Médico(a) general', NULL),
(2, 'Psicólogo(a)', NULL),
(3, 'Higienista dental', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(45) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `tipo_usuario`, `descripcion`) VALUES
(1, 'Directivo', 'Funciones de administrador'),
(2, 'Profesional', 'Profesional de la salud'),
(3, 'Paciente', 'Miembro de la comunidad institucional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(20) NOT NULL,
  `apellidos` varchar(20) NOT NULL,
  `tipo_documento` varchar(5) NOT NULL,
  `documento` varchar(15) NOT NULL,
  `residencia_dir` varchar(45) DEFAULT NULL,
  `telefono` varchar(15) NOT NULL,
  `mail` varchar(45) NOT NULL,
  `genero` varchar(15) DEFAULT NULL,
  `estado_civil` varchar(15) DEFAULT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `foto_usuario` varchar(200) NOT NULL DEFAULT 'default.png',
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `contraseña` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombres`, `apellidos`, `tipo_documento`, `documento`, `residencia_dir`, `telefono`, `mail`, `genero`, `estado_civil`, `tipo_usuario`, `foto_usuario`, `estado`, `contraseña`) VALUES
(1, 'Usuario', 'Directivo', 'CC', '1', NULL, '0000000000', 'directivo@gmail.com', NULL, NULL, 1, 'admin.jpg', 1, '202cb962ac59075b964b07152d234b70'),
(2, 'Profesional', 'Psicóloga', 'CC', '21', '', '3125396918', 'psicologa@gmail.com', 'Femenino', '', 2, 'psicologa.jpg', 1, '3c59dc048e8850243be8079a5c74d079'),
(3, 'Profesional', 'Médico', 'CC', '22', '', '3189657439', 'medico@gmail.com', 'Masculino', '', 2, 'medico.jpg', 1, 'b6d767d2f8ed5d21a44b0e5886680cb9'),
(4, 'Profesional', 'Higienista', 'CC', '23', '', '3196475213', 'higienista@gmail.com', 'Masculino', '', 2, 'higienista.jpg', 1, '37693cfc748049e45d87b8c7d8b9aacd'),
(5, 'Paciente', 'Estudiante', 'CC', '31', 'Kra 4 # 45 - 12', '3147853612', 'estudiante@gmail.com', 'Masculino', 'Soltero(a)', 3, 'default.png', 1, 'c16a5320fa475530d9583c34fd356ef5'),
(6, 'Paciente', 'Egresado', 'CC', '32', 'Tv 7 # 12 - 50', '3165412974', 'egresado@gmail.com', 'Femenino', 'Casado(a)', 3, 'default.png', 1, '6364d3f0f495b6ab9dcf8d3b5c6e0b01'),
(7, 'Paciente', 'Vinculado', 'CC', '33', 'Cll 4 # 41 - 45', '3174698310', 'vinculado@gmail.com', 'Femenino', 'Unión libre', 3, 'default.png', 1, '182be0c5cdcd5072bb1864cdee4d3d6e'),
(8, 'Paciente', 'Docente', 'CC', '34', 'Kra 6 # 12 - 30', '3102896453', 'docente@gmail.com', 'Masculino', 'Viudo(a)', 3, 'default.png', 1, 'e369853df766fa44e1ed0ff613f563bd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinculacion`
--

CREATE TABLE `vinculacion` (
  `id_vinculacion` int(11) NOT NULL,
  `paciente_vinculante` int(11) NOT NULL,
  `paciente_vinculado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vinculacion`
--

INSERT INTO `vinculacion` (`id_vinculacion`, `paciente_vinculante`, `paciente_vinculado`) VALUES
(1, 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agenda_cita`
--
ALTER TABLE `agenda_cita`
  ADD PRIMARY KEY (`id_agenda`),
  ADD UNIQUE KEY `id_agenda_UNIQUE` (`id_agenda`),
  ADD KEY `fk_agenda_cita_profesional1_idx` (`profesional`),
  ADD KEY `fk_agenda_cita_paciente1_idx` (`paciente`),
  ADD KEY `fk_agenda_cita_horario_disp1_idx` (`disp_id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD UNIQUE KEY `agenda_UNIQUE` (`agenda`),
  ADD UNIQUE KEY `id_cita` (`id_cita`),
  ADD KEY `fk_cita_agenda_cita1_idx` (`agenda`);

--
-- Indices de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD PRIMARY KEY (`id_evaluacion`),
  ADD UNIQUE KEY `id_evaluacion_UNIQUE` (`id_evaluacion`),
  ADD KEY `fk_evaluacion_paciente1_idx` (`paciente`),
  ADD KEY `fk_evaluacion_profesional1_idx` (`profesional`);

--
-- Indices de la tabla `horario_disp`
--
ALTER TABLE `horario_disp`
  ADD PRIMARY KEY (`id_horario`),
  ADD UNIQUE KEY `id_horario_UNIQUE` (`id_horario`),
  ADD KEY `fk_horario_disp_profesional1_idx` (`profesional`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`),
  ADD UNIQUE KEY `id_paciente_UNIQUE` (`id_paciente`),
  ADD KEY `fk_paciente_tipo_paciente1_idx` (`tipo_paciente`),
  ADD KEY `fk_paciente_usuario1_idx` (`usuario`),
  ADD KEY `fk_paciente_programa_academico1_idx` (`programa`),
  ADD KEY `fk_paciente_responsable1_idx` (`responsable`);

--
-- Indices de la tabla `profesional`
--
ALTER TABLE `profesional`
  ADD PRIMARY KEY (`id_profesional`),
  ADD UNIQUE KEY `id_profesional_UNIQUE` (`id_profesional`),
  ADD KEY `fk_profesional_tipo_profesional1_idx` (`tipo_prof`),
  ADD KEY `fk_profesional_usuario1_idx` (`usuario`);

--
-- Indices de la tabla `programa_academico`
--
ALTER TABLE `programa_academico`
  ADD PRIMARY KEY (`id_programa`),
  ADD UNIQUE KEY `id_programa_UNIQUE` (`id_programa`);

--
-- Indices de la tabla `responsable`
--
ALTER TABLE `responsable`
  ADD PRIMARY KEY (`id_responsable`),
  ADD UNIQUE KEY `id_responsable_UNIQUE` (`id_responsable`);

--
-- Indices de la tabla `tipo_paciente`
--
ALTER TABLE `tipo_paciente`
  ADD PRIMARY KEY (`id_tipo_paciente`),
  ADD UNIQUE KEY `id_tipo_paciente_UNIQUE` (`id_tipo_paciente`);

--
-- Indices de la tabla `tipo_profesional`
--
ALTER TABLE `tipo_profesional`
  ADD PRIMARY KEY (`id_tipo_prof`),
  ADD UNIQUE KEY `id_tipo_prof_UNIQUE` (`id_tipo_prof`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`),
  ADD UNIQUE KEY `id_tipo_usuario_UNIQUE` (`id_tipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `id_usuario_UNIQUE` (`id_usuario`),
  ADD UNIQUE KEY `documento_UNIQUE` (`documento`),
  ADD KEY `fk_usuario_tipo_usuario1_idx` (`tipo_usuario`);

--
-- Indices de la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  ADD PRIMARY KEY (`id_vinculacion`),
  ADD UNIQUE KEY `id_vinculacion_UNIQUE` (`id_vinculacion`),
  ADD KEY `fk_vinculacion_paciente1_idx` (`paciente_vinculante`),
  ADD KEY `fk_vinculacion_paciente2_idx` (`paciente_vinculado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agenda_cita`
--
ALTER TABLE `agenda_cita`
  MODIFY `id_agenda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  MODIFY `id_evaluacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horario_disp`
--
ALTER TABLE `horario_disp`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `profesional`
--
ALTER TABLE `profesional`
  MODIFY `id_profesional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `programa_academico`
--
ALTER TABLE `programa_academico`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `responsable`
--
ALTER TABLE `responsable`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_paciente`
--
ALTER TABLE `tipo_paciente`
  MODIFY `id_tipo_paciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_profesional`
--
ALTER TABLE `tipo_profesional`
  MODIFY `id_tipo_prof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  MODIFY `id_vinculacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agenda_cita`
--
ALTER TABLE `agenda_cita`
  ADD CONSTRAINT `fk_agenda_cita_horario_disp1` FOREIGN KEY (`disp_id`) REFERENCES `horario_disp` (`id_horario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_agenda_cita_paciente1` FOREIGN KEY (`paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_agenda_cita_profesional1` FOREIGN KEY (`profesional`) REFERENCES `profesional` (`id_profesional`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_agenda_cita1` FOREIGN KEY (`agenda`) REFERENCES `agenda_cita` (`id_agenda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD CONSTRAINT `fk_evaluacion_paciente1` FOREIGN KEY (`paciente`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_evaluacion_profesional1` FOREIGN KEY (`profesional`) REFERENCES `profesional` (`id_profesional`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horario_disp`
--
ALTER TABLE `horario_disp`
  ADD CONSTRAINT `fk_horario_disp_profesional1` FOREIGN KEY (`profesional`) REFERENCES `profesional` (`id_profesional`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_paciente_programa_academico1` FOREIGN KEY (`programa`) REFERENCES `programa_academico` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paciente_responsable1` FOREIGN KEY (`responsable`) REFERENCES `responsable` (`id_responsable`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paciente_tipo_paciente1` FOREIGN KEY (`tipo_paciente`) REFERENCES `tipo_paciente` (`id_tipo_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_paciente_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profesional`
--
ALTER TABLE `profesional`
  ADD CONSTRAINT `fk_profesional_tipo_profesional1` FOREIGN KEY (`tipo_prof`) REFERENCES `tipo_profesional` (`id_tipo_prof`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_profesional_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_tipo_usuario1` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  ADD CONSTRAINT `fk_vinculacion_paciente1` FOREIGN KEY (`paciente_vinculante`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vinculacion_paciente2` FOREIGN KEY (`paciente_vinculado`) REFERENCES `paciente` (`id_paciente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
