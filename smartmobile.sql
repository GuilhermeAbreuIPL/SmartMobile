-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 11-Nov-2024 às 15:37
-- Versão do servidor: 8.2.0
-- versão do PHP: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `smartmobile`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1730739901);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('addToCart', 2, 'Adicionar ao Carrinho', NULL, NULL, 1730739901, 1730739901),
('adicionarStock', 2, 'Adicionar Stock', NULL, NULL, 1730739901, 1730739901),
('admin', 1, NULL, NULL, NULL, 1730739901, 1730739901),
('cliente', 1, NULL, NULL, NULL, 1730739901, 1730739901),
('createCategoria', 2, 'Criar Categoria', NULL, NULL, 1730739901, 1730739901),
('createFuncionario', 2, 'Criar Funcionario', NULL, NULL, 1730739901, 1730739901),
('createGestor', 2, 'Criar Gestor', NULL, NULL, 1730739901, 1730739901),
('createLoja', 2, 'Criar Loja', NULL, NULL, 1730739901, 1730739901),
('createMetodoEntrega', 2, 'Criar Metodo de Entrega', NULL, NULL, 1730739901, 1730739901),
('createMetodoPagamento', 2, 'Criar Metodo de Pagamento', NULL, NULL, 1730739901, 1730739901),
('createOrder', 2, 'Criar Encomenda', NULL, NULL, 1730739901, 1730739901),
('createProduto', 2, 'Criar Produto', NULL, NULL, 1730739901, 1730739901),
('createPromocao', 2, 'Criar Promoção', NULL, NULL, 1730739901, 1730739901),
('deleteAllProfiles', 2, 'Deletar todos os perfis', NULL, NULL, 1730739901, 1730739901),
('deleteCategoria', 2, 'Deletar Categoria', NULL, NULL, 1730739901, 1730739901),
('deleteFuncionario', 2, 'Deletar Funcionario', NULL, NULL, 1730739901, 1730739901),
('deleteGestor', 2, 'Deletar Gestor', NULL, NULL, 1730739901, 1730739901),
('deleteLoja', 2, 'Deletar Loja', NULL, NULL, 1730739901, 1730739901),
('deleteMetodoEntrega', 2, 'Deletar Metodo de Entrega', NULL, NULL, 1730739901, 1730739901),
('deleteMetodoPagamento', 2, 'Deletar Metodo de Pagamento', NULL, NULL, 1730739901, 1730739901),
('deleteMyProfile', 2, 'Deletar o seu perfil', NULL, NULL, 1730739901, 1730739901),
('deleteOrder', 2, 'Deletar Encomenda', NULL, NULL, 1730739901, 1730739901),
('deleteProduto', 2, 'Deletar Produto', NULL, NULL, 1730739901, 1730739901),
('deletePromocao', 2, 'Deletar Promoção', NULL, NULL, 1730739901, 1730739901),
('editQuantityOnCart', 2, 'Editar quantidade no Carrinho', NULL, NULL, 1730739901, 1730739901),
('funcionario', 1, NULL, NULL, NULL, 1730739901, 1730739901),
('gestor', 1, NULL, NULL, NULL, 1730739901, 1730739901),
('removeFromCart', 2, 'Remover do Carrinho', NULL, NULL, 1730739901, 1730739901),
('removerStock', 2, 'Remover Stock', NULL, NULL, 1730739901, 1730739901),
('statusOrder', 2, 'Alterar estado da encomenda', NULL, NULL, 1730739901, 1730739901),
('updateCategoria', 2, 'Atualizar Categoria', NULL, NULL, 1730739901, 1730739901),
('updateFuncionario', 2, 'Atualizar Funcionario', NULL, NULL, 1730739901, 1730739901),
('updateGestor', 2, 'Atualizar Gestor', NULL, NULL, 1730739901, 1730739901),
('updateLoja', 2, 'Atualizar Loja', NULL, NULL, 1730739901, 1730739901),
('updateMetodoEntrega', 2, 'Atualizar Metodo de Entrega', NULL, NULL, 1730739901, 1730739901),
('updateMetodoPagamento', 2, 'Atualizar Metodo de Pagamento', NULL, NULL, 1730739901, 1730739901),
('updateMyProfile', 2, 'Atualizar o seu perfil', NULL, NULL, 1730739901, 1730739901),
('updateProduto', 2, 'Atualizar Produto', NULL, NULL, 1730739901, 1730739901),
('updatePromocao', 2, 'Atualizar Promoção', NULL, NULL, 1730739901, 1730739901),
('viewAllOrders', 2, 'Visualizar todas as encomendas', NULL, NULL, 1730739901, 1730739901),
('viewAllProfiles', 2, 'Visualizar todos os perfis', NULL, NULL, 1730739901, 1730739901),
('viewCart', 2, 'Visualizar Carrinho', NULL, NULL, 1730739901, 1730739901),
('viewCategoria', 2, 'Visualizar Categoria', NULL, NULL, 1730739901, 1730739901),
('viewFuncionario', 2, 'Visualizar Funcionario', NULL, NULL, 1730739901, 1730739901),
('viewGestor', 2, 'Visualizar Gestor', NULL, NULL, 1730739901, 1730739901),
('viewLoja', 2, 'Visualizar Loja', NULL, NULL, 1730739901, 1730739901),
('viewMetodoEntrega', 2, 'Visualizar Metodo de Entrega', NULL, NULL, 1730739901, 1730739901),
('viewMetodoPagamento', 2, 'Visualizar Metodo de Pagamento', NULL, NULL, 1730739901, 1730739901),
('viewMyProfile', 2, 'Visualizar o seu perfil', NULL, NULL, 1730739901, 1730739901),
('viewOwnOrders', 2, 'Visualizar as suas encomendas', NULL, NULL, 1730739901, 1730739901),
('viewPromocao', 2, 'Visualizar Promoção', NULL, NULL, 1730739901, 1730739901),
('viewStock', 2, 'Visualizar Stock', NULL, NULL, 1730739901, 1730739901);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('cliente', 'addToCart'),
('funcionario', 'adicionarStock'),
('gestor', 'createCategoria'),
('gestor', 'createFuncionario'),
('admin', 'createGestor'),
('gestor', 'createLoja'),
('admin', 'createMetodoEntrega'),
('admin', 'createMetodoPagamento'),
('cliente', 'createOrder'),
('gestor', 'createProduto'),
('admin', 'createPromocao'),
('admin', 'deleteAllProfiles'),
('gestor', 'deleteCategoria'),
('gestor', 'deleteFuncionario'),
('admin', 'deleteGestor'),
('gestor', 'deleteLoja'),
('admin', 'deleteMetodoEntrega'),
('admin', 'deleteMetodoPagamento'),
('cliente', 'deleteMyProfile'),
('funcionario', 'deleteOrder'),
('gestor', 'deleteProduto'),
('admin', 'deletePromocao'),
('cliente', 'editQuantityOnCart'),
('gestor', 'funcionario'),
('admin', 'gestor'),
('cliente', 'removeFromCart'),
('gestor', 'removerStock'),
('funcionario', 'statusOrder'),
('gestor', 'updateCategoria'),
('gestor', 'updateFuncionario'),
('admin', 'updateGestor'),
('gestor', 'updateLoja'),
('admin', 'updateMetodoEntrega'),
('admin', 'updateMetodoPagamento'),
('cliente', 'updateMyProfile'),
('gestor', 'updateProduto'),
('admin', 'updatePromocao'),
('funcionario', 'viewAllOrders'),
('admin', 'viewAllProfiles'),
('cliente', 'viewCart'),
('gestor', 'viewCategoria'),
('gestor', 'viewFuncionario'),
('admin', 'viewGestor'),
('gestor', 'viewLoja'),
('admin', 'viewMetodoEntrega'),
('admin', 'viewMetodoPagamento'),
('cliente', 'viewMyProfile'),
('cliente', 'viewOwnOrders'),
('admin', 'viewPromocao'),
('funcionario', 'viewStock');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

