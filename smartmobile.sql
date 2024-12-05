-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 05-Dez-2024 às 15:24
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
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1733333310),
('cliente', '60', 1733333310),
('cliente', '64', 1733333310),
('funcionario', '57', 1733333310),
('gestor', '56', 1733333310);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
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
('addToCart', 2, 'Adicionar ao Carrinho', NULL, NULL, 1733333310, 1733333310),
('adicionarStock', 2, 'Adicionar Stock', NULL, NULL, 1733333310, 1733333310),
('admin', 1, NULL, NULL, NULL, 1733333310, 1733333310),
('cliente', 1, NULL, NULL, NULL, 1733333310, 1733333310),
('createCategoria', 2, 'Criar Categoria', NULL, NULL, 1733333310, 1733333310),
('createCliente', 2, 'Criar Cliente', NULL, NULL, 1733333310, 1733333310),
('createCompraLoja', 2, 'Criar Compra Loja', NULL, NULL, 1733333310, 1733333310),
('createFornecedor', 2, 'Criar Fornecedor', NULL, NULL, 1733333310, 1733333310),
('createFuncionario', 2, 'Criar Funcionario', NULL, NULL, 1733333310, 1733333310),
('createGestor', 2, 'Criar Gestor', NULL, NULL, 1733333310, 1733333310),
('createLoja', 2, 'Criar Loja', NULL, NULL, 1733333310, 1733333310),
('createMetodoEntrega', 2, 'Criar Metodo de Entrega', NULL, NULL, 1733333310, 1733333310),
('createMetodoPagamento', 2, 'Criar Metodo de Pagamento', NULL, NULL, 1733333310, 1733333310),
('createOrder', 2, 'Criar Encomenda', NULL, NULL, 1733333310, 1733333310),
('createProduto', 2, 'Criar Produto', NULL, NULL, 1733333310, 1733333310),
('createPromocao', 2, 'Criar Promoção', NULL, NULL, 1733333310, 1733333310),
('deleteCategoria', 2, 'Remover Categoria', NULL, NULL, 1733333310, 1733333310),
('deleteCliente', 2, 'Remover Cliente', NULL, NULL, 1733333310, 1733333310),
('deleteFornecedor', 2, 'Remover Fornecedor', NULL, NULL, 1733333310, 1733333310),
('deleteFuncionario', 2, 'Remover Funcionario', NULL, NULL, 1733333310, 1733333310),
('deleteGestor', 2, 'Remover Gestor', NULL, NULL, 1733333310, 1733333310),
('deleteLoja', 2, 'Remover Loja', NULL, NULL, 1733333310, 1733333310),
('deleteMetodoEntrega', 2, 'Remover Metodo de Entrega', NULL, NULL, 1733333310, 1733333310),
('deleteMetodoPagamento', 2, 'Remover Metodo de Pagamento', NULL, NULL, 1733333310, 1733333310),
('deleteMyProfile', 2, 'Remover o seu perfil', NULL, NULL, 1733333310, 1733333310),
('deleteOrder', 2, 'Remover Encomenda', NULL, NULL, 1733333310, 1733333310),
('deleteProduto', 2, 'Remover Produto', NULL, NULL, 1733333310, 1733333310),
('deletePromocao', 2, 'Remover Promoção', NULL, NULL, 1733333310, 1733333310),
('editQuantityOnCart', 2, 'Editar quantidade no Carrinho', NULL, NULL, 1733333310, 1733333310),
('funcionario', 1, NULL, NULL, NULL, 1733333310, 1733333310),
('gestor', 1, NULL, NULL, NULL, 1733333310, 1733333310),
('removeFromCart', 2, 'Remover do Carrinho', NULL, NULL, 1733333310, 1733333310),
('removerStock', 2, 'Remover Stock', NULL, NULL, 1733333310, 1733333310),
('statusOrder', 2, 'Alterar estado da encomenda', NULL, NULL, 1733333310, 1733333310),
('updateCategoria', 2, 'Atualizar Categoria', NULL, NULL, 1733333310, 1733333310),
('updateFornecedor', 2, 'Atualizar Fornecedor', NULL, NULL, 1733333310, 1733333310),
('updateFuncionario', 2, 'Atualizar Funcionario', NULL, NULL, 1733333310, 1733333310),
('updateGestor', 2, 'Atualizar Gestor', NULL, NULL, 1733333310, 1733333310),
('updateLoja', 2, 'Atualizar Loja', NULL, NULL, 1733333310, 1733333310),
('updateMetodoEntrega', 2, 'Atualizar Metodo de Entrega', NULL, NULL, 1733333310, 1733333310),
('updateMetodoPagamento', 2, 'Atualizar Metodo de Pagamento', NULL, NULL, 1733333310, 1733333310),
('updateMyProfile', 2, 'Atualizar o seu perfil', NULL, NULL, 1733333310, 1733333310),
('updateProduto', 2, 'Atualizar Produto', NULL, NULL, 1733333310, 1733333310),
('updatePromocao', 2, 'Atualizar Promoção', NULL, NULL, 1733333310, 1733333310),
('viewAllOrders', 2, 'Ver todas as encomendas', NULL, NULL, 1733333310, 1733333310),
('viewAllProfiles', 2, 'Ver todos os perfis', NULL, NULL, 1733333310, 1733333310),
('viewBackend', 2, 'Ver Backend', NULL, NULL, 1733333310, 1733333310),
('viewCart', 2, 'Ver Carrinho', NULL, NULL, 1733333310, 1733333310),
('viewCategoria', 2, 'Ver Categoria', NULL, NULL, 1733333310, 1733333310),
('viewCliente', 2, 'Ver Cliente', NULL, NULL, 1733333310, 1733333310),
('viewCompraLoja', 2, 'Ver Compra Loja', NULL, NULL, 1733333310, 1733333310),
('viewFornecedor', 2, 'Ver Fornecedor', NULL, NULL, 1733333310, 1733333310),
('viewFuncionario', 2, 'Ver Funcionario', NULL, NULL, 1733333310, 1733333310),
('viewGestor', 2, 'Ver Gestor', NULL, NULL, 1733333310, 1733333310),
('viewLoja', 2, 'Ver Loja', NULL, NULL, 1733333310, 1733333310),
('viewMetodoEntrega', 2, 'Ver Metodo de Entrega', NULL, NULL, 1733333310, 1733333310),
('viewMetodoPagamento', 2, 'Ver Metodo de Pagamento', NULL, NULL, 1733333310, 1733333310),
('viewMyProfile', 2, 'Ver o seu perfil', NULL, NULL, 1733333310, 1733333310),
('viewOwnOrders', 2, 'Ver as suas encomendas', NULL, NULL, 1733333310, 1733333310),
('viewPromocao', 2, 'Ver Promoção', NULL, NULL, 1733333310, 1733333310),
('viewStock', 2, 'Ver Stock', NULL, NULL, 1733333310, 1733333310);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
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
('funcionario', 'createCliente'),
('funcionario', 'createCompraLoja'),
('gestor', 'createFornecedor'),
('gestor', 'createFuncionario'),
('admin', 'createGestor'),
('gestor', 'createLoja'),
('admin', 'createMetodoEntrega'),
('admin', 'createMetodoPagamento'),
('cliente', 'createOrder'),
('gestor', 'createProduto'),
('admin', 'createPromocao'),
('gestor', 'deleteCategoria'),
('gestor', 'deleteCliente'),
('gestor', 'deleteFornecedor'),
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
('gestor', 'updateFornecedor'),
('gestor', 'updateFuncionario'),
('admin', 'updateGestor'),
('gestor', 'updateLoja'),
('admin', 'updateMetodoEntrega'),
('admin', 'updateMetodoPagamento'),
('cliente', 'updateMyProfile'),
('gestor', 'updateProduto'),
('admin', 'updatePromocao'),
('funcionario', 'viewAllOrders'),
('funcionario', 'viewAllProfiles'),
('funcionario', 'viewBackend'),
('cliente', 'viewCart'),
('gestor', 'viewCategoria'),
('funcionario', 'viewCliente'),
('funcionario', 'viewCompraLoja'),
('gestor', 'viewFornecedor'),
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
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `categoria_principal_id`) VALUES
(1, 'Telemoveis', NULL),
(2, 'Apple', 1),
(4, 'Iphone', 2),
(5, 'Iphone Recondicionado', 2),
(6, 'Com 100% de bateria', 5),
(7, 'Com menos de 80% de bateria', 5),
(8, 'Samsung', 1),
(9, 'TLC', 1),
(10, '70%', 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `compraloja`
--

INSERT INTO `compraloja` (`id`, `preçofornecedor`, `quantidade`, `datacompra`, `fornecedor_id`, `loja_id`, `produto_id`) VALUES
(4, 12.00, 100, '2024-12-04', 1, 4, 7),
(5, 12.00, 11, '2024-12-04', 1, 4, 7);

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
  `tipoentrega` varchar(45) NOT NULL,
  `moradaexpedicao_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userprofile_id` (`userprofile_id`),
  KEY `metodopagamento_id` (`metodopagamento_id`),
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id`, `empresa`, `contacto`) VALUES
(1, 'Logitech', '211231221'),
(2, 'Asus', '212321231');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens`
--

DROP TABLE IF EXISTS `imagens`;
CREATE TABLE IF NOT EXISTS `imagens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id`, `filename`) VALUES
(5, 'imagem_produto_5.png');

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
  `rua` varchar(85) NOT NULL,
  `localizacao` varchar(45) DEFAULT NULL,
  `codpostal` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `lojas`
