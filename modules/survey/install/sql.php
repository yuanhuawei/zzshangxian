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
  `view_template` varchar(30) NOT NULL default '',
  `content` text NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_title` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(30) NOT NULL DEFAULT '',
  `display_order` tinyint(1) NOT NULL DEFAULT '0',
  `not_null` tinyint(1) NOT NULL DEFAULT '0',
  `other` tinyint(1) NOT NULL DEFAULT '0',
  `tittle` varchar(30) NOT NULL DEFAULT '',
  `config` text NOT NULL DEFAULT '',
  `data` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `iid` (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `tel` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(30) NOT NULL DEFAULT '',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `status` smallint(3) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `iid` (`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_addon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(10) unsigned NOT NULL DEFAULT '0',
  `tid` int(10) unsigned NOT NULL DEFAULT '0',
  `did` int(10) unsigned NOT NULL DEFAULT '0',
  `data` varchar(255) NOT NULL DEFAULT '',
  `other` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `iid` (`iid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
