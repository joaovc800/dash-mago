-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/09/2024 às 15:03
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mago`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `magoautomation`
--

CREATE TABLE `magoautomation` (
  `id` int(11) NOT NULL,
  `email_login` varchar(255) NOT NULL,
  `senha_login` varchar(32) NOT NULL,
  `banca_inicial` decimal(10,2) NOT NULL DEFAULT 0.00,
  `banca_atual` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stopwin` int(11) NOT NULL DEFAULT 0,
  `stoplos` int(11) NOT NULL DEFAULT 0,
  `ficha` int(11) NOT NULL,
  `gale` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL,
  `noperacoes` int(11) NOT NULL DEFAULT 0,
  `ativo` int(11) NOT NULL DEFAULT 0,
  `assinatura` varchar(255) NOT NULL,
  `vencimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `magoautomation`
--

INSERT INTO `magoautomation` (`id`, `email_login`, `senha_login`, `banca_inicial`, `banca_atual`, `stopwin`, `stoplos`, `ficha`, `gale`, `status`, `noperacoes`, `ativo`, `assinatura`, `vencimento`) VALUES
(1, 'teste@teste.com', 'c20ad4d76fe97759aa27a0c99bff6710', 2102.00, 2500.30, 3000, 500, 1, 0, 'desligado', 6, 0, '1', '2024-09-30');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `magoautomation`
--
ALTER TABLE `magoautomation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `magoautomation`
--
ALTER TABLE `magoautomation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