DROP TABLE IF EXISTS `carrinhos`;
CREATE TABLE IF NOT EXISTS `carrinhos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datacriacao` datetime DEFAULT NULL,
  `userprofile_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userprofile_id` (`userprofile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `categoria_principal_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_principal_id` (`categoria_principal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `compraloja`
--

DROP TABLE IF EXISTS `compraloja`;
CREATE TABLE IF NOT EXISTS `compraloja` (
  `id` int NOT NULL AUTO_INCREMENT,
  `preçofornecedor` decimal(10,2) DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `datacompra` date DEFAULT NULL,
  `fornecedor_id` int DEFAULT NULL,
  `loja_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fornecedor_id` (`fornecedor_id`),
  KEY `loja_id` (`loja_id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `faturas`
--

DROP TABLE IF EXISTS `faturas`;
CREATE TABLE IF NOT EXISTS `faturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datafatura` datetime DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `statusorder` varchar(45) DEFAULT NULL,
  `userprofile_id` int DEFAULT NULL,
  `metodopagamento_id` int DEFAULT NULL,
  `metodoentrega_id` int DEFAULT NULL,
  `moradaexpedicao_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userprofile_id` (`userprofile_id`),
  KEY `metodopagamento_id` (`metodopagamento_id`),
  KEY `metodoentrega_id` (`metodoentrega_id`),
  KEY `moradaexpedicao_id` (`moradaexpedicao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE IF NOT EXISTS `fornecedor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `empresa` varchar(45) DEFAULT NULL,
  `contacto` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

DROP TABLE IF EXISTS `imagens`;
CREATE TABLE IF NOT EXISTS `imagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(45) DEFAULT NULL,
  `fileextension` varchar(45) DEFAULT NULL,
  `filesize` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhacarrinho`
--

DROP TABLE IF EXISTS `linhacarrinho`;
CREATE TABLE IF NOT EXISTS `linhacarrinho` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int DEFAULT NULL,
  `precounitario` decimal(10,2) DEFAULT NULL,
  `carrinho_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carrinho_id` (`carrinho_id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `linhafatura`
--

DROP TABLE IF EXISTS `linhafatura`;
CREATE TABLE IF NOT EXISTS `linhafatura` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int DEFAULT NULL,
  `precounitario` decimal(10,2) DEFAULT NULL,
  `fatura_id` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fatura_id` (`fatura_id`),
  KEY `produto_id` (`produto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lojas`
--

DROP TABLE IF EXISTS `lojas`;
CREATE TABLE IF NOT EXISTS `lojas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `contacto` varchar(15) DEFAULT NULL,
  `localizacao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `metodoentrega`
--

DROP TABLE IF EXISTS `metodoentrega`;
CREATE TABLE IF NOT EXISTS `metodoentrega` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `metodopagamentos`
--

DROP TABLE IF EXISTS `metodopagamentos`;
CREATE TABLE IF NOT EXISTS `metodopagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1730135284),
('m130524_201442_init', 1730135287),
('m140506_102106_rbac_init', 1730135631),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1730135631),
('m180523_151638_rbac_updates_indexes_without_prefix', 1730135631),
('m190124_110200_add_verification_token_column_to_user_table', 1730135287),
('m200409_110543_rbac_update_mssql_trigger', 1730135631);

-- --------------------------------------------------------

--
-- Estrutura da tabela `moradaexpedicao`
--

DROP TABLE IF EXISTS `moradaexpedicao`;
CREATE TABLE IF NOT EXISTS `moradaexpedicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `localidade` varchar(100) DEFAULT NULL,
  `codpostal` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `moradas`
--

DROP TABLE IF EXISTS `moradas`;
CREATE TABLE IF NOT EXISTS `moradas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `localidade` varchar(100) DEFAULT NULL,
  `codpostal` varchar(8) DEFAULT NULL,
  `userprofile_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userprofile_id` (`userprofile_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtolojas`
--

DROP TABLE IF EXISTS `produtolojas`;
CREATE TABLE IF NOT EXISTS `produtolojas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quantidade` int DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `loja_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  KEY `loja_id` (`loja_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `descricao` text,
  `categoria_id` int DEFAULT NULL,
  `imagem_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `imagem_id` (`imagem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_promocao`
--

DROP TABLE IF EXISTS `produto_promocao`;
CREATE TABLE IF NOT EXISTS `produto_promocao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datainicio` date DEFAULT NULL,
  `datafim` date DEFAULT NULL,
  `produto_id` int DEFAULT NULL,
  `promocoes_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produto_id` (`produto_id`),
  KEY `promocoes_id` (`promocoes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `promocoes`
--

DROP TABLE IF EXISTS `promocoes`;
CREATE TABLE IF NOT EXISTS `promocoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text,
  `descontopercentual` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', 'FOPLSfyTgNgESknjyUYEyxE6o-QRjq8A', '$2y$13$4JacQBtU82QQMCoYbvkM6OUTQJE.mLtJXqJAm8skKqJxvzBHCQYxi', NULL, 'admin@gmail.com', 10, 1730739149, 1730739149, 'XeFjZRGBQN5iAZqiDEYQ6yn8IczwLy8V_1730739149'),
(3, 'Utilizador1', 'Q0RORkrKXtrIhB_yvrAEMHx7arFVfo6c', '$2y$13$PVqjKudOw/1OSxeIBHQtzOkn88SEvjstHI0C2/aZvWjOSzFFiFVlG', NULL, 'asdfasdf@sdsd.sdf', 9, 1730740245, 1730740245, 'I6LUJtlmNLtZjggAFil4TwjDyxdZC0Lc_1730740245');

-- --------------------------------------------------------

--
-- Estrutura da tabela `userprofiles`
--

DROP TABLE IF EXISTS `userprofiles`;
CREATE TABLE IF NOT EXISTS `userprofiles` (
  `id` int NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `nif` int DEFAULT NULL,
  `telemovel` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `carrinhos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `userprofiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`categoria_principal_id`) REFERENCES `categorias` (`id`);

--
-- Limitadores para a tabela `compraloja`
--
ALTER TABLE `compraloja`
  ADD CONSTRAINT `compraloja_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`id`),
  ADD CONSTRAINT `compraloja_ibfk_2` FOREIGN KEY (`loja_id`) REFERENCES `lojas` (`id`),
  ADD CONSTRAINT `compraloja_ibfk_3` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `faturas`
--
ALTER TABLE `faturas`
  ADD CONSTRAINT `faturas_ibfk_2` FOREIGN KEY (`metodopagamento_id`) REFERENCES `metodopagamentos` (`id`),
  ADD CONSTRAINT `faturas_ibfk_3` FOREIGN KEY (`metodoentrega_id`) REFERENCES `metodoentrega` (`id`),
  ADD CONSTRAINT `faturas_ibfk_4` FOREIGN KEY (`moradaexpedicao_id`) REFERENCES `moradaexpedicao` (`id`),
  ADD CONSTRAINT `faturas_ibfk_5` FOREIGN KEY (`id`) REFERENCES `userprofiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `linhacarrinho`
--
ALTER TABLE `linhacarrinho`
  ADD CONSTRAINT `linhacarrinho_ibfk_1` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinhos` (`id`),
  ADD CONSTRAINT `linhacarrinho_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `linhafatura`
--
ALTER TABLE `linhafatura`
  ADD CONSTRAINT `linhafatura_ibfk_1` FOREIGN KEY (`fatura_id`) REFERENCES `faturas` (`id`),
  ADD CONSTRAINT `linhafatura_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `moradas`
--
ALTER TABLE `moradas`
  ADD CONSTRAINT `moradas_ibfk_1` FOREIGN KEY (`id`) REFERENCES `userprofiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Limitadores para a tabela `produtolojas`
--
ALTER TABLE `produtolojas`
  ADD CONSTRAINT `produtolojas_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `produtolojas_ibfk_2` FOREIGN KEY (`loja_id`) REFERENCES `lojas` (`id`);

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `produtos_ibfk_2` FOREIGN KEY (`imagem_id`) REFERENCES `imagens` (`id`);

--
-- Limitadores para a tabela `produto_promocao`
--
ALTER TABLE `produto_promocao`
  ADD CONSTRAINT `produto_promocao_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `produto_promocao_ibfk_2` FOREIGN KEY (`promocoes_id`) REFERENCES `promocoes` (`id`);

--
-- Limitadores para a tabela `userprofiles`
--
ALTER TABLE `userprofiles`
  ADD CONSTRAINT `userprofiles_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
