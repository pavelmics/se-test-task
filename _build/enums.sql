
/* create parent */
INSERT INTO `enum` (`parent`, `name`, `sys_name`, `descr`)
  VALUES (NULL, 'Language Levels List', 'language_levels', 'List of language levels');

/* create a var @language_levels */
SELECT `id` INTO @language_levels FROM `enum` WHERE `sys_name` = 'language_levels';

/* childs */
INSERT INTO `enum` (`parent`, `name`, `sys_name`, `descr`)
  VALUES (@language_levels, 'A1', 'a1', 'A1');

INSERT INTO `enum` (`parent`, `name`, `sys_name`, `descr`)
  VALUES (@language_levels, 'A2', 'a2', 'A2');

INSERT INTO `enum` (`parent`, `name`, `sys_name`, `descr`)
  VALUES (@language_levels, 'B1', 'b1', 'B1');

INSERT INTO `enum` (`parent`, `name`, `sys_name`, `descr`)
  VALUES (@language_levels, 'B2', 'b2', 'B2');

INSERT INTO `enum` (`parent`, `name`, `sys_name`, `descr`)
  VALUES (@language_levels, 'C1', 'c1', 'C1');

INSERT INTO `enum` (`parent`, `name`, `sys_name`, `descr`)
  VALUES (@language_levels, 'C2', 'c2', 'C2');