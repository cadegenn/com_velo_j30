-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 30 Septembre 2013 à 12:41
-- Version du serveur: 5.5.32-0ubuntu0.13.04.1-log
-- Version de PHP: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `monvelo`
--

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_const_composants`
--

CREATE TABLE IF NOT EXISTS `#__velo_const_composants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label in english to be used as reference',
  `label_tr` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label_id translated into $language$ language',
  `language` varchar(8) COLLATE utf8_bin NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `published` int(11) NOT NULL,
  `zoomLevel` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label_id`,`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_const_materiaux`
--

CREATE TABLE IF NOT EXISTS `#__velo_const_materiaux` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label in english to be used as reference',
  `label_tr` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label_id translated into $language$ language',
  `language` varchar(8) COLLATE utf8_bin NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label_id`,`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_const_specs`
--

CREATE TABLE IF NOT EXISTS `#__velo_const_specs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label in english to be used as reference',
  `label_tr` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label_id translated into $language$ language',
  `language` varchar(8) COLLATE utf8_bin NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `published` int(11) NOT NULL,
  `unit` varchar(8) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label_id`,`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_const_types`
--

CREATE TABLE IF NOT EXISTS `#__velo_const_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label_id` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label in english to be used as reference',
  `label_tr` varchar(255) COLLATE utf8_bin NOT NULL COMMENT 'label_id translated into $language$ language',
  `language` varchar(8) COLLATE utf8_bin NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label_id`,`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_maMaintenance`
--

CREATE TABLE IF NOT EXISTS `#__velo_maMaintenance` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `temps` time NOT NULL,
  `velo_id` double unsigned NOT NULL,
  `composant_id` double unsigned NOT NULL COMMENT 'can also be a monVelo.id',
  `distance` int(10) unsigned DEFAULT NULL,
  `description` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_marques`
--

CREATE TABLE IF NOT EXISTS `#__velo_marques` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `published` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_bin NOT NULL,
  `logo` tinyblob,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `favicon` tinyblob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_models`
--

CREATE TABLE IF NOT EXISTS `#__velo_models` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `published` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_bin NOT NULL,
  `photo` longblob,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `release_date` date DEFAULT NULL,
  `const_composant_id` int(10) unsigned NOT NULL,
  `marque_id` double unsigned NOT NULL,
  `const_materiau_id` int(10) unsigned NOT NULL,
  `specs` text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT 'json formatted data',
  `poids` float DEFAULT NULL COMMENT 'grammes',
  `commentaires` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_monComposant`
--

CREATE TABLE IF NOT EXISTS `#__velo_monComposant` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `created_by` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `modified_by` int(10) unsigned DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  `model_id` double unsigned NOT NULL,
  `velo_id` double unsigned NOT NULL,
  `date_achat` date DEFAULT NULL,
  `prix_achat` float DEFAULT NULL,
  `distance_achat` bigint(20) unsigned NOT NULL DEFAULT '0',
  `date_vente` date DEFAULT NULL,
  `prix_vente` float DEFAULT NULL,
  `distance_vente` bigint(20) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL,
  `specs` text CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT 'json formatted data',
  `photos` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT 'relative/path/to/photos/of/this/bike/component',
  `commentaires` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `#__velo_monVelo`
--

CREATE TABLE IF NOT EXISTS `#__velo_monVelo` (
  `id` double unsigned NOT NULL AUTO_INCREMENT,
  `composant_id` double unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8_bin NOT NULL,
  `owner` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `bicycode` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `commentaires` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
