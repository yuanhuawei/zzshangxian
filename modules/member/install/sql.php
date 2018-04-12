-- <?php exit;?>

CREATE TABLE `p8_getpasswd` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `email` char(32) NOT NULL,
  `checkcode` char(32) NOT NULL default '',
  `createtime` long NOT NULL,
  `invalidlong` long NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_friend_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL,
  `name` char(20) NOT NULL default '',
  `members` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_friend` (
  `uid` mediumint(8) unsigned NOT NULL,
  `fuid` mediumint(8) unsigned NOT NULL,
  `cid` tinyint(3) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL,
  `description` char(50) NOT NULL default '',
  PRIMARY KEY  (`uid`,`fuid`),
  KEY  (`fuid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_friend_unverified` (
  `uid` mediumint(8) unsigned NOT NULL,
  `fuid` mediumint(8) unsigned NOT NULL default '0',
  `cid` tinyint(3) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `description` char(50) NOT NULL default '',
  PRIMARY KEY  (`uid`,`fuid`),
  KEY  (`fuid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_recharge` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_NO` char(25) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL DEFAULT '',
  `amount` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`order_NO`),
  KEY `uid` (`uid`,`timestamp`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_buy_role` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_NO` char(25) NOT NULL DEFAULT '',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL DEFAULT '',
  `role_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `amount` mediumint(5) unsigned NOT NULL DEFAULT '0',
  `time` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `expire` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY (`order_NO`),
  KEY `uid` (`uid`,`timestamp`),
  KEY `status` (`status`,`expire`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_recharge_card` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sn` varchar(20) NOT NULL default '',
  `credit_type` tinyint(3) unsigned NOT NULL default '0',
  `quantity` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL DEFAULT '',
  `occupied` tinyint(3) unsigned NOT NULL default '0',
  `used` tinyint(3) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `used_timestamp` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sn` (`sn`),
  KEY (`credit_type`),
  KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=1000000 DEFAULT CHARSET=gbk;

CREATE TABLE `p8_acl` (
  `system` varchar(30) NOT NULL default '',
  `module` varchar(50) NOT NULL default '',
  `user_id` smallint(5) unsigned NOT NULL default '0',
  `postfix` varchar(30) NOT NULL,
  `v` text NOT NULL,
  PRIMARY KEY  (`system`,`module`,`user_id`,`postfix`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;