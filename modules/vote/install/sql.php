-- <?php exit;?>

CREATE TABLE `p8_` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `frame` varchar(255) NOT NULL default '',
  `template` varchar(40) NOT NULL,
  `label_template` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL default '0',
  `multi` tinyint(3) unsigned NOT NULL default '0',
  `page_size` tinyint(3) unsigned NOT NULL default '0',
  `roles` varchar(255) NOT NULL default '',
  `viewable` tinyint(1) unsigned NOT NULL default '0',
  `vote_to_view` tinyint(1) unsigned NOT NULL default '0',
  `view_voter` tinyint(1) unsigned NOT NULL default '0',
  `vote_interval` smallint(5) unsigned NOT NULL default '0',
  `votes` mediumint(8) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `expire` int(10) unsigned NOT NULL default '0',
  `captcha`  tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_option` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vid` int(10) unsigned NOT NULL,
  `name` varchar(40) NOT NULL default '',
  `description` varchar(100) NOT NULL default '',
  `frame` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `display_order` int(10) unsigned NOT NULL default '0',
  `votes` mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `vid` (`vid`,`display_order`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_voter` (
  `vid` int(10) unsigned NOT NULL,
  `oid` int(10) unsigned NOT NULL,
  `uid` char(15) NOT NULL default '',
  `username` char(20) NOT NULL default '',
  `timestamp` int(10) unsigned NOT NULL,
  KEY `oid` (`oid`,`timestamp`),
  KEY `vid` (`vid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk
/*!50100 PARTITION BY HASH (vid)
PARTITIONS 10 */;