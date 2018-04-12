-- <?php exit;?>

CREATE TABLE `p8_member` (
  `iid` int(10) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `model` char(20) NOT NULL default '',
  `verified` tinyint(1) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`iid`),
  KEY `uid` (`uid`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_member_collection` (
  `iid` int(10) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`iid`, `uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_search` (
  `id` int(10) unsigned NOT NULL,
  `search` mediumtext NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`/*!50100 ,`timestamp`*/)
) ENGINE=MyISAM DEFAULT CHARSET=gbk
/*!50100 PARTITION BY RANGE (timestamp)
(PARTITION p0 VALUES LESS THAN (0)) */;

CREATE TABLE `p8_attribute` (
  `id` int(10) unsigned NOT NULL,
  `aid` tinyint(3) unsigned NOT NULL,
  `cid` mediumint(8) unsigned NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  `last_setter` char(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`,`id`),
  KEY `id` (`id`),
  KEY `aid` (`aid`,`timestamp`),
  KEY `cid` (`aid`,`cid`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_comment_id` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_comment` (
  `id` bigint(20) unsigned NOT NULL,
  `iid` int(10) unsigned NOT NULL,
  `mid` smallint(5) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `quote` text NOT NULL,
  `content` text NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  `ip` char(15) NOT NULL default '',
  `digg` smallint(5) unsigned NOT NULL default '0',
  `oppose` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `iid` (`iid`,`timestamp`),
  KEY `digg` (`iid`,`digg`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_comment_unverified` (
  `id` bigint(20) unsigned NOT NULL,
  `iid` int(10) unsigned NOT NULL,
  `mid` smallint(2) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL,
  `quote` text NOT NULL,
  `content` text NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  `ip` char(15) NOT NULL default '',
  `digg` smallint(5) unsigned NOT NULL default '0',
  `oppose` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `iid` (`iid`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_mood` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `name` char(20) NOT NULL default '',
  `image` char(20) NOT NULL default '',
  `display_order` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

INSERT INTO `p8_mood` VALUES (1,'Ç·±â','1.gif',99);
INSERT INTO `p8_mood` VALUES (2,'Ö§³Ö','2.gif',88);
INSERT INTO `p8_mood` VALUES (3,'ºÜ°ô','3.gif',77);
INSERT INTO `p8_mood` VALUES (4,'ÕÒÂî','4.gif',66);
INSERT INTO `p8_mood` VALUES (5,'¸ãÐ¦','5.gif',55);
INSERT INTO `p8_mood` VALUES (6,'ÈíÎÄ','6.gif',44);
INSERT INTO `p8_mood` VALUES (7,'²»½â','7.gif',1);
INSERT INTO `p8_mood` VALUES (8,'³Ô¾ª','8.gif',1);

CREATE TABLE `p8_mood_data` (
  `iid` int(10) unsigned NOT NULL,
  `m1` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `m2` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `m3` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `m4` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `m5` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `m6` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `m7` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `m8` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_digg` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `iid` int(10) unsigned NOT NULL,
  `digg` mediumint(8) NOT NULL default '0',
  `trample` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `aid` (`iid`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk;

CREATE TABLE `p8_pay` (
  `iid` int(10) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `timestamp` int(8) NOT NULL,
  PRIMARY KEY (`iid`,`uid`),
  KEY `uid` (`uid`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_tag` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `item_count` mediumint(8) unsigned NOT NULL default '0',
  `hot` tinyint(1) unsigned NOT NULL default '0',
  `display_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_tag_item` (
  `tid` smallint(5) unsigned NOT NULL,
  `iid` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`tid`,`iid`),
  KEY (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
