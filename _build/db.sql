/* all the emums of app */
CREATE TABLE IF NOT EXISTS `enum` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  `parent` INT(11) NULL DEFAULT NULL,
  `name` CHAR(120) NOT NULL,
  `sys_name` CHAR(120) NOT NULL,
  `descr` TEXT NULL,

  PRIMARY KEY (`id`),

  /* actually it isn't working propertly anyway becouse of null != null */
  UNIQUE INDEX `unique_parent_sys_name` (`parent`, `sys_name`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* teachers */
CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME,
  `updated_at` DATETIME,

  `name` varchar(50) NOT NULL,
  `sex` INT(3) NOT NULL,
  `phone` varchar(20), /* в разных странах номера разной длинны */

  PRIMARY KEY (`id`),

  CONSTRAINT `uq_phone` UNIQUE (`phone`)
);

/*students*/
CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  `name` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `birth_date` DATE,
  `level_id` INT(11) NOT NULL,

  PRIMARY KEY (`id`),

  CONSTRAINT `uq_email` UNIQUE (`email`),

  CONSTRAINT `fk_student_level_id_to_enum` FOREIGN KEY (`level_id`)
    REFERENCES `enum` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

/*teacher_stutents*/
CREATE TABLE IF NOT EXISTS teacher_student (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  `teacher_id` INT(11) NOT NULL,
  `student_id` INT(11) NOT NULL,

  PRIMARY KEY (`id`),

  CONSTRAINT `fk_teacher_id_to_teachers` FOREIGN KEY (`teacher_id`)
    REFERENCES `teachers` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,

  CONSTRAINT `fk_student_id_to_students` FOREIGN KEY (`student_id`)
    REFERENCES `students` (`id`) ON UPDATE CASCADE ON DELETE CASCADE,

  CONSTRAINT `uq_teacher_student` UNIQUE (`teacher_id`, `student_id`)
);
