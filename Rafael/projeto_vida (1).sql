-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/05/2025 às 18:23
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto_vida`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `objetivos`
--

CREATE TABLE `objetivos` (
  `id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `prazo` date NOT NULL,
  `tipo_prazo` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `planos`
--

CREATE TABLE `planos` (
  `id` int(11) NOT NULL,
  `dados` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`dados`)),
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `plano_acao`
--

CREATE TABLE `plano_acao` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `area` varchar(255) NOT NULL,
  `passo` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `upload_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `profissoes`
--

CREATE TABLE `profissoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `areas_atuacao` varchar(255) NOT NULL,
  `salario_medio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `respostas_autoconhecimentos`
--

CREATE TABLE `respostas_autoconhecimentos` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `pergunta` varchar(255) NOT NULL,
  `resposta` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `resultados`
--

CREATE TABLE `resultados` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resultado` varchar(255) NOT NULL,
  `data_resposta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `resultados`
--

INSERT INTO `resultados` (`id`, `user_id`, `resultado`, `data_resposta`) VALUES
(1, 12, 'A', '2025-04-09 11:31:41'),
(2, 13, 'B', '2025-04-11 11:02:27'),
(3, 13, 'B', '2025-04-23 07:28:27'),
(4, 13, 'B', '2025-04-23 07:28:27'),
(5, 13, 'B', '2025-04-23 07:28:27'),
(6, 13, 'B', '2025-04-23 07:28:27'),
(7, 13, 'B', '2025-04-23 07:28:28'),
(8, 13, 'B', '2025-04-23 07:28:28'),
(9, 13, 'B', '2025-04-23 07:28:28'),
(10, 13, 'B', '2025-04-23 07:28:28'),
(11, 13, 'B', '2025-04-23 07:28:28'),
(12, 13, 'B', '2025-04-23 07:28:28'),
(13, 13, 'B', '2025-04-23 07:28:28'),
(14, 13, 'B', '2025-04-23 07:28:28'),
(15, 13, 'B', '2025-04-23 07:28:28'),
(16, 13, 'B', '2025-04-23 07:28:28'),
(17, 13, 'A', '2025-04-25 13:12:55'),
(18, 13, 'B', '2025-04-25 14:54:02'),
(19, 15, 'A', '2025-04-30 07:25:23'),
(20, 13, 'B', '2025-04-30 13:56:54'),
(21, 16, 'A', '2025-04-30 15:06:29'),
(22, 16, 'A', '2025-04-30 15:08:33'),
(23, 17, 'A', '2025-05-07 10:29:46'),
(24, 13, 'C', '2025-05-07 14:07:13'),
(25, 13, 'C', '2025-05-07 14:07:13'),
(26, 13, 'B', '2025-05-07 14:08:45'),
(27, 13, 'B', '2025-05-07 14:08:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sonhos`
--

CREATE TABLE `sonhos` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `acoes_atuais` varchar(255) NOT NULL,
  `acoes_futuras` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `teste_inteligencias`
--

