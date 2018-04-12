-- <?php exit;?>

CREATE TABLE `p8_order` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `NO` varchar(25) NOT NULL default '',
  `interface_NO` varchar(25) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `seller_uid` mediumint(8) unsigned NOT NULL,
  `seller_username` varchar(20) NOT NULL default '',
  `buyer_uid` mediumint(8) unsigned NOT NULL,
  `buyer_username` varchar(20) NOT NULL default '',
  `interface` varchar(10) NOT NULL default '',
  `amount` decimal(10,2) unsigned NOT NULL,
  `number` smallint(5) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `paid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `notify` text NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `NO` (`NO`),
  KEY `seller_uid` (`seller_uid`,`timestamp`),
  KEY `buyer_uid` (`buyer_uid`,`timestamp`),
  KEY `status` (`status`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_order_lock` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `NO` char(20) NOT NULL default '',
  `update_status` tinyint(1) unsigned NOT NULL,
  `notify_status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `NO` (`NO`)
) ENGINE=MyISAM DEFAULT CHARSET=InnoDB;

CREATE TABLE `p8_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `order_NO` char(20) NOT NULL,
  `interface` char(15) NOT NULL default '',
  `payer_uid` mediumint(8) unsigned NOT NULL default 0,
  `payer_username` char(20) NOT NULL default '',
  `amount` decimal(10,2) unsigned NOT NULL,
  `timestamp` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_interface` (
  `name` char(15) NOT NULL,
  `alias` char(20) NOT NULL,
  `enabled` tinyint(1) unsigned NOT NULL default '0',
  `logo` char(15) NOT NULL default '',
  `config` text NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_member_interface` (
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `name` char(15) NOT NULL,
  `config` text NOT NULL,
  PRIMARY KEY  (`uid`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;