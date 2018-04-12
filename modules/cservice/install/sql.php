-- <?php exit;?>
CREATE TABLE `p8_` (
 `id` int(11) NOT NULL auto_increment,
  `num` bigint(14) NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `mobilephone` varchar(16) NOT NULL default '0',
  `ip` varchar(20) NOT NULL default '',
  `site` varchar(100) NOT NULL default '',
  `title` varchar(60) NOT NULL default '',
  `priority` int(1) NOT NULL default '0',
  `category` varchar(30) NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0',
  `solvetime` int(11) NOT NULL default '0',
  `adminuid` int(11) NOT NULL default '0',
  `adminname` varchar(30) NOT NULL,
  `state` int(1) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
CREATE TABLE `p8_reply` (
 `id` int(11) NOT NULL auto_increment,
  `askid` int(11) NOT NULL default '0',
  `repid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `username` varchar(30) NOT NULL default '',
  `title` varchar(60) NOT NULL default '',
  `frame` varchar(255) NOT NULL default '',
  `timestamp` int(11) NOT NULL default '0',
  `state` int(1) NOT NULL default '0',
  `content` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;