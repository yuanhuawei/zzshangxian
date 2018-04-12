-- <?php exit;?>
CREATE TABLE `p8_item` (
	`id` int(11) NOT NULL auto_increment,
	`department` smallint(5) NOT NULL,
	`type` tinyint(3) NOT NULL,
	`visual` tinyint(1) NOT NULL default '0',
	`undisplay`  tinyint(1) NOT NULL DEFAULT '0',
	`number` varchar(20) NOT NULL,
	`uid` int(11) NOT NULL default '0',
	`username` varchar(30) NOT NULL default '',
	`code` char(32) NOT NULL default '',
	`gender` tinyint(1) NOT NULL default '0',
	`age` tinyint(3)  NOT NULL default '0',
	`phone` varchar(16) NOT NULL default '',
	`ip` varchar(20) NOT NULL default '',
	`email` varchar(100) NOT NULL default '',
	`id_type` tinyint(2) NOT NULL default '0',
	`id_num` varchar(30) NOT NULL default '',
	`source` tinyint(1) NOT NULL default '0',
	`profession` varchar(30) NOT NULL default '',
	`education` varchar(30) NOT NULL default '',
	`address`  varchar(100) NOT NULL default '',
	`title` varchar(60) NOT NULL default '',
	`create_time` int(11) NOT NULL default '0',
	`update_time` int(11) NOT NULL default '0',
	`status` tinyint(1) NOT NULL default '0',
	`status_change_time` int(11) NOT NULL default '0',
	`askable` tinyint(1) NOT NULL default '0',
	`log` text NOT NULL,
	`solve_time` int(11) NOT NULL default '0',
	`solve_uid` int(11) NOT NULL default '0',
	`solve_department` int(11) NOT NULL default '0',
	`solve_name` varchar(30) NOT NULL,
	`comment` int(1) NOT NULL default '0',
	`comment_time` int(11) NOT NULL default '0',
	`finish_time` int(11) NOT NULL default '0',
	`finish_name`  varchar(30) NOT NULL default '',
	`fengfa` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `create_time` (`create_time`),
  KEY `department` (`department`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_data` (
	`id` int(11) NOT NULL auto_increment,
	`item_id` int(11) NOT NULL default '0',
	`level` tinyint(1) NOT NULL default '0',
	`attachment_name` varchar(30) NOT NULL default '',
	`attachment` varchar(255) NOT NULL default '',
	`add_time` int(11) NOT NULL default '0',
	`content` text NOT NULL,
	`reply_uid` int(11) NOT NULL default '0',
	`reply_name` varchar(30) NOT NULL,
	`reply_department` smallint(5) NOT NULL,
	`reply_time` int(11) NOT NULL,
	`reply` text NOT NULL,
	`turntig` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_cat` (
`id` int(11) NOT NULL auto_increment,
`type` tinyint(1) NOT NULL default '0',
`name` varchar(30) NOT NULL default '',
`num` int(11) NOT NULL default '0',
PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_department` (
`id` int(11) NOT NULL auto_increment,
`pid` int(11) NOT NULL default '0',
`name` varchar(30) NOT NULL default '',
`num` int(11) NOT NULL default '0',
`desc` varchar(255) NOT NULL default '',
PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;