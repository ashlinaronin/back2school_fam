-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'courses'
--
-- ---

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `course_name` VARCHAR(255) NULL DEFAULT NULL,
  `course_number` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Table 'students'
--
-- ---

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `student_name` VARCHAR(255) NULL DEFAULT NULL,
  `enrollment_date` DATE NULL DEFAULT NULL,
  `course_id` INTEGER NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ---
-- Foreign Keys
-- ---

ALTER TABLE `students` ADD FOREIGN KEY (course_id) REFERENCES `courses` (`id`);

-- ---
-- Table Properties
-- ---

-- ALTER TABLE `courses` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- ALTER TABLE `students` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Test Data
-- ---

-- INSERT INTO `courses` (`id`,`course_name`,`course_number`) VALUES
-- ('','','');
-- INSERT INTO `students` (`id`,`student_name`,`enrollment_date`,`course_id`) VALUES
-- ('','','','');
