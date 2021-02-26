CREATE DATABASE mediagallery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
use mediagallery;
CREATE TABLE `mediagallery`.`access` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `access` VARCHAR(500) NULL,
  `code` VARCHAR(500) NULL,  
  PRIMARY KEY (`id`));

