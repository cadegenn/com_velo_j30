ALTER TABLE `#__velo_maMaintenance` ADD  `temps` TIME NOT NULL AFTER  `modification_date`;
ALTER TABLE `#__velo_maMaintenance` ADD  `velo_id` DOUBLE UNSIGNED NOT NULL AFTER  `temps`;
ALTER TABLE `#__velo_maMaintenance` DROP `date`;