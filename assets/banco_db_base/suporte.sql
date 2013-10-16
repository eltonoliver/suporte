-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Máquina: 127.0.0.1
-- Data de Criação: 16-Out-2013 às 17:52
-- Versão do servidor: 5.5.32
-- versão do PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `suporte`
--
CREATE DATABASE IF NOT EXISTS `suporte` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `suporte`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('916388d16a6a6f4908211e13768d368a', '::1', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36', 1381865994, 'a:4:{s:9:"user_data";s:0:"";s:10:"usuario_id";i:3;s:5:"login";s:14:"ELTON OLIVEIRA";s:10:"suporte_id";s:1:"1";}');

-- --------------------------------------------------------

--
-- Estrutura da tabela `duvidas`
--

CREATE TABLE IF NOT EXISTS `duvidas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `conteudo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `duvidas`
--

INSERT INTO `duvidas` (`id`, `titulo`, `conteudo`) VALUES
(1, 'Dúvida 1', '<p>\r\n	Conte&uacute;do da D&uacute;vida</p>\r\n'),
(3, 'Duvida 2', '<p>\r\n	Duvida 2</p>\r\n'),
(4, 'asd', '<p>\r\n	asdsad</p>\r\n'),
(5, 'titulo', '<p>\r\n	<strong style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">Lorem Ipsum</strong><span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">&nbsp;&eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu n&atilde;o s&oacute; a cinco s&eacute;culos, como tamb&eacute;m ao salto para a editora&ccedil;&atilde;o eletr&ocirc;nica, permanecendo essencialmente inalterado. Se popularizou na d&eacute;cada de 60, quando a Letraset lan&ccedil;ou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editora&ccedil;&atilde;o eletr&ocirc;nica como Aldus PageMaker.</span></p>\r\n'),
(6, 'titulo 2', '<p>\r\n	<strong style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">Lorem Ipsum</strong><span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">&nbsp;&eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu n&atilde;o s&oacute; a cinco s&eacute;culos, como tamb&eacute;m ao salto para a editora&ccedil;&atilde;o eletr&ocirc;nica, permanecendo essencialmente inalterado. Se popularizou na d&eacute;cada de 60, quando a Letraset lan&ccedil;ou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editora&ccedil;&atilde;o eletr&ocirc;nica como Aldus PageMaker.</span></p>\r\n'),
(7, 'titulo 3', '<p>\r\n	<strong style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">Lorem Ipsum</strong><span style="color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans; font-size: 11px; line-height: 14px; text-align: justify;">&nbsp;&eacute; simplesmente uma simula&ccedil;&atilde;o de texto da ind&uacute;stria tipogr&aacute;fica e de impressos, e vem sendo utilizado desde o s&eacute;culo XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu n&atilde;o s&oacute; a cinco s&eacute;culos, como tamb&eacute;m ao salto para a editora&ccedil;&atilde;o eletr&ocirc;nica, permanecendo essencialmente inalterado. Se popularizou na d&eacute;cada de 60, quando a Letraset lan&ccedil;ou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editora&ccedil;&atilde;o eletr&ocirc;nica como Aldus PageMaker.</span></p>\r\n'),
(8, '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensagem` text NOT NULL,
  `data` date NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `solicitacao_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`solicitacao_id`),
  KEY `fk_forum_solicitacao1_idx` (`solicitacao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `descricao` text NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `descricao`, `data`) VALUES
(1, 'werrew', '<p>\r\n	werwer</p>\r\n', '0000-00-00'),
(2, 'werwer', '<p>\r\n	werwer</p>\r\n', '0000-00-00'),
(3, 'Teste Teste Teste', '<p>\r\n	Teste Teste Teste&nbsp;Teste Teste Teste&nbsp;Teste Teste Teste&nbsp;Teste Teste Teste&nbsp;Teste Teste Teste</p>\r\n', '0000-00-00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `patrimonio`
--

CREATE TABLE IF NOT EXISTS `patrimonio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patrimonio` varchar(40) DEFAULT NULL,
  `id_unidade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `patrimonio`
--

INSERT INTO `patrimonio` (`id`, `patrimonio`, `id_unidade`) VALUES
(1, 'ijijij32323', 1),
(2, 'ji20@#', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `prioridade`
--

CREATE TABLE IF NOT EXISTS `prioridade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `prioridade`
--

INSERT INTO `prioridade` (`id`, `nome`) VALUES
(1, 'Baixa'),
(2, 'Média'),
(3, 'Alta');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sistemas`
--

CREATE TABLE IF NOT EXISTS `sistemas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `sistemas`
--

INSERT INTO `sistemas` (`id`, `nome`, `descricao`) VALUES
(1, 'Mira', 'Sistemas .......'),
(2, 'MXM', 'Sistema de ...'),
(3, 'RM LABORE', 'Sistema ERP');

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE IF NOT EXISTS `situacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `situacao`
--

INSERT INTO `situacao` (`id`, `nome`) VALUES
(1, 'Encaminhado para Providências'),
(3, 'Finalizado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `solicitacao`
--

CREATE TABLE IF NOT EXISTS `solicitacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao_equi` varchar(150) CHARACTER SET utf8 NOT NULL,
  `descricao_servico` text CHARACTER SET utf8,
  `anexo` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `local_servico` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_solicitacao` date NOT NULL,
  `data_atualizacao` date DEFAULT NULL,
  `data_finalizacao` date DEFAULT NULL,
  `situacao_id` int(11) NOT NULL DEFAULT '1',
  `prioridade_id` int(11) NOT NULL DEFAULT '1',
  `id_suporte` int(11) DEFAULT NULL,
  `sistemas_id` int(11) DEFAULT NULL,
  `patrimonio` int(8) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitacao_equi_situacao1_idx` (`situacao_id`),
  KEY `fk_solicitacao_equi_prioridade1_idx` (`prioridade_id`),
  KEY `fk_solicitacao_equi_sistemas1_idx` (`sistemas_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

--
-- Extraindo dados da tabela `solicitacao`
--

INSERT INTO `solicitacao` (`id`, `descricao_equi`, `descricao_servico`, `anexo`, `local_servico`, `usuario_id`, `data_solicitacao`, `data_atualizacao`, `data_finalizacao`, `situacao_id`, `prioridade_id`, `id_suporte`, `sistemas_id`, `patrimonio`, `tipo`) VALUES
(155, '', '<p>\r\n	asdasdasd</p>\r\n', NULL, 22, 3, '2013-10-15', NULL, NULL, 1, 1, NULL, 2, NULL, 2),
(156, '', '<p>\r\n	sdf</p>\r\n', NULL, 22, 3, '2013-10-15', NULL, NULL, 1, 1, NULL, 3, NULL, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `status`
--

INSERT INTO `status` (`id`, `nome`) VALUES
(1, 'Ativo'),
(2, 'Inativo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `login` varchar(45) NOT NULL,
  `cargo` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`status_id`),
  KEY `fk_usuarios_status_idx` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `login`, `cargo`, `email`, `status_id`) VALUES
(1, 'ELTON OLIVEIRA', 'elton', 'Programador', 'elton.oliveira@am.senac.br', 1),
(3, 'FERNANDO MAURICIO', 'fernando', 'Analista de Sistemas', 'fernando.mauricio@am.senac.br', 1),
(15, 'RUI ALENCAR', 'RUI ALENCAR', 'GERENTE - GIC', 'rui.alencar@am.senac.br', 1),
(16, 'asd', 'asd', 'asd', 'asd', 1),
(19, 'e', 'e', 'e', 'e', 1),
(20, 'v', 'v', 'v', 'v', 1),
(21, 'g', 'g', 'g', 'g', 1),
(22, 'j', 'j', 'j', 'j', 1),
(23, 'h', 'h', 'h', 'h', 1);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `fk_forum_solicitacao1` FOREIGN KEY (`solicitacao_id`) REFERENCES `solicitacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `solicitacao`
--
ALTER TABLE `solicitacao`
  ADD CONSTRAINT `fk_solicitacao_equi_prioridade1` FOREIGN KEY (`prioridade_id`) REFERENCES `prioridade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitacao_equi_sistemas1` FOREIGN KEY (`sistemas_id`) REFERENCES `sistemas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitacao_equi_situacao1` FOREIGN KEY (`situacao_id`) REFERENCES `situacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
