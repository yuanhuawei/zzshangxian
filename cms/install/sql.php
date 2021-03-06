-- <?php exit;?>

CREATE TABLE `p8_item` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `model` varchar(20) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `title_color` varchar(7) NOT NULL default '',
  `title_bold` tinyint(1) NOT NULL default '0',
  `sub_title` varchar(120) NOT NULL DEFAULT '',
  `cid` mediumint(8) unsigned NOT NULL default '0',
  `frame` varchar(100) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `author` varchar(20) NOT NULL default '',
  `editer` varchar(20) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `attributes` varchar(40) NOT NULL default '',
  `summary` varchar(255) NOT NULL default '',
  `pages` smallint(5) unsigned NOT NULL default '1',
  `html_view_url_rule` varchar(80) NOT NULL default '',
  `views` mediumint(8) unsigned NOT NULL default '0',
  `comments` mediumint(8) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `create_time` int(10) unsigned NOT NULL default '0',
  `update_time` int(10) unsigned NOT NULL default '0',
  `list_order` int(10) unsigned NOT NULL default '0',
  `verified` tinyint(1) NOT NULL default '0',
  `verifier` varchar(50) NOT NULL default '',
  `verify_time` int(10) unsigned NOT NULL default '0',
  `ever_verified` tinyint(1) NOT NULL default '0',
  `allow_comment` tinyint(1) unsigned NOT NULL default '1',
  `allow_mood` tinyint(1) unsigned NOT NULL default '1',
  `credit` tinyint(3) unsigned NOT NULL default '0',
  `credit_type` smallint(5) unsigned NOT NULL default '0',
  `digg` mediumint(8) NOT NULL default '0',
  `trample` mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `cid` (`cid`,`list_order`),
  KEY `cid_id` (`cid`,`id`),
  KEY `timestamp` (`timestamp`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_item_unverified` (
  `id` int(10) unsigned NOT NULL,
  `model` varchar(20) NOT NULL default '',
  `title` varchar(100) NOT NULL default '',
  `cid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(20) NOT NULL default '',
  `attributes` varchar(40) NOT NULL default '',
  `pages` smallint(5) unsigned NOT NULL default '1',
  `views` mediumint(8) unsigned NOT NULL default '0',
  `comments` mediumint(8) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL,
  `verified` tinyint(1) NOT NULL default '0',
  `ever_verified` tinyint(1) NOT NULL default '0',
  `data` longtext NOT NULL,
  `push_back_reason` varchar(255) NOT NULL default '',
  `push_item_id`  int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY  (`uid`, `timestamp`),
  KEY `cid` (`cid`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent` smallint(5) unsigned NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `letter` varchar(2) NOT NULL DEFAULT '',
  `model` varchar(20) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  `frame` varchar(255) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL,
  `item_count` mediumint(8) unsigned NOT NULL,
  `htmlize` tinyint(1) unsigned NOT NULL,
  `html_list_url_rule` varchar(255) NOT NULL DEFAULT '',
  `html_list_url_rule_mobile` varchar(255) NOT NULL DEFAULT '',
  `html_view_url_rule` varchar(255) NOT NULL DEFAULT '',
  `html_view_url_rule_mobile` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `page_size` smallint(5) unsigned NOT NULL DEFAULT '20',
  `list_template` varchar(50) NOT NULL DEFAULT '',
  `list_template_mobile`  varchar(50) NOT NULL DEFAULT '',
  `view_template` varchar(50) NOT NULL DEFAULT '',
  `view_template_mobile`  varchar(50) NOT NULL DEFAULT '',
  `item_template` varchar(50) NOT NULL DEFAULT '',
  `item_template_mobile`  varchar(50) NOT NULL DEFAULT '',
  `display_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  `seo_keywords` text NOT NULL,
  `seo_description` text NOT NULL,
  `label_postfix` varchar(50) NOT NULL DEFAULT '',
  `need_password` tinyint(1) NOT NULL DEFAULT 0,
  `category_password` varchar(32) NOT NULL DEFAULT '',
  `list_all_model`  tinyint(1) NOT NULL DEFAULT 0,
  `config` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_member` (
  `id` mediumint(8) unsigned NOT NULL,
  `username` char(20) NOT NULL default '',
  `role_id` smallint(5) unsigned NOT NULL,
  `item_count` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_model` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `alias` char(30) NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `config` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_order` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `NO` varchar(25) NOT NULL default '',
  `interface_NO` varchar(25) NOT NULL default '',
  `name` varchar(40) NOT NULL default '',
  `subject` varchar(60) NOT NULL default '',
  `seller_uid` mediumint(8) unsigned NOT NULL,
  `seller_username` varchar(20) NOT NULL default '',
  `buyer_uid` mediumint(8) unsigned NOT NULL,
  `sid` mediumint(8) unsigned NOT NULL,
  `buyer_username` varchar(20) NOT NULL default '',
  `phone` varchar(30) NOT NULL default '',
  `email` varchar(60) NOT NULL default '',
  `address` varchar(100) NOT NULL default '',
  `interface` varchar(10) NOT NULL default '',
  `amount` decimal(10,2) unsigned NOT NULL,
  `number` smallint(5) unsigned NOT NULL,
  `ip` varchar(15) NOT NULL default '',
  `timestamp` int(10) unsigned NOT NULL default '0',
  `status` tinyint(1) NOT NULL,
  `paid` tinyint(1) unsigned NOT NULL default '0',
  `notify` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `NO` (`NO`),
  KEY `seller_uid` (`seller_uid`,`timestamp`),
  KEY `buyer_uid` (`buyer_uid`,`timestamp`),
  KEY `status` (`status`,`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk