CREATE DATABASE `links`;
USE links;

CREATE TABLE IF NOT EXISTS `link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(256) DEFAULT NULL,
  `title` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

CREATE USER 'test_user'@'localhost' IDENTIFIED BY 'test_user_pw';
GRANT ALL ON `links`.* TO 'test_user'@'localhost';