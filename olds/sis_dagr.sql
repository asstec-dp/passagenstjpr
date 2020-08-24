-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Tempo de geração: 29-Jul-2020 às 19:39
-- Versão do servidor: 8.0.18
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sis_dagr`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tipo` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nome` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `senha` varchar(220) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `matricula` (`matricula`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `matricula`, `tipo`, `nome`, `email`, `senha`) VALUES
(27, '111', 'servidor', 'Priscila', 'priscila@priscila', '$2y$10$fykwnfxXfbreT3LYb/32ZOqSjN0l.llJevA0UB6ossDX1r0LJ6AtK'),
(28, '2222', 'servidor', 'Priscila', 'priscila@priscila', '$2y$10$i9Ao46DdD6DZlKd0Y4aTS.BYRMPvJO7vQtfxSfS0JPwtviyMLhpdO'),
(29, '4444', 'servidor', 'Priscila', 'priscila@priscila', '$2y$10$XnAYvmwYqQ.jZXpMTS.7fORKJN0o6aG/0AhX1vDJZka7H/xiIDMd6'),
(30, '333', 'servidor', 'Priscila', 'priscila@priscila', '$2y$10$uuVeU6oLuhcv8aFNXCW6s.xyLeKhREjyA9KGA/qUm.2aQTkE/lYO6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
