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
  `unit` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label_id`,`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

ALTER TABLE  `#__velo_models` ADD  `specs` TEXT CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT 'json formatted data' AFTER  `published`;
ALTER TABLE  `#__velo_monComposant` ADD  `specs` TEXT CHARACTER SET utf8 COLLATE utf8_bin NULL COMMENT 'json formatted data' AFTER  `published`;