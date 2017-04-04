ALTER TABLE `bundles` ADD `color` VARCHAR(255) NULL DEFAULT NULL AFTER `bundle_created`;
ALTER TABLE `bundles` CHANGE `color` `back_color` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `course_chapters` ADD `back_color` VARCHAR(255) NULL DEFAULT NULL AFTER `chapter_desc`;