-- <?php exit;?>
CREATE TABLE p8_(
	`id` int(10) not null auto_increment,
	`tid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null default '0',
	`username` char(30) not null default '',
	`anonymous` tinyint(1) not null default '0',
	`verify` tinyint(1) not null default '1',
	`executor` tinyint(1) not null default '0',
	`bestanswer` tinyint(1) not null default '0',
	`vote_good` mediumint(5) not null default '0',
	`vote_bad` mediumint(5) not null default '0',
	`addtime` int(10) not null default '0',
	`ip` char(15) not null default '',
	KEY `tid`(`tid`),
	KEY `uid`(`uid`),
	KEY `verify`(`verify`),
	PRIMARY KEY(`id`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_data(
	`id` int(10) not null,
	`content` mediumtext,
	PRIMARY KEY(`id`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_votes(
	`id` int(10) not null auto_increment,
	`aid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null default '0',
	`ip` char(15) not null default '',
	`result` tinyint(1) not null default '0',
	KEY `aid`(`aid`),
	KEY `uid`(`uid`),
	PRIMARY KEY(`id`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_poller(
	`id` int(10) not null auto_increment,
	`aid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null default '0',
	`username` char(30) not null default '',
	`anonymous` tinyint(1) not null default '0',
	`ip` char(15) not null default '',
	`addtime` int(10) not null default '0',
	`handler` tinyint(1) not null default '0',
	`content` mediumtext,
	KEY `aid`(`aid`),
	KEY `uid`(`uid`),
	PRIMARY KEY(`id`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE p8_follow(
	`id` int(10) not null auto_increment,
	`tid` int(10) not null default '0',
	`aid` int(10) not null default '0',
	`uid` mediumint(8) unsigned not null default '0',
	`reply_uid` mediumint(8) unsigned not null default '0',
	`addtime` int(10) not null default '0',
	`reply_time` int(10) not null default '0',
	`content` mediumtext,
	`reply_content` mediumtext,
	KEY `tid`(`tid`),
	KEY `aid`(`aid`),
	KEY `uid`(`uid`),
	PRIMARY KEY(`id`)
)ENGINE = MyISAM DEFAULT CHARSET=gbk;
