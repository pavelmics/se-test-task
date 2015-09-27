#!/bin/sh

mysql -u root -p$1 -Bse "
    CREATE DATABASE IF NOT EXISTS skyeng CHARACTER SET utf8 COLLATE utf8_general_ci;
    CREATE USER 'skyeng'@'localhost' IDENTIFIED BY 'skyeng';
    GRANT ALL PRIVILEGES ON skyeng.* TO 'skyeng'@'localhost';
    USE skyeng;
    SOURCE ./_build/db.sql;
    SOURCE ./_build/enums.sql;
"