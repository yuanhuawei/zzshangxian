-- <?php exit;?>
CREATE TABLE p8_ (
	`id` int(10) not null auto_increment,
	`name` char(50) not null default '',
	`parent` int(10) default '0',
	`item_count` int(10) default '0',
	`display` tinyint(1) not null default '1',	
	`display_order` mediumint(5) default '0',	
	`perpage` mediumint(3) not null default '0',
	`title_bytes` mediumint(3) not null default '0',
	`keywords` char(100) not null default '',
	`description` char(200) not null default '',
	`url` char(100) not null default '',	
	`list_template` char(50) not null default '',
	`view_template` char(50) not null default '',
	`block_template` char(50) not null default '',	
	`announce` mediumtext,	
	PRIMARY KEY(`id`),
	KEY `display_order`(`display_order`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

