-- <?php exit;?>

CREATE TABLE `p8_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent` smallint(5) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `frame` varchar(255) NOT NULL DEFAULT '',
  `item_count` mediumint(8) unsigned NOT NULL,
  `display_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `cid` mediumint(8) unsigned NOT NULL default '0',
  `title` varchar(80) NOT NULL default '',
  `frame` varchar(100) NOT NULL default '',
  `ifcomment` int(1) NOT NULL default '0',
  `template` char(255) NOT NULL default '',
  `html_view_url_rule` varchar(100) NOT NULL default '',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `banner` varchar(100) NOT NULL default '',
  `seo_keywords` VARCHAR( 100 ) NOT NULL,
  `navigation` text NOT NULL,
  `count` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `cid` (`cid`,`timestamp`)
) ENGINE=MyISAM;