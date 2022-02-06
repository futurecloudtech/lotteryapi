CREATE DATABASE `lotterydb` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

-- lotterydb.info definition

CREATE TABLE `info` (
  `key` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- lotterydb.invitecode definition

CREATE TABLE `invitecode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(256) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'F',
  `create_at` datetime DEFAULT current_timestamp(),
  `email` varchar(100) DEFAULT NULL,
  `update_at` datetime DEFAULT current_timestamp(),
  `prizeId` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`,`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

-- lotterydb.`member` definition

CREATE TABLE `member` (
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `role` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `phone_no` varchar(256) NOT NULL,
  `joined_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  `extra_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- lotterydb.prize definition

CREATE TABLE `prize` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `desc` varchar(1000) NOT NULL,
  `img` varchar(100) NOT NULL,
  `chance` decimal(10,0) NOT NULL,
  `is_deleted` char(1) NOT NULL DEFAULT 'F',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO `member`
(first_name, last_name, `role`, email, phone_no, joined_at, update_at, extra_id)
VALUES('Admin', 'Account', 'ADMIN', 'admin@gmail.com', '60195111128', '2022-01-29 19:19:34', '2022-01-29 19:19:34', '-');

INSERT INTO prize
(id, name, `desc`, img, chance, is_deleted)
VALUES(1, '1', 'TEST222', ' ', 10, 'T');
INSERT INTO prize
(id, name, `desc`, img, chance, is_deleted)
VALUES(2, '2', 'TEST', ' ', 20, 'F');
INSERT INTO prize
(id, name, `desc`, img, chance, is_deleted)
VALUES(3, '3', 'TEST', ' ', 10, 'F');
INSERT INTO prize
(id, name, `desc`, img, chance, is_deleted)
VALUES(4, '4', 'TEST', ' ', 10, 'F');
INSERT INTO prize
(id, name, `desc`, img, chance, is_deleted)
VALUES(5, '5', 'TEST', ' ', 5, 'F');
INSERT INTO prize
(id, name, `desc`, img, chance, is_deleted)
VALUES(6, '6', 'TEST', ' ', 5, 'F');
INSERT INTO prize
(id, name, `desc`, img, chance, is_deleted)
VALUES(7, '7', 'TEST', ' ', 5, 'F');

