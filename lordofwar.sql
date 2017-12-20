-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 20-Dez-2017 às 12:59
-- Versão do servidor: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lordofwar`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `army`
--

DROP TABLE IF EXISTS `army`;
CREATE TABLE IF NOT EXISTS `army` (
  `nome` varchar(30) NOT NULL,
  `vida` int(11) NOT NULL,
  `forca` int(11) NOT NULL,
  `mov` int(11) NOT NULL,
  `preco` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `army`
--

INSERT INTO `army` (`nome`, `vida`, `forca`, `mov`, `preco`, `id`) VALUES
('Guerreiro', 3, 2, 1, 10, 1),
('Archeiro', 2, 2, 2, 15, 2),
('Lanceiro', 3, 3, 1, 15, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensage`
--

DROP TABLE IF EXISTS `mensage`;
CREATE TABLE IF NOT EXISTS `mensage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `creation_time` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `mensage`
--

INSERT INTO `mensage` (`id`, `text`, `creation_time`, `user_id`) VALUES
(35, 'Olá', '2017-11-24 15:28:09', 1),
(34, 'Olá, aqui é o Batata', '2017-11-24 15:13:11', 2),
(36, 'HUehueuheuhuhe', '2017-11-24 15:29:11', 1),
(37, 'Hahahahahaha', '2017-11-24 15:31:27', 2),
(38, 'Teste', '2017-11-24 15:31:47', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala`
--

DROP TABLE IF EXISTS `sala`;
CREATE TABLE IF NOT EXISTS `sala` (
  `jogador_id` int(11) NOT NULL,
  `adversario_id` int(11) DEFAULT NULL,
  `turno` int(11) DEFAULT NULL,
  `dano` int(11) DEFAULT NULL,
  `pers` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `jogador_id` (`jogador_id`),
  KEY `adversario_id` (`adversario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sala`
--

INSERT INTO `sala` (`jogador_id`, `adversario_id`, `turno`, `dano`, `pers`, `id`) VALUES
(1, 5, 1, 4, 2, 54);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_army`
--

DROP TABLE IF EXISTS `user_army`;
CREATE TABLE IF NOT EXISTS `user_army` (
  `usuario_id` int(11) NOT NULL,
  `army_id` int(11) NOT NULL,
  `qnt` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `army_id` (`army_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user_army`
--

INSERT INTO `user_army` (`usuario_id`, `army_id`, `qnt`, `id`) VALUES
(8, 3, 0, 30),
(8, 1, 5, 29),
(8, 2, 3, 28),
(3, 2, 0, 24),
(3, 3, 0, 23),
(3, 1, 2, 22),
(4, 1, 4, 32),
(4, 2, 3, 31),
(4, 3, 0, 33),
(5, 1, 2, 34),
(5, 2, 2, 35),
(5, 3, 2, 36),
(1, 3, 6, 54),
(1, 2, 7, 53),
(1, 1, 4, 52);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conta` varchar(50) NOT NULL,
  `senha` varchar(25) NOT NULL,
  `coin` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `conta`, `senha`, `coin`) VALUES
(1, 'AlanLucasSC', '96654117and', 445),
(2, 'Batata', '123', 50),
(3, 'Teste', '123', 0),
(4, 'Alan', '123', 15),
(5, 'OI', '123', 20),
(6, 'Ba', '123', 100),
(8, 'ola', 'ola', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