CREATE TABLE `teste_inteligencias` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resultado` varchar(255) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `teste_personalidade`
--

CREATE TABLE `teste_personalidade` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tipo_teste` varchar(255) NOT NULL,
  `resultado` varchar(255) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `sobre_mim` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL,
  `minhasinspiracoes` text DEFAULT NULL,
  `meusonho` text DEFAULT NULL,
  `escolha` text DEFAULT NULL,
  `listesonho` text DEFAULT NULL,
  `oquejafaz` text DEFAULT NULL,
  `alcancar` text DEFAULT NULL,
  `objetivodecurtoprazo` text DEFAULT NULL,
  `objetivodemedioprazo` text DEFAULT NULL,
  `objetivodelongoprazo` text DEFAULT NULL,
  `daquidezanos` text DEFAULT NULL,
  `fale_sobre_voce` text NOT NULL,
  `lembrancas` text NOT NULL,
  `pontos_fortes` text NOT NULL,
  `pontos_fracos` text NOT NULL,
  `valores` varchar(255) NOT NULL,
  `aptidoes` varchar(255) NOT NULL,
  `familia` varchar(255) NOT NULL,
  `amigos` varchar(255) NOT NULL,
  `escola` varchar(255) NOT NULL,
  `sociedade` varchar(255) NOT NULL,
  `gosto_fazer` text NOT NULL,
  `nao_gosto` text NOT NULL,
  `rotina` varchar(255) NOT NULL,
  `lazer` varchar(255) NOT NULL,
  `estudos` varchar(255) NOT NULL,
  `vida_escolar` varchar(255) NOT NULL,
  `visao_fisica` varchar(255) NOT NULL,
  `visao_intelectual` varchar(255) NOT NULL,
  `visao_emocional` varchar(255) NOT NULL,
  `visao_amigos` varchar(255) NOT NULL,
  `visao_familia` varchar(255) NOT NULL,
  `visao_professores` varchar(255) NOT NULL,
  `autovalorizacao` varchar(255) NOT NULL,
  `perfil` varchar(50) DEFAULT NULL,
  `pontuacoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pontuacoes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `senha`, `data_nascimento`, `sobre_mim`, `foto_perfil`, `created_at`, `updated_at`, `minhasinspiracoes`, `meusonho`, `escolha`, `listesonho`, `oquejafaz`, `alcancar`, `objetivodecurtoprazo`, `objetivodemedioprazo`, `objetivodelongoprazo`, `daquidezanos`, `fale_sobre_voce`, `lembrancas`, `pontos_fortes`, `pontos_fracos`, `valores`, `aptidoes`, `familia`, `amigos`, `escola`, `sociedade`, `gosto_fazer`, `nao_gosto`, `rotina`, `lazer`, `estudos`, `vida_escolar`, `visao_fisica`, `visao_intelectual`, `visao_emocional`, `visao_amigos`, `visao_familia`, `visao_professores`, `autovalorizacao`, `perfil`, `pontuacoes`) VALUES
(13, 'Rafael', 'rafael@gmail.com', '$2y$10$F0Rdp8iYKKC9oEpBjl2sVeazZ/IVGmoRssO4c8cUOq4VrucZwA4NK', '2007-12-06', 'Sou uma pessoa que gosta mto de jogar bola , sou apaixonada ´pelo lionel messi \r\n', 'uploadsperfil_68125be471e6b8.94883002.jpg', '2025-05-07 16:01:19', '2025-04-30 14:20:39', NULL, 'cervsbdthnfygjmuk', 'fghjk', 'fsgdhfjgkj', 'nknknsfgdhfjkh', 'nkjbhvgc', 'sdfjgkhj', 'dafsghjh', 'dfgh', 'dfg', 'eu sou mto lindo', 'boas', 'todos', 'nenhum', '', '', 'bom', 'bom', 'bom', 'bom', '', '', '', '', '', '', 'eecec', 'ewc', 'wec', 'ecewcewc', 'xcd', 'dwcwdc', '[\"Confiante\",\"Persistente\",\"Respons\\u00e1vel\"]', NULL, NULL),
(14, 'Rafael', 'rafae@gmail.com', '$2y$10$hbIYl7KZfVauYnTsuH0mG.Rx5iHp85hO3gSs9vwyYW/jtjc.oTESK', '2007-12-06', '', '', '2025-04-11 13:57:10', '2025-04-11 10:57:10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '0', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(15, 'jonatas', 'jonatas@docente.br', '$2y$10$vUS8ej2ncx1py8cfg7QkqukIsZxduOwYt.69DYY9RAYXSHP2ruQhi', '1995-08-11', 'vfcbf', '', '2025-04-30 10:36:54', '2025-04-30 07:24:46', NULL, NULL, NULL, NULL, 'ddd', 'eee', NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '[]', NULL, NULL),
(16, 'kaua', 'teste@gmail.com', '$2y$10$LL0UGj4dnd.vn.YMTquKo.kymBrTgcyNuP4oc2LIQFt9w5Hk54uTq', '2025-04-23', '', '', '2025-04-30 18:05:01', '2025-04-30 15:03:27', NULL, 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', '', '', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', 'teste@gmail.com', '[\"Confiante\"]', NULL, NULL),
(17, 'Marcos', 'marcos@gmail.com', '$2y$10$1Sulbt4U9qa6ZWjoqndVVuZRCz7BYZTCVNRAVyjuc/wXWVeucCjC.', '2008-08-16', 'bla bla bla', 'uploadsperfil_681b5de61cfa97.62219211.jpg', '2025-05-07 15:59:52', '2025-05-07 10:19:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(18, 'testedois', 'testee@gmail.com', '$2y$10$S9Sk7GLLhpIGaxmh6I.hc.Fq/qx1HyCCizlZLP.cSSM79/9cdus4.', '2005-02-05', '', 'uploadsperfil_681b46fc73d417.98964885.jpg', '2025-05-07 11:41:48', '2025-05-07 08:41:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(19, 'carol', 'carol@gmail.com', '$2y$10$Hkc9OCrfcZEx722m7EDA/uSbu78OQy.8nuVNioqFuJpdG6CWlGWG6', '2022-02-22', '', '', '2025-05-07 13:31:39', '2025-05-07 10:31:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, NULL),
(20, '', '', '$2y$10$Y83uzZypGGPwJz8e72F9o.0zV072hMDi3qg0kX/QqUGEaLSSs3tPG', '0000-00-00', '', 'uploadsperfil_681e0c68e3d519.47636501.jpg', '2025-05-09 16:04:02', '2025-05-09 13:04:02', NULL, 'asdfghj,', 'asdfghj', 'sdfghj,', 'sdfghjk', 'sdfghjk', 'sdfghj,', 'sdfghjk,', 'sdfghj', 'zxcvbnm,', 'kjhg', 'asddddddddfg', 'asdfghj', 'asdfgh', '', '', 'asdf', 'sdf', 'sdfg', 'sdfg', 'sdfghjkl', 'dfghjklç', '~fghjklç', '~dfghjkl', 'sdfghjkl', 'asdfghj', 'sdfghjk', 'sdfghjk', 'dfghjkl', 'zxcvbnm,', 'xcvbnm,.', 'zxcvbnm,.', '[]', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `objetivos`
--
ALTER TABLE `objetivos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `planos`
--
ALTER TABLE `planos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `plano_acao`
--
ALTER TABLE `plano_acao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `profissoes`
--
ALTER TABLE `profissoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `respostas_autoconhecimentos`
--
ALTER TABLE `respostas_autoconhecimentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `resultados`
--
ALTER TABLE `resultados`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sonhos`
--
ALTER TABLE `sonhos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `teste_inteligencias`
--
ALTER TABLE `teste_inteligencias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `teste_personalidade`
--
ALTER TABLE `teste_personalidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `objetivos`
--
ALTER TABLE `objetivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `planos`
--
ALTER TABLE `planos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `plano_acao`
--
ALTER TABLE `plano_acao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `profissoes`
--
ALTER TABLE `profissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `respostas_autoconhecimentos`
--
ALTER TABLE `respostas_autoconhecimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `resultados`
--
ALTER TABLE `resultados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `sonhos`
--
ALTER TABLE `sonhos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `teste_inteligencias`
--
ALTER TABLE `teste_inteligencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `teste_personalidade`
--
ALTER TABLE `teste_personalidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
