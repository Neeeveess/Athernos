-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2023 at 09:15 AM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `athernos`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`athernos`@`localhost` PROCEDURE `registrar_saida` (IN `codigo_id` INT, IN `quantidade_saida` INT)   BEGIN
    DECLARE quantidade_atual INT;
    DECLARE id_prod int;
    DECLARE nome_prod varchar(45);


    -- Obtém a quantidade atual do produto
    SELECT quantidade,id_produto INTO quantidade_atual,id_prod FROM lotes WHERE codigo = codigo_id;
    SELECT nome INTO nome_prod FROM produtos WHERE id = id_prod;    

    -- Verifica se a quantidade de saída é menor ou igual à quantidade atual
    IF quantidade_saida <= quantidade_atual THEN
        -- Atualiza a quantidade na tabela produtos
        UPDATE lotes SET quantidade = quantidade_atual - quantidade_saida WHERE codigo = codigo_id;

        -- Insere o registro de saída no histórico
        INSERT INTO log_lotes (id_produto,nome_produto,id_lotes,tipo,quantidade,data_manipulacao)
        VALUES (id_prod,nome_prod,codigo_id,"Saida", quantidade_saida,now());
    ELSE
        -- Caso a quantidade de saída seja maior que a quantidade atual, emite uma mensagem de erro
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Quantidade de saída superior à quantidade disponível.';
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nome`) VALUES
(1, 'ALIMENTO'),
(2, 'HIGIENE'),
(4, 'LIMPEZA'),
(5, 'BEBIDAS');

-- --------------------------------------------------------

--
-- Stand-in structure for view `listProd`
-- (See below for the actual view)
--
CREATE TABLE `listProd` (
`id` int(11)
,`codigo` varchar(20)
,`nome` varchar(45)
,`categoria` varchar(45)
,`total` decimal(32,0)
,`menor_validade` date
,`maior_validade` date
,`custo` double
);

-- --------------------------------------------------------

--
-- Table structure for table `log_lotes`
--

CREATE TABLE `log_lotes` (
  `id` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `nome_produto` varchar(45) DEFAULT NULL,
  `id_lotes` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `data_manipulacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log_lotes`
--

INSERT INTO `log_lotes` (`id`, `tipo`, `id_produto`, `nome_produto`, `id_lotes`, `quantidade`, `data_manipulacao`) VALUES
(1, 'Entrada', 1, 'LEITE', 1, 30, '2023-06-06 19:58:18'),
(2, 'Entrada', 2, 'ARROZ', 2, 20, '2023-06-06 19:58:18'),
(3, 'Entrada', 2, 'ARROZ', 3, 77, '2023-06-06 19:58:18'),
(4, 'Entrada', 3, 'FEIJAO', 4, 10, '2023-06-06 19:58:18'),
(5, 'Entrada', 3, 'FEIJAO', 5, 15, '2023-06-06 19:58:18'),
(6, 'Entrada', 3, 'FEIJAO', 6, 57, '2023-06-06 19:58:18'),
(7, 'Entrada', 4, 'SABONETE', 7, 30, '2023-06-06 19:58:18'),
(8, 'Entrada', 7, 'MACARRAO', 8, 102, '2023-06-06 20:25:28'),
(9, 'Saida', 3, 'FEIJAO', 6, 50, '2023-06-06 20:26:30'),
(10, 'Entrada', 8, 'FARINHA DE MILHO', 9, 43, '2023-06-06 20:27:41'),
(11, 'Entrada', 8, 'FARINHA DE MILHO', 10, 2, '2023-06-06 20:27:41'),
(12, 'Entrada', 8, 'FARINHA DE MILHO', 11, 133, '2023-06-06 20:27:41'),
(13, 'Entrada', 9, 'MILHO VERDE', 12, 11, '2023-06-06 20:27:41'),
(14, 'Entrada', 9, 'MILHO VERDE', 13, 7, '2023-06-06 20:27:41'),
(15, 'Entrada', 9, 'MILHO VERDE', 14, 15, '2023-06-06 20:27:41'),
(16, 'Entrada', 10, 'SACO DE LIXO 50L', 15, 60, '2023-06-06 20:27:41'),
(17, 'Entrada', 10, 'SACO DE LIXO 50L', 16, 17, '2023-06-06 20:27:41'),
(18, 'Entrada', 10, 'SACO DE LIXO 50L', 17, 22, '2023-06-06 20:27:41'),
(19, 'Entrada', 11, 'ATUM', 18, 3, '2023-06-06 20:27:41'),
(20, 'Entrada', 11, 'ATUM', 19, 12, '2023-06-06 20:27:41'),
(21, 'Entrada', 11, 'ATUM', 20, 33, '2023-06-06 20:27:41'),
(22, 'Entrada', 12, 'SUCO GARRAFA 1L', 21, 65, '2023-06-06 20:27:41'),
(23, 'Entrada', 12, 'SUCO GARRAFA 1L', 22, 22, '2023-06-06 20:27:41'),
(24, 'Entrada', 12, 'SUCO GARRAFA 1L', 23, 32, '2023-06-06 20:27:41'),
(25, 'Entrada', 13, 'FARINHA DE MANDIOCA', 24, 100, '2023-06-06 20:27:41'),
(26, 'Entrada', 13, 'FARINHA DE MANDIOCA', 25, 10, '2023-06-06 20:27:41'),
(27, 'Entrada', 13, 'FARINHA DE MANDIOCA', 26, 171, '2023-06-06 20:27:41'),
(28, 'Entrada', 4, 'SABONETE', 27, 98, '2023-06-06 20:27:41'),
(29, 'Entrada', 14, 'BOLACHA', 28, 53, '2023-06-06 20:27:41'),
(30, 'Entrada', 14, 'BOLACHA', 29, 8, '2023-06-06 20:27:41'),
(31, 'Entrada', 14, 'BOLACHA', 30, 1, '2023-06-06 20:27:41'),
(32, 'Entrada', 15, 'ÃGUA SANITÃRIA', 31, 12, '2023-06-06 20:27:41'),
(33, 'Entrada', 15, 'ÃGUA SANITÃRIA', 32, 28, '2023-06-06 20:27:41'),
(34, 'Entrada', 15, 'ÃGUA SANITÃRIA', 33, 194, '2023-06-06 20:27:41'),
(35, 'Entrada', 16, 'LUSTRA MÃ“VEIS', 34, 96, '2023-06-06 20:27:41'),
(36, 'Entrada', 16, 'LUSTRA MÃ“VEIS', 35, 8, '2023-06-06 20:27:41'),
(37, 'Entrada', 16, 'LUSTRA MÃ“VEIS', 36, 141, '2023-06-06 20:27:41'),
(38, 'Entrada', 17, 'CONDICIONADOR', 37, 94, '2023-06-06 20:27:41'),
(39, 'Entrada', 17, 'CONDICIONADOR', 38, 22, '2023-06-06 20:27:41'),
(40, 'Entrada', 17, 'CONDICIONADOR', 39, 73, '2023-06-06 20:27:41'),
(41, 'Entrada', 18, 'FARINHA DE TRIGO', 40, 94, '2023-06-06 20:27:41'),
(42, 'Entrada', 18, 'FARINHA DE TRIGO', 41, 21, '2023-06-06 20:27:41'),
(43, 'Entrada', 18, 'FARINHA DE TRIGO', 42, 116, '2023-06-06 20:27:41'),
(44, 'Entrada', 19, 'SARDINHA', 43, 55, '2023-06-06 20:27:41'),
(45, 'Entrada', 19, 'SARDINHA', 44, 28, '2023-06-06 20:27:41'),
(46, 'Entrada', 20, 'BUCHINHA DE PIA', 45, 60, '2023-06-06 20:27:41'),
(47, 'Entrada', 20, 'BUCHINHA DE PIA', 46, 19, '2023-06-06 20:27:41'),
(48, 'Entrada', 20, 'BUCHINHA DE PIA', 47, 112, '2023-06-06 20:27:41'),
(49, 'Entrada', 21, 'LEITE DESNATADO LITRO', 48, 24, '2023-06-06 20:27:41'),
(50, 'Entrada', 21, 'LEITE DESNATADO LITRO', 49, 30, '2023-06-06 20:27:41'),
(51, 'Entrada', 21, 'LEITE DESNATADO LITRO', 50, 99, '2023-06-06 20:27:41'),
(52, 'Entrada', 22, 'SABÃƒO EM PÃ“', 51, 41, '2023-06-06 20:27:41'),
(53, 'Entrada', 22, 'SABÃƒO EM PÃ“', 52, 24, '2023-06-06 20:27:41'),
(54, 'Entrada', 22, 'SABÃƒO EM PÃ“', 53, 191, '2023-06-06 20:27:41'),
(55, 'Entrada', 23, 'TIRA MANCHAS', 54, 70, '2023-06-06 20:27:41'),
(56, 'Entrada', 23, 'TIRA MANCHAS', 55, 5, '2023-06-06 20:27:41'),
(57, 'Entrada', 23, 'TIRA MANCHAS', 56, 15, '2023-06-06 20:27:41'),
(58, 'Entrada', 24, 'SAL', 57, 68, '2023-06-06 20:27:41'),
(59, 'Entrada', 24, 'SAL', 58, 16, '2023-06-06 20:27:41'),
(60, 'Entrada', 24, 'SAL', 59, 87, '2023-06-06 20:27:41'),
(61, 'Entrada', 25, 'FAROFA PRONTA', 60, 5, '2023-06-06 20:27:41'),
(62, 'Entrada', 25, 'FAROFA PRONTA', 61, 6, '2023-06-06 20:27:41'),
(63, 'Entrada', 25, 'FAROFA PRONTA', 62, 68, '2023-06-06 20:27:41'),
(64, 'Entrada', 26, 'ACHOCOLATADO', 63, 71, '2023-06-06 20:27:41'),
(65, 'Entrada', 26, 'ACHOCOLATADO', 64, 10, '2023-06-06 20:27:41'),
(66, 'Entrada', 26, 'ACHOCOLATADO', 65, 141, '2023-06-06 20:27:41'),
(67, 'Entrada', 27, 'MOLHO DE PIMENTA', 66, 48, '2023-06-06 20:27:41'),
(68, 'Entrada', 27, 'MOLHO DE PIMENTA', 67, 15, '2023-06-06 20:27:41'),
(69, 'Entrada', 27, 'MOLHO DE PIMENTA', 68, 66, '2023-06-06 20:27:41'),
(70, 'Entrada', 28, 'LEITE INTEGRAL LITRO', 69, 56, '2023-06-06 20:27:41'),
(71, 'Entrada', 28, 'LEITE INTEGRAL LITRO', 70, 5, '2023-06-06 20:27:41'),
(72, 'Entrada', 28, 'LEITE INTEGRAL LITRO', 71, 173, '2023-06-06 20:27:41'),
(73, 'Entrada', 29, 'LIMPA VIDROS', 72, 89, '2023-06-06 20:27:41'),
(74, 'Entrada', 29, 'LIMPA VIDROS', 73, 2, '2023-06-06 20:27:41'),
(75, 'Entrada', 29, 'LIMPA VIDROS', 74, 155, '2023-06-06 20:27:41'),
(76, 'Entrada', 30, 'ERVILHA', 75, 63, '2023-06-06 20:27:41'),
(77, 'Entrada', 30, 'ERVILHA', 76, 17, '2023-06-06 20:27:41'),
(78, 'Entrada', 30, 'ERVILHA', 77, 138, '2023-06-06 20:27:41'),
(79, 'Entrada', 31, 'AMACIANTE', 78, 48, '2023-06-06 20:27:41'),
(80, 'Entrada', 31, 'AMACIANTE', 79, 1, '2023-06-06 20:27:41'),
(81, 'Entrada', 31, 'AMACIANTE', 80, 111, '2023-06-06 20:27:41'),
(82, 'Entrada', 33, 'CAFÃ‰', 81, 95, '2023-06-06 20:27:42'),
(83, 'Entrada', 33, 'CAFÃ‰', 82, 26, '2023-06-06 20:27:42'),
(84, 'Entrada', 33, 'CAFÃ‰', 83, 180, '2023-06-06 20:27:42'),
(85, 'Entrada', 34, 'ESPONJA DE AÃ‡O', 84, 5, '2023-06-06 20:27:42'),
(86, 'Entrada', 34, 'ESPONJA DE AÃ‡O', 85, 20, '2023-06-06 20:27:42'),
(87, 'Entrada', 34, 'ESPONJA DE AÃ‡O', 86, 73, '2023-06-06 20:27:42'),
(88, 'Entrada', 35, 'SHAMPO', 87, 51, '2023-06-06 20:27:42'),
(89, 'Entrada', 35, 'SHAMPO', 88, 11, '2023-06-06 20:27:42'),
(90, 'Entrada', 35, 'SHAMPO', 89, 123, '2023-06-06 20:27:42'),
(91, 'Entrada', 37, 'REFRIGERANTE 2L', 90, 89, '2023-06-06 20:27:42'),
(92, 'Entrada', 37, 'REFRIGERANTE 2L', 91, 4, '2023-06-06 20:27:42'),
(93, 'Entrada', 37, 'REFRIGERANTE 2L', 92, 94, '2023-06-06 20:27:42'),
(94, 'Entrada', 38, 'SABÃƒO EM PEDRA', 93, 37, '2023-06-06 20:27:42'),
(95, 'Entrada', 38, 'SABÃƒO EM PEDRA', 94, 19, '2023-06-06 20:27:42'),
(96, 'Entrada', 38, 'SABÃƒO EM PEDRA', 95, 68, '2023-06-06 20:27:42'),
(97, 'Entrada', 39, 'SACO DE LIXO 30L', 96, 53, '2023-06-06 20:27:42'),
(98, 'Entrada', 39, 'SACO DE LIXO 30L', 97, 11, '2023-06-06 20:27:42'),
(99, 'Entrada', 39, 'SACO DE LIXO 30L', 98, 192, '2023-06-06 20:27:42'),
(100, 'Entrada', 40, 'AÃ‡UCAR', 99, 41, '2023-06-06 20:27:42'),
(101, 'Entrada', 40, 'AÃ‡UCAR', 100, 22, '2023-06-06 20:27:42'),
(102, 'Entrada', 40, 'AÃ‡UCAR', 101, 134, '2023-06-06 20:27:42'),
(103, 'Entrada', 41, 'DESINFETANTE', 102, 34, '2023-06-06 20:27:42'),
(104, 'Entrada', 41, 'DESINFETANTE', 103, 25, '2023-06-06 20:27:42'),
(105, 'Entrada', 41, 'DESINFETANTE', 104, 127, '2023-06-06 20:27:42'),
(106, 'Entrada', 42, 'SUCO SACHÃŠ', 105, 64, '2023-06-06 20:27:42'),
(107, 'Entrada', 42, 'SUCO SACHÃŠ', 106, 6, '2023-06-06 20:27:42'),
(108, 'Entrada', 42, 'SUCO SACHÃŠ', 107, 134, '2023-06-06 20:27:42'),
(109, 'Entrada', 43, 'MAIONESE', 108, 23, '2023-06-06 20:27:42'),
(110, 'Entrada', 43, 'MAIONESE', 109, 30, '2023-06-06 20:27:42'),
(111, 'Entrada', 43, 'MAIONESE', 110, 152, '2023-06-06 20:27:42'),
(112, 'Entrada', 44, 'ALCOOL', 111, 41, '2023-06-06 20:27:42'),
(113, 'Entrada', 44, 'ALCOOL', 112, 24, '2023-06-06 20:27:42'),
(114, 'Entrada', 44, 'ALCOOL', 113, 46, '2023-06-06 20:27:42'),
(115, 'Entrada', 45, 'FUBÃ', 114, 74, '2023-06-06 20:27:42'),
(116, 'Entrada', 46, 'MOLHO DE TOMATE', 115, 23, '2023-06-06 20:27:42'),
(117, 'Entrada', 46, 'MOLHO DE TOMATE', 116, 27, '2023-06-06 20:27:42'),
(118, 'Entrada', 46, 'MOLHO DE TOMATE', 117, 61, '2023-06-06 20:27:42'),
(119, 'Entrada', 3, 'FEIJAO', 118, 45, '2023-06-23 16:18:54'),
(120, 'Entrada', 47, 'ALHO', 119, 68, '2023-07-30 13:48:35');

-- --------------------------------------------------------

--
-- Table structure for table `lotes`
--

CREATE TABLE `lotes` (
  `codigo` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `custo_unit` float NOT NULL,
  `quantidade` int(11) NOT NULL,
  `validade` date DEFAULT NULL,
  `data_entrada` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lotes`
