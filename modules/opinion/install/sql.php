-- <?php exit;?>
CREATE TABLE `p8_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `endtime` int(10) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `view` int(10) unsigned NOT NULL default '0',
  `post` int(10) unsigned NOT NULL default '0',
  `captcha` tinyint(1) NOT NULL default '0',
  `status` smallint(3) NOT NULL default '0',
  `post_template` varchar(30) NOT NULL default '',
  `list_template` varchar(30) NOT NULL default '',
  `content` text NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `tel` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(50) NOT NULL DEFAULT '',
  `ip` varchar(30) NOT NULL DEFAULT '',
  `accept`  tinyint(1) NOT NULL DEFAULT 0,
  `accept_desc`  varchar(255) NOT NULL DEFAULT '',
  `up`  int(10) NOT NULL DEFAULT 0,
  `down`  int(10) NOT NULL DEFAULT 0,
  `timestamp` int(10) unsigned NOT NULL default '0',
  `status` smallint(3) NOT NULL default '0',
  `title` varchar(30) NOT NULL DEFAULT '',
  `content` text NOT NULL DEFAULT '',
  `email`  varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `iid` (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_comment` (
  `id` tinyint(10) NOT NULL AUTO_INCREMENT,
  `did` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL DEFAULT '',
  `timestamp` int(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `did` (`did`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

