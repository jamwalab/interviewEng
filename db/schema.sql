ALTER DATABASE university
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE university;

-- ----------------------------
-- Table structure for domains
-- ----------------------------
DROP TABLE IF EXISTS `domains`;
CREATE TABLE `domains` (
                           `id` int(255) NOT NULL AUTO_INCREMENT,
                           `id_university` int(255) DEFAULT NULL,
                           `domain_name` varchar(255) DEFAULT NULL,
                           PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for universities
-- ----------------------------
DROP TABLE IF EXISTS `universities`;
CREATE TABLE `universities` (
                                `id` int(255) NOT NULL AUTO_INCREMENT,
                                `country` varchar(255) DEFAULT NULL,
                                `alpha_two_code` varchar(255) DEFAULT NULL,
                                `name` varchar(255) DEFAULT NULL,
                                `state-province` varchar(255) DEFAULT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for web_pages
-- ----------------------------
DROP TABLE IF EXISTS `web_pages`;
CREATE TABLE `web_pages` (
                             `id` int(255) NOT NULL AUTO_INCREMENT,
                             `id_university` int(255) NOT NULL,
                             `url` varchar(2083) NOT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;