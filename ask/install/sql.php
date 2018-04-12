-- <?php exit;?>
CREATE TABLE `p8_member` (
  `id` mediumint(8) unsigned NOT NULL,
  `username` char(30) NOT NULL default '',
  `role_id` tinyint(3) NOT NULL default '0',
  `verify` tinyint(1) NOT NULL default '1',
  `expert` tinyint(1) NOT NULL default '0',
  `star` tinyint(1) NOT NULL default '0',
  `item_count` mediumint(8) default '0',
  `solve_item_count` mediumint(8) default '0',
  `reply_count` mediumint(8) default '0',
  `fav_count` mediumint(8) default '0',
  `last_ask_time` int(10) unsigned NOT NULL default '0',
  `last_reply_time` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `role_id` (`role_id`),
  KEY `expert` (`expert`),
  KEY `star` (`star`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_expertors(
	`id` int(10) auto_increment,
	`cid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null,
	PRIMARY KEY(`id`),
	KEY `cid`(`cid`),
	KEY `uid`(`uid`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_statistics(
	`item_count` int(10) default '0',
	`solve_item_count` int(10) default '0'
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

insert into p8_statistics(`item_count`,`solve_item_count`) values('0','0');