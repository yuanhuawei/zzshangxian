-- <?php exit;?>
CREATE TABLE `p8_` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `script` varchar(50) NOT NULL default '',
  `status` tinyint(1) unsigned NOT NULL default '0',
  `next_run_time` int(10) unsigned NOT NULL default '0',
  `last_run_time` int(10) unsigned NOT NULL default '0',
  `day` mediumint(4) unsigned NOT NULL default '0',
  `week` tinyint(1) unsigned NOT NULL default '0',
  `month` tinyint(2) NOT NULL default '0',
  `hour` tinyint(2) unsigned NOT NULL default '0',
  `minute` tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY  (`script`),
  KEY `next_run_time` (`status`,`next_run_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk;