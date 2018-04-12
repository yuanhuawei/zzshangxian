-- <?php exit;?>

CREATE TABLE `p8_` (
  `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `expense_type` varchar(20) NOT NULL DEFAULT '',
  `link_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `buyable` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `buy_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `credit_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `credit` smallint(5) unsigned NOT NULL DEFAULT '0',
  `width` varchar(10) NOT NULL DEFAULT '',
  `height` varchar(10) NOT NULL DEFAULT '',
  `template` varchar(50) NOT NULL DEFAULT '',
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `show_count` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `verify` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `max_day` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `buyable` (`buyable`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_buy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL DEFAULT '0',
  `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `showing` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `credit` smallint(5) unsigned NOT NULL DEFAULT '0',
  `day` smallint(5) unsigned NOT NULL DEFAULT '0',
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `clicks` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `postfix` varchar(60) NOT NULL DEFAULT '',
  `comment` varchar(60) NOT NULL DEFAULT '',
  `display_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  `data` text NOT NULL,
  `expire` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY (`aid`,`display_order`,`timestamp`),
  KEY (`aid`,`showing`,`verified`,`postfix`,`expire`),
  KEY (`uid`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_click_log` (
  `bid` int(10) unsigned NOT NULL,
  `ip` char(15) NOT NULL DEFAULT '',
  `timestamp` int(10) unsigned NOT NULL,
  `referer` char(120) NOT NULL default '',
  KEY `bid` (`bid`,`timestamp`),
  KEY `bid_ip` (`bid`,`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;