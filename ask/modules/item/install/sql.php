-- <?php exit;?>
CREATE TABLE p8_(
	`id` int(10) not null auto_increment,
	`cid` int(10) not null default '0',
	`title` char(80) not null default '',
	`sub_title` char(80) not null default '',
	`uid` mediumint(8) unsigned not null default '0',
	`username` char(30) not null default '',
	`to_uid` mediumint(8) unsigned not null default '0',
	`anonymous` tinyint not null default '0',
	`addtime` int(10) not null default '0',
	`ip` char(15) not null default '',
	`offercredit` tinyint(1) not null default '0',
	`credits` mediumint(5) not null default '0',
	`urgent` tinyint(1) not null default '0',
	`province_id` mediumint(5) not null default '0',
	`city_id` mediumint(5) not null default '0',
	`views` int(10) not null default '0',
	`keywords` varchar(100) NOT NULL default '',
	`replies` int(10) not null default '0',
	`lastpost` int(10) not null default '0',
	`lastpost_uid` mediumint(8) not null default '0',
	`lastposter` char(30) not null default '',
	`endtime` int(10) not null default '0',
	`status` tinyint(1) not null default '0',
	`solvetime` int(10) not null default '0',
	`verify` tinyint(1) not null default '1',
	`closed` tinyint(1) not null default '0',
	`recommend` tinyint(1) not null default '0',
	`display_order` tinyint(1) not null default '0',
	PRIMARY KEY(`id`),
	KEY `uid`(`uid`),
	KEY `to_uid`(`to_uid`),
	KEY `display_order`(`display_order`,`cid`,`lastpost`),
	KEY `verify`(`verify`,`urgent`,`closed`,`recommend`,`cid`,`province_id`,`city_id`,`addtime`,`lastpost`,`solvetime`)	
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_unverified(
	`id` int(10) not null,
	`cid` int(10) not null default '0',
	`title` char(80) not null default '',
	`uid` mediumint(8) unsigned not null default '0',
	`username` char(30) not null default '',
	`addtime` int(10) not null default '0',
	`views` int(10) not null default '0',
	`status` tinyint(1) not null default '0',
	`verify` tinyint(1) not null default '1',
	`closed` tinyint(1) not null default '0',
	`recommend` tinyint(1) not null default '0',
	`display_order` tinyint(1) not null default '0',
	`urgent` tinyint(1) not null default '0',
	`data` longtext not null,
	`push_back_reason` varchar(255) not null,
	PRIMARY KEY(`id`),
	KEY `cid` (`cid`,`addtime`)	
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_data(
	`id` int(10) not null default '0',
	`tel` char(15) not null default '',
	`info` char(32) not null default '',
	`content` mediumtext,
	`bestanswer` char(200) not null default '', 
	`bestanswer_id` int(10) not null default '0', 
	`bestanswer_uid` int(10) not null default '0', 
	`bestanswer_username` varchar(30) not null default '', 
	`bestanswer_time` int(10) not null default '0', 
	KEY `id`(`id`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_tags(
	`tagname` char(30) not null default '',
	`total` mediumint(5) not null default '0'
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_itemtags(
	`id` int(10) not null default '0',
	`tagname` char(30) not null default '',
	KEY `id`(`id`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_addition(
	`id` int(10) not null auto_increment,
	`tid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null default '0',
	`addtime` int(10) not null default '0',
	`content` mediumtext,
	PRIMARY KEY(`id`),
	KEY `tid`(`tid`),
	KEY `uid`(`uid`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;


CREATE TABLE p8_push(
	`id` int(10) auto_increment,
	`tid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null default '0',
	`push_uid` mediumint(8) unsigned not null default '0',
	`addtime` int(10) not null default '0',
	`status` tinyint(1) not null default '0',
	PRIMARY KEY(`id`),
	KEY `tid`(`tid`),
	KEY `uid`(`uid`),
	KEY `push_uid`(`push_uid`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_favorites(
	`id` int(10) not null auto_increment,
	`uid` mediumint(8) unsigned not null default '0',
	`tid` int(10) not null default '0',
	`addtime` int(10) not null default '0',
	PRIMARY KEY(`id`),
	KEY `tid`(`tid`),
	KEY `uid`(`uid`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_poller(
	`id` int(10) not null auto_increment,
	`tid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null default '0',
	`username` char(30) not null default '',
	`anonymous` tinyint(1) not null default '0',	
	`ip` char(15) not null default '',
	`addtime` int(10) not null default '0',
	`handler` tinyint(1) not null default '0',
	`content` mediumtext,
	PRIMARY KEY(`id`),
	KEY `tid`(`tid`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;