--

INSERT INTO `lotes` (`codigo`, `id_produto`, `custo_unit`, `quantidade`, `validade`, `data_entrada`) VALUES
(1, 1, 10, 30, '2023-01-15', '2023-06-06 19:58:18'),
(2, 2, 10, 20, '2023-04-30', '2023-06-06 19:58:18'),
(3, 2, 68, 77, '2023-01-31', '2023-06-06 19:58:18'),
(4, 3, 10, 10, '2023-03-30', '2023-06-06 19:58:18'),
(5, 3, 35, 15, '2023-01-25', '2023-06-06 19:58:18'),
(6, 3, 89, 7, '2023-04-01', '2023-06-06 19:58:18'),
(7, 4, 10, 30, '2024-01-31', '2023-06-06 19:58:18'),
(8, 7, 36, 102, '2023-07-22', '2023-06-06 20:25:28'),
(9, 8, 9, 43, '2023-11-13', '2023-06-06 20:27:41'),
(10, 8, 133, 2, '2024-11-27', '2023-06-06 20:27:41'),
(11, 8, 29, 133, '2023-06-13', '2023-06-06 20:27:41'),
(12, 9, 10, 11, '2023-11-20', '2023-06-06 20:27:41'),
(13, 9, 15, 7, '2024-12-04', '2023-06-06 20:27:41'),
(14, 9, 17, 15, '2023-06-20', '2023-06-06 20:27:41'),
(15, 10, 28, 60, '2023-10-28', '2023-06-06 20:27:41'),
(16, 10, 22, 17, '2024-11-11', '2023-06-06 20:27:41'),
(17, 10, 8, 22, '2023-05-28', '2023-06-06 20:27:41'),
(18, 11, 16, 3, '2023-11-16', '2023-06-06 20:27:41'),
(19, 11, 33, 12, '2024-11-30', '2023-06-06 20:27:41'),
(20, 11, 18, 33, '2023-06-16', '2023-06-06 20:27:41'),
(21, 12, 28, 65, '2023-10-30', '2023-06-06 20:27:41'),
(22, 12, 32, 22, '2024-11-13', '2023-06-06 20:27:41'),
(23, 12, 11, 32, '2023-05-30', '2023-06-06 20:27:41'),
(24, 13, 5, 100, '2023-11-14', '2023-06-06 20:27:41'),
(25, 13, 171, 10, '2024-11-28', '2023-06-06 20:27:41'),
(26, 13, 7, 171, '2023-06-14', '2023-06-06 20:27:41'),
(27, 4, 21, 98, '2023-10-19', '2023-06-06 20:27:41'),
(28, 14, 19, 53, '2023-11-08', '2023-06-06 20:27:41'),
(29, 14, 1, 8, '2024-11-22', '2023-06-06 20:27:41'),
(30, 14, 12, 1, '2023-06-08', '2023-06-06 20:27:41'),
(31, 15, 20, 12, '2023-10-15', '2023-06-06 20:27:41'),
(32, 15, 194, 28, '2024-10-29', '2023-06-06 20:27:41'),
(33, 15, 6, 194, '2023-05-15', '2023-06-06 20:27:41'),
(34, 16, 7, 96, '2023-10-23', '2023-06-06 20:27:41'),
(35, 16, 141, 8, '2024-11-06', '2023-06-06 20:27:41'),
(36, 16, 23, 141, '2023-05-23', '2023-06-06 20:27:41'),
(37, 17, 30, 94, '2023-10-21', '2023-06-06 20:27:41'),
(38, 17, 73, 22, '2024-11-04', '2023-06-06 20:27:41'),
(39, 17, 23, 73, '2023-05-21', '2023-06-06 20:27:41'),
(40, 18, 20, 94, '2023-11-12', '2023-06-06 20:27:41'),
(41, 18, 116, 21, '2024-11-26', '2023-06-06 20:27:41'),
(42, 18, 8, 116, '2023-06-12', '2023-06-06 20:27:41'),
(43, 19, 8, 55, '2023-11-15', '2023-06-06 20:27:41'),
(44, 19, 146, 28, '2024-11-29', '2023-06-06 20:27:41'),
(45, 20, 25, 60, '2023-10-17', '2023-06-06 20:27:41'),
(46, 20, 112, 19, '2024-10-31', '2023-06-06 20:27:41'),
(47, 20, 13, 112, '2023-05-17', '2023-06-06 20:27:41'),
(48, 21, 20, 24, '2023-11-03', '2023-06-06 20:27:41'),
(49, 21, 99, 30, '2024-11-17', '2023-06-06 20:27:41'),
(50, 21, 4, 99, '2023-06-03', '2023-06-06 20:27:41'),
(51, 22, 25, 41, '2023-10-12', '2023-06-06 20:27:41'),
(52, 22, 191, 24, '2024-10-26', '2023-06-06 20:27:41'),
(53, 22, 26, 191, '2023-05-12', '2023-06-06 20:27:41'),
(54, 23, 11, 70, '2023-10-24', '2023-06-06 20:27:41'),
(55, 23, 15, 5, '2024-11-07', '2023-06-06 20:27:41'),
(56, 23, 27, 15, '2023-05-24', '2023-06-06 20:27:41'),
(57, 24, 12, 68, '2023-11-05', '2023-06-06 20:27:41'),
(58, 24, 87, 16, '2024-11-19', '2023-06-06 20:27:41'),
(59, 24, 30, 87, '2023-06-05', '2023-06-06 20:27:41'),
(60, 25, 25, 5, '2023-11-10', '2023-06-06 20:27:41'),
(61, 25, 68, 6, '2024-11-24', '2023-06-06 20:27:41'),
(62, 25, 19, 68, '2023-06-10', '2023-06-06 20:27:41'),
(63, 26, 12, 71, '2023-11-07', '2023-06-06 20:27:41'),
(64, 26, 141, 10, '2024-11-21', '2023-06-06 20:27:41'),
(65, 26, 29, 141, '2023-06-07', '2023-06-06 20:27:41'),
(66, 27, 1, 48, '2023-11-18', '2023-06-06 20:27:41'),
(67, 27, 66, 15, '2024-12-02', '2023-06-06 20:27:41'),
(68, 27, 23, 66, '2023-06-18', '2023-06-06 20:27:41'),
(69, 28, 6, 56, '2023-11-02', '2023-06-06 20:27:41'),
(70, 28, 173, 5, '2024-11-16', '2023-06-06 20:27:41'),
(71, 28, 14, 173, '2023-06-02', '2023-06-06 20:27:41'),
(72, 29, 4, 89, '2023-10-25', '2023-06-06 20:27:41'),
(73, 29, 155, 2, '2024-11-08', '2023-06-06 20:27:41'),
(74, 29, 5, 155, '2023-05-25', '2023-06-06 20:27:41'),
(75, 30, 6, 63, '2023-11-19', '2023-06-06 20:27:41'),
(76, 30, 138, 17, '2024-12-03', '2023-06-06 20:27:41'),
(77, 30, 19, 138, '2023-06-19', '2023-06-06 20:27:41'),
(78, 31, 12, 48, '2023-10-13', '2023-06-06 20:27:41'),
(79, 31, 111, 1, '2024-10-27', '2023-06-06 20:27:41'),
(80, 31, 3, 111, '2023-05-13', '2023-06-06 20:27:41'),
(81, 33, 2, 95, '2023-11-09', '2023-06-06 20:27:42'),
(82, 33, 180, 26, '2024-11-23', '2023-06-06 20:27:42'),
(83, 33, 8, 180, '2023-06-09', '2023-06-06 20:27:42'),
(84, 34, 12, 5, '2023-10-16', '2023-06-06 20:27:42'),
(85, 34, 73, 20, '2024-10-30', '2023-06-06 20:27:42'),
(86, 34, 28, 73, '2023-05-16', '2023-06-06 20:27:42'),
(87, 35, 4, 51, '2023-10-20', '2023-06-06 20:27:42'),
(88, 35, 123, 11, '2024-11-03', '2023-06-06 20:27:42'),
(89, 35, 16, 123, '2023-05-20', '2023-06-06 20:27:42'),
(90, 37, 16, 89, '2023-10-29', '2023-06-06 20:27:42'),
(91, 37, 94, 4, '2024-11-12', '2023-06-06 20:27:42'),
(92, 37, 11, 94, '2023-05-29', '2023-06-06 20:27:42'),
(93, 38, 25, 37, '2023-10-18', '2023-06-06 20:27:42'),
(94, 38, 68, 19, '2024-11-01', '2023-06-06 20:27:42'),
(95, 38, 1, 68, '2023-05-18', '2023-06-06 20:27:42'),
(96, 39, 3, 53, '2023-10-27', '2023-06-06 20:27:42'),
(97, 39, 192, 11, '2024-11-10', '2023-06-06 20:27:42'),
(98, 39, 18, 192, '2023-05-27', '2023-06-06 20:27:42'),
(99, 40, 8, 41, '2023-11-06', '2023-06-06 20:27:42'),
(100, 40, 134, 22, '2024-11-20', '2023-06-06 20:27:42'),
(101, 40, 15, 134, '2023-06-06', '2023-06-06 20:27:42'),
(102, 41, 19, 34, '2023-10-22', '2023-06-06 20:27:42'),
(103, 41, 127, 25, '2024-11-05', '2023-06-06 20:27:42'),
(104, 41, 7, 127, '2023-05-22', '2023-06-06 20:27:42'),
(105, 42, 7, 64, '2023-11-01', '2023-06-06 20:27:42'),
(106, 42, 134, 6, '2024-11-15', '2023-06-06 20:27:42'),
(107, 42, 20, 134, '2023-06-01', '2023-06-06 20:27:42'),
(108, 43, 12, 23, '2023-11-17', '2023-06-06 20:27:42'),
(109, 43, 152, 30, '2024-12-01', '2023-06-06 20:27:42'),
(110, 43, 5, 152, '2023-06-17', '2023-06-06 20:27:42'),
(111, 44, 17, 41, '2023-10-26', '2023-06-06 20:27:42'),
(112, 44, 46, 24, '2024-11-09', '2023-06-06 20:27:42'),
(113, 44, 15, 46, '2023-05-26', '2023-06-06 20:27:42'),
(114, 45, 17, 74, '2023-11-11', '2023-06-06 20:27:42'),
(115, 46, 15, 23, '2023-11-04', '2023-06-06 20:27:42'),
(116, 46, 61, 27, '2024-11-18', '2023-06-06 20:27:42'),
(117, 46, 1, 61, '2023-06-04', '2023-06-06 20:27:42'),
(118, 3, 5.1, 45, '2023-09-28', '2023-06-23 16:18:54'),
(119, 47, 35, 68, '2025-02-26', '2023-07-30 13:48:35');

--
-- Triggers `lotes`
--
DELIMITER $$
CREATE TRIGGER `entrada_lotes` AFTER INSERT ON `lotes` FOR EACH ROW begin 
    declare nome_prod varchar(45);
        select nome into nome_prod from produtos where id = new.id_produto;

        insert into log_lotes(id_produto,nome_produto,id_lotes,tipo,quantidade,data_manipulacao) 
        values(new.id_produto,nome_prod,new.codigo,"Entrada",new.quantidade,now());
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) DEFAULT NULL,
  `nome` varchar(45) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `codigo`, `nome`, `id_categoria`, `data_cadastro`) VALUES
(1, 'SFE84FR', 'LEITE', 1, '2023-06-06 19:58:18'),
(2, 'HSE84FR', 'ARROZ', 1, '2023-06-06 19:58:18'),
(3, 'GDFDSF', 'FEIJAO', 2, '2023-06-06 19:58:18'),
(4, 'FDSF156', 'SABONETE', 2, '2023-06-06 19:58:18'),
(6, '45S06', 'MILHO', 1, '2023-06-06 20:18:23'),
(7, '56K231', 'MACARRAO', 1, '2023-06-06 20:25:04'),
(8, '02cCOAlw', 'FARINHA DE MILHO', 1, '2023-06-06 20:27:41'),
(9, '4Xb7nSJf', 'MILHO VERDE', 1, '2023-06-06 20:27:41'),
(10, '594Y0I1q', 'SACO DE LIXO 50L', 4, '2023-06-06 20:27:41'),
(11, '5B0ACqWP', 'ATUM', 1, '2023-06-06 20:27:41'),
(12, '5O0IViB2', 'SUCO GARRAFA 1L', 5, '2023-06-06 20:27:41'),
(13, '5sEa9TBj', 'FARINHA DE MANDIOCA', 1, '2023-06-06 20:27:41'),
(14, '7fMku4ZJ', 'BOLACHA', 1, '2023-06-06 20:27:41'),
(15, '7kpExeNr', 'ÃGUA SANITÃRIA', 4, '2023-06-06 20:27:41'),
(16, '8S4muhTB', 'LUSTRA MÃ“VEIS', 4, '2023-06-06 20:27:41'),
(17, '9gUg4fhW', 'CONDICIONADOR', 4, '2023-06-06 20:27:41'),
(18, '9KSQWQAN', 'FARINHA DE TRIGO', 1, '2023-06-06 20:27:41'),
(19, 'a5Afk0NG', 'SARDINHA', 1, '2023-06-06 20:27:41'),
(20, 'abpV0cII', 'BUCHINHA DE PIA', 4, '2023-06-06 20:27:41'),
(21, 'Arm5PrVw', 'LEITE DESNATADO LITRO', 5, '2023-06-06 20:27:41'),
(22, 'awL9dJ7i', 'SABÃƒO EM PÃ“', 4, '2023-06-06 20:27:41'),
(23, 'BGsKAYCU', 'TIRA MANCHAS', 4, '2023-06-06 20:27:41'),
(24, 'bhoIdVcX', 'SAL', 1, '2023-06-06 20:27:41'),
(25, 'e3W3IGWA', 'FAROFA PRONTA', 1, '2023-06-06 20:27:41'),
(26, 'EJbJIT7i', 'ACHOCOLATADO', 1, '2023-06-06 20:27:41'),
(27, 'fPOA8tU1', 'MOLHO DE PIMENTA', 1, '2023-06-06 20:27:41'),
(28, 'HaulxSlU', 'LEITE INTEGRAL LITRO', 5, '2023-06-06 20:27:41'),
(29, 'LahWTF2I', 'LIMPA VIDROS', 4, '2023-06-06 20:27:41'),
(30, 'mkVXJGgU', 'ERVILHA', 1, '2023-06-06 20:27:41'),
(31, 'NGwdgoMb', 'AMACIANTE', 4, '2023-06-06 20:27:41'),
(32, 'nYr4CBpU', 'SUCO CAIXINHA 500ML', 5, '2023-06-06 20:27:41'),
(33, 'O9Ho0vfV', 'CAFÃ‰', 1, '2023-06-06 20:27:42'),
(34, 'oWPZZWx4', 'ESPONJA DE AÃ‡O', 4, '2023-06-06 20:27:42'),
(35, 'oZv8BD8Y', 'SHAMPO', 4, '2023-06-06 20:27:42'),
(36, 'Px883nbW', 'DETERGENTE', 4, '2023-06-06 20:27:42'),
(37, 'PXZq98xM', 'REFRIGERANTE 2L', 5, '2023-06-06 20:27:42'),
(38, 'qDK4Eou9', 'SABÃƒO EM PEDRA', 4, '2023-06-06 20:27:42'),
(39, 's2QICAQ9', 'SACO DE LIXO 30L', 4, '2023-06-06 20:27:42'),
(40, 't1Kr7FlU', 'AÃ‡UCAR', 1, '2023-06-06 20:27:42'),
(41, 'tkiTtmWs', 'DESINFETANTE', 4, '2023-06-06 20:27:42'),
(42, 'usvTGIKs', 'SUCO SACHÃŠ', 5, '2023-06-06 20:27:42'),
(43, 'wi3NKuid', 'MAIONESE', 1, '2023-06-06 20:27:42'),
(44, 'x8HBrAb9', 'ALCOOL', 4, '2023-06-06 20:27:42'),
(45, 'xdWWTrKM', 'FUBÃ', 1, '2023-06-06 20:27:42'),
(46, 'Xi7tcVDG', 'MOLHO DE TOMATE', 1, '2023-06-06 20:27:42'),
(47, 'dkjwbdj21', 'ALHO', 1, '2023-07-30 13:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `senha` char(32) NOT NULL,
  `nivel` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`) VALUES
(1, 'Adm', 'adm@gmail.com', '0e023702b107d3520a33e6a03362fed5', 2),
(2, 'Editor', 'editor@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(3, 'User', 'user@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0);

-- --------------------------------------------------------

--
-- Structure for view `listProd`
--
DROP TABLE IF EXISTS `listProd`;

CREATE ALGORITHM=UNDEFINED DEFINER=`athernos`@`localhost` SQL SECURITY DEFINER VIEW `listProd`  AS SELECT `produtos`.`id` AS `id`, `produtos`.`codigo` AS `codigo`, `produtos`.`nome` AS `nome`, `categoria`.`nome` AS `categoria`, sum(`lotes`.`quantidade`) AS `total`, min(`lotes`.`validade`) AS `menor_validade`, max(`lotes`.`validade`) AS `maior_validade`, (select `lotes`.`custo_unit` from `lotes` where `lotes`.`id_produto` = `produtos`.`id` order by `lotes`.`codigo` desc limit 1) AS `custo` FROM ((`produtos` left join `lotes` on(`lotes`.`id_produto` = `produtos`.`id`)) join `categoria` on(`categoria`.`id` = `produtos`.`id_categoria`)) GROUP BY `produtos`.`codigo` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_lotes`
--
ALTER TABLE `log_lotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `id_produto` (`id_produto`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log_lotes`
--
ALTER TABLE `log_lotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `lotes`
--
ALTER TABLE `lotes`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `lotes_ibfk_1` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

--
-- Constraints for table `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
