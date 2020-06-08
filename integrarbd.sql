-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-10-2018 a las 09:55:27
-- Versión del servidor: 5.6.39-cll-lve
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `integrarbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '21', 1538743237),
('empresa', '14', 1538743237),
('empresa', '24', 1538751086),
('secretaria', '23', 1538747290),
('secretaria', '25', 1538751142);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1538743063, 1538743063),
('empresa', 1, NULL, NULL, NULL, 1538743063, 1538743063),
('secretaria', 1, NULL, NULL, NULL, 1538743063, 1538743063);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(1, 'Categoría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `cedula` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id`, `fecha`, `empresa_id`, `cedula`, `nombre`, `telefono`, `correo`, `cargo`, `documento`) VALUES
(1, '2018-10-17 00:00:00', 1, 'test', 'test', 'test', 'test@test.com', 'test', 'test'),
(2, '2018-10-11 00:00:00', 1, '', '', '', '', '', ''),
(3, '2018-10-10 16:30:00', 3, '', '', '', '', '', ''),
(4, '2018-10-31 14:25:00', 4, 'CITA', 'CITA', 'CITA', 'CITA@CITA.com', 'CITA', 'CITA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita_has_examen`
--

CREATE TABLE `cita_has_examen` (
  `cita_id` int(11) NOT NULL,
  `examen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `nit` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `nit`, `correo`, `telefono`, `direccion`, `logo`, `user_id`) VALUES
(1, 'test3', 'test3', 'test3@test3.com', 'test3', 'test3', 'test3', 12),
(2, 'test4', 'test4', 'test4@test4.com', 'test4', 'test4', 'test4', 13),
(3, 'testrole', 'testrole', 'testrole@testrole.com', 'testrole', 'testrole', 'testrole', 14),
(4, 'ips', 'ips', 'ips@ips.com', 'ips', 'ips', 'ips', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`id`, `nombre`, `categoria_id`) VALUES
(1, 'Test', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1538713175),
('m140209_132017_init', 1538713177),
('m140403_174025_create_account_table', 1538713177),
('m140504_113157_update_tables', 1538713178),
('m140504_130429_create_token_table', 1538713178),
('m140506_102106_rbac_init', 1538722514),
('m140830_171933_fix_ip_field', 1538713178),
('m140830_172703_change_account_table_name', 1538713178),
('m141222_110026_update_ip_field', 1538713178),
('m141222_135246_alter_username_length', 1538713178),
('m150614_103145_update_social_account_table', 1538713178),
('m150623_212711_fix_username_notnull', 1538713178),
('m151218_234654_add_timezone_to_profile', 1538713178),
('m160929_103127_add_last_login_at_to_user_table', 1538713178),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1538722514);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`, `timezone`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secretaria`
--

CREATE TABLE `secretaria` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `secretaria`
--

INSERT INTO `secretaria` (`id`, `user_id`, `empresa_id`, `nombre`, `telefono`, `correo`) VALUES
(1, 20, 1, 'secretaria2', 'secretaria2', 'secretaria2@secretaria2.com'),
(2, 22, 3, 'secre', 'secre', 'secre@secre.com'),
(3, 23, 3, 'sec', 'sec', 'sec@sec.com'),
(4, 25, 4, 'secretariaips', 'secretariaips', 'secretariaips@secretariaips.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_account`
--

CREATE TABLE `social_account` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token`
--

CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `token`
--

INSERT INTO `token` (`user_id`, `code`, `created_at`, `type`) VALUES
(21, 'CdZwPRwZtQeI6lPtsO4dqn2ohjgyH2K9', 1538745092, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`, `last_login_at`) VALUES
(1, 'asa', '', '$2y$10$flN.tR9BnEjpOvECOAP7uOVCFcsTOalUBHOY85EPVwVxLWsLlpAu.', 'MtJisrEJowQqMoQNAkTqujoVwWgNyblU', NULL, NULL, NULL, '::1', 1538714118, 1538714118, 0, NULL),
(2, 'testaaaa', 'testaaa@test.com', '$2y$10$KQZT9Jmbmck3.1VxKfrdremvg7MNC6fkM1TlF490bmJlY8Y5q4SiK', 'OjMroteKy5yFtO8xVHsccnDfAaUPjef_', NULL, NULL, NULL, '::1', 1538714833, 1538714833, 0, NULL),
(3, 'test2aaa', 'test2aaa@test.com', '$2y$10$oXAPIgwrTvjrIrV6hC9rLef9v7VzXr9jF/hPNEcYl2LUtJw.2BNaG', 'sGeoRHFXFZ6Qa-Eq7d6BJ6-1B4-Dmsyg', NULL, NULL, NULL, '::1', 1538715073, 1538715073, 0, NULL),
(4, 'test2', 'test2@test.com', '$2y$10$6ZXkdzSaWlb7o0vZMSDy5uWD4s3Dj/oWF39bgUxplURNDsIeBS8yG', 'y3oveHxm4I0PICA3MuO5jvJUMCs2_Sx1', NULL, NULL, NULL, '::1', 1538715142, 1538715142, 0, NULL),
(12, 'test3', 'test3@test3.com', '$2y$10$SVGEgpxxWCPPu6MeUHCkOOQ4H5pLszpDmSQ6j6wdy549lN/zYS2bW', '5JBBIiBjfDAnt8oYivk_8RFg4TatRKjw', NULL, NULL, NULL, '::1', 1538715780, 1538715780, 0, NULL),
(13, 'test4', 'test4@test4.com', '$2y$10$3udnwlPn3uWz6EglHXEAHuIdIE1AFP8VZMVFt0vIw2lvY4KSE8v7q', 'NxQVr5yr9P44UEB1i__7nP_GF0i1lFOh', NULL, NULL, NULL, '::1', 1538715810, 1538715810, 0, NULL),
(14, 'testrole', 'testrole@testrole.com', '$2y$10$NaTGV.42yPP/DyXCLkQOUecMNI6dgCKdM.V4SrDWmRvRGYnjdJkkW', 'gD0fwcwdR87gDlnIPyBCvmdzpb_x2fUn', NULL, NULL, NULL, '::1', 1538743237, 1538743237, 0, 1538748535),
(20, 'secretaria2', 'secretaria2@secretaria2.com', '$2y$10$BDjlmVpIn1Tg4G42pVx.8.35dXVlglb6Sv5XXcH4JZGXhRBKBjUSK', '41BXNLMSMWJY4_-Z7I7x0MP8tHJg2wC3', NULL, NULL, NULL, '::1', 1538744591, 1538744591, 0, 1538746991),
(21, 'santiago', 'santiagomenape@gmail.com', '$2y$10$Z6O/SYErPqdM7hcYHPM3KexJzHs6Jb7PnS.U35JZqC3b5axnrO30q', '77gqOYDxjV21Uuot7p3tcJ5W8p1Z8TN2', NULL, NULL, NULL, '::1', 1538745092, 1538745092, 0, 1538751597),
(22, 'secre', 'secre@secre.com', '$2y$10$NuiPSqnGAgslyuzf5gbUAuk3pqGOWYCKaQEWdhyp8n2GKs5eCWN9S', 'KCZWUwhrNPokRHXydD1DZxh3QoDqdHnD', NULL, NULL, NULL, '::1', 1538747110, 1538747110, 0, 1538747118),
(23, 'sec', 'sec@sec.com', '$2y$10$oy4bBtVe4mdGNHgtzdmNI.GVo1s6WEpqHbq0p77LW6YC9qGaSuqbW', 'JkjYym_p9RqW7uy6W9YDlwyiY_sg6hbw', NULL, NULL, NULL, '::1', 1538747290, 1538747290, 0, 1538750787),
(24, 'ips', 'ips@ips.com', '$2y$10$LUgvK6nynV0L49qnXFuJEOaEVrvQxZ8snd3leHKO872/qM0/uHaSS', 'UO8rBwmIHGMhcKv7dP58pw3J1XJlFErJ', NULL, NULL, NULL, '::1', 1538751086, 1538751086, 0, 1538751095),
(25, 'secretariaips', 'secretariaips@secretariaips.com', '$2y$10$1xufQowFgztL5T/NQU6CpOG3HGL5rJjFo0MSVWjvwoyEOul0zLMhu', 'YtiQxKfSpZVWEkDfYK2zSnwEobdLmY6w', NULL, NULL, NULL, '::1', 1538751142, 1538751142, 0, 1538751149);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indices de la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indices de la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indices de la tabla `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cita_empresa1_idx` (`empresa_id`);

--
-- Indices de la tabla `cita_has_examen`
--
ALTER TABLE `cita_has_examen`
  ADD PRIMARY KEY (`cita_id`,`examen_id`),
  ADD KEY `fk_cita_has_examen_examen1_idx` (`examen_id`),
  ADD KEY `fk_cita_has_examen_cita1_idx` (`cita_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empresa_user1_idx` (`user_id`);

--
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_examen_categoria1_idx` (`categoria_id`);

--
-- Indices de la tabla `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `secretaria`
--
ALTER TABLE `secretaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_secretaria_user1_idx` (`user_id`),
  ADD KEY `fk_secretaria_empresa1_idx` (`empresa_id`);

--
-- Indices de la tabla `social_account`
--
ALTER TABLE `social_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_unique` (`provider`,`client_id`),
  ADD UNIQUE KEY `account_unique_code` (`code`),
  ADD KEY `fk_user_account` (`user_id`);

--
-- Indices de la tabla `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `token_unique` (`user_id`,`code`,`type`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_username` (`username`),
  ADD UNIQUE KEY `user_unique_email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `secretaria`
--
ALTER TABLE `secretaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `social_account`
--
ALTER TABLE `social_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cita_has_examen`
--
ALTER TABLE `cita_has_examen`
  ADD CONSTRAINT `fk_cita_has_examen_cita1` FOREIGN KEY (`cita_id`) REFERENCES `cita` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cita_has_examen_examen1` FOREIGN KEY (`examen_id`) REFERENCES `examen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresa_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `examen`
--
ALTER TABLE `examen`
  ADD CONSTRAINT `fk_examen_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `secretaria`
--
ALTER TABLE `secretaria`
  ADD CONSTRAINT `fk_secretaria_empresa1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_secretaria_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `social_account`
--
ALTER TABLE `social_account`
  ADD CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
