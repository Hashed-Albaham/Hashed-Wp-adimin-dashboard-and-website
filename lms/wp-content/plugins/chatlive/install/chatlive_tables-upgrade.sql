DROP TABLE IF EXISTS `chat_sounds`;
CREATE TABLE `chat_sounds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `in_use` tinyint(3) unsigned NOT NULL,
  `flag` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO `chat_sounds` (`id`,`name`,`in_use`,`flag`) VALUES 
 (1,'sessions-1.swf',0,0),
 (2,'sessions-2.swf',0,0),
 (3,'sessions-3.swf',0,0),
 (4,'sessions-4.swf',0,0),
 (5,'sessions-5.swf',0,0),
 (6,'sessions-6.swf',1,0),
 (7,'sessions-7.swf',0,0),
 (8,'sessions-8.swf',0,0),
 (9,'sessions-9.swf',0,0),
 (10,'sound-1.swf',0,1),
 (11,'sound-2.swf',0,1),
 (12,'sound-3.swf',0,1),
 (13,'sound-4.swf',0,1),
 (14,'sound-5.swf',0,1),
 (15,'sound-6.swf',1,1),
 (16,'sound-7.swf',0,1);