--

INSERT INTO `lojas` (`id`, `nome`, `contacto`, `rua`, `localizacao`, `codpostal`) VALUES
(4, 'Leiria', '999999999', 'Rua da gandara', 'Leiria, Rua dos Inventarios', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `rua` int NOT NULL,
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
  `rua` varchar(85) NOT NULL,
  `localidade` varchar(100) DEFAULT NULL,
  `codpostal` varchar(8) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userprofile_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `moradas`
--

INSERT INTO `moradas` (`id`, `rua`, `localidade`, `codpostal`, `user_id`) VALUES
(1, 'Rua vale dos minhos', 'Leiria', '2400-441', 1),
(19, 'Rua da trunqueira', 'vale de moinhos', '2005-500', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `produtolojas`
--

INSERT INTO `produtolojas` (`id`, `quantidade`, `produto_id`, `loja_id`) VALUES
(1, 156, 7, 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `preco`, `descricao`, `categoria_id`, `imagem_id`) VALUES
(7, 'cao2', 0.00, 'a', 9, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `produto_promocao`
--

INSERT INTO `produto_promocao` (`id`, `datainicio`, `datafim`, `produto_id`, `promocoes_id`) VALUES
(2, '2024-12-04', '2024-12-05', 7, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `promocoes`
--

INSERT INTO `promocoes` (`id`, `nome`, `descricao`, `descontopercentual`) VALUES
(1, 'BlackFriday', 'Na Black Friday tens os melhores descontos possíveis', 15.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', 'FOPLSfyTgNgESknjyUYEyxE6o-QRjq8A', '$2y$13$4JacQBtU82QQMCoYbvkM6OUTQJE.mLtJXqJAm8skKqJxvzBHCQYxi', NULL, 'admin@gmail.com', 10, 1730739149, 1730739149, 'XeFjZRGBQN5iAZqiDEYQ6yn8IczwLy8V_1730739149'),
(56, 'gestor', 'aO10di9PZJLkhMwo95oC-8brEWgeCBk4', '$2y$13$8r2IuJWlTTDmU2OBvS8ZduRmnfeKCW30uZ9raxh9c7ruwuSHtTZlm', NULL, 'gestor@gmail.com', 10, 1732190497, 1732190497, NULL),
(57, 'funcionario', 'vJbDifuZ1jBm-ccQ2_pBGUfXLsVGgCZX', '$2y$13$x3/JSgbcTqChu044k55cnOuE.hKDs281p1xpX2OaXm8/KoKM8I2rG', NULL, 'funcionario@gmail.com', 10, 1732190524, 1732297397, NULL),
(60, 'Cliente', 'aKvmZXH_VW0igwgEDGi0izA85cF1Org2', '$2y$13$9KS.kCIvU3lR3HkdaYU7V.0rha1x7eV/hTTn/qHfoqVcrQOGylBy.', NULL, 'cliente@gmail.com', 10, 1732296687, 1732296687, NULL),
(64, 'beatriz', 'BrDd1rJmmcqMKKqYVRZfeJKa0W34Mn8C', '$2y$13$ZWXdSh8UeWGdMVWb5fnErensQ14Qmmr1sO4w/89zfAllDz0V1/ciS', NULL, 'beatrizc@hotmail.com', 10, 1732382439, 1732382439, NULL);

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
-- Extraindo dados da tabela `userprofiles`
--

INSERT INTO `userprofiles` (`id`, `nome`, `nif`, `telemovel`) VALUES
(1, 'Admin', 12345678, 111111111),
(56, 'Gestor', 123123123, 111111111),
(57, 'Funcionario', 123123123, 111111111),
(60, 'Cliente', 123123123, 111111111),
(64, 'beatriz', 123321123, 912432567);

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
  ADD CONSTRAINT `faturas_ibfk_5` FOREIGN KEY (`id`) REFERENCES `userprofiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `faturas_ibfk_6` FOREIGN KEY (`moradaexpedicao_id`) REFERENCES `moradaexpedicao` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
  ADD CONSTRAINT `moradas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
