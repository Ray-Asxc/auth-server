DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE `auth_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `last` datetime DEFAULT NULL,
  `dlip` varchar(15) DEFAULT NULL,
  `per_sq` int(1) NOT NULL DEFAULT '0',
  `per_db` int(1) NOT NULL DEFAULT '0',
  `per_set` int(1) NOT NULL DEFAULT '0',
  `citylist` varchar(200) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `auth_user`(`user`, `pass`, `per_sq`, `per_db`, `per_set`, `active`) VALUES
('admin', '123456', '1', '1', '1', '1');

DROP TABLE IF EXISTS `auth_daili`;
CREATE TABLE `auth_daili` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `last` datetime DEFAULT NULL,
  `dlip` varchar(15) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `citylist` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_site`;
CREATE TABLE `auth_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `authcode` varchar(100) DEFAULT NULL,
  `sign` varchar(20) DEFAULT NULL,
  `syskey` varchar(40) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `daili` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_block`;
create table `auth_block` (
  `url` varchar(150) NOT NULL,
  `authcode` varchar(100) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_log`;
CREATE TABLE `auth_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(150) DEFAULT NULL,
  `type` varchar(20) NULL,
  `date` datetime NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `data` text NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `auth_down`;
CREATE TABLE `auth_down` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NULL,
  `authcode` varchar(100) NULL,
  `sign` varchar(100) NULL,
  `ip` varchar(20) DEFAULT NULL,
  `date` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;