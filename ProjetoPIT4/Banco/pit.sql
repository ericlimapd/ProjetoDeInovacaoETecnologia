-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 06-Jul-2023 às 23:13
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pit`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `senha` varchar(40) DEFAULT NULL,
  `patente` varchar(40) NOT NULL,
  `elo` varchar(40) NOT NULL,
  `nivel` int DEFAULT NULL,
  `regiao` varchar(40) DEFAULT NULL,
  `foto` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `patente`, `elo`, `nivel`, `regiao`, `foto`) VALUES
(1, 'Leco', 'leozinnn@gmail.com', '123', 'Global Elite', '', 30, 'Brasil', ''),
(2, 'andreluquinhas', 'dede@gmail.com', '123', 'Global Elite', '', 40, 'Brasil', ''),
(4, 'brenda', 'br@gmail.com', '123', 'Distinto Mestre Guardião', '', 34, 'Brasil', ''),
(5, 'dornellis1', 'd***r@neles.com', '123', 'Prata I', '', 1, 'Brasil', ''),
(6, 'dornellis1', 'd***r@neles.com', '123', 'Águia Lendaria II', '', 1, 'Brasil', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_online`
--

DROP TABLE IF EXISTS `usuarios_online`;
CREATE TABLE IF NOT EXISTS `usuarios_online` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tempo` varchar(200) NOT NULL,
  `ip` varchar(200) NOT NULL,
  `sessao` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios_online`
--

INSERT INTO `usuarios_online` (`id`, `tempo`, `ip`, `sessao`) VALUES
(1, '1688434273', '::1', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
