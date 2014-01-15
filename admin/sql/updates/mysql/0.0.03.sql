ALTER TABLE `#__velo_const_composants` ADD `created_by` INT( 10 ) UNSIGNED NOT NULL ,
ADD `creation_date` DATETIME NOT NULL ,
ADD `modified_by` INT( 10 ) UNSIGNED NULL ,
ADD `modification_date` DATETIME NULL ,
ADD `published` INT( 5 ) NOT NULL;

ALTER TABLE `#__velo_const_composants` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `#__velo_const_composants` ADD PRIMARY KEY (`id`);