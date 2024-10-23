DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE `chat_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `s_from` int(10) unsigned NOT NULL DEFAULT '0',
  `msg` text NOT NULL,
  `times` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_support` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `chat_options`;
CREATE TABLE `chat_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_online` int(10) unsigned NOT NULL,
  `support_name` varchar(50) NOT NULL,
  `support_email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


INSERT INTO `chat_options` (`id`,`is_online`,`support_name`,`support_email`) VALUES 
 (1,1,'Soporte Chat Live','support@chatlive.com.ar');


DROP TABLE IF EXISTS `chat_sessions`;
CREATE TABLE `chat_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(60) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
