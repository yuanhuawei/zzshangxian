-- <?php exit;?>
CREATE TABLE `p8_attachment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `module` char(50) NOT NULL default '',
  `item_id` int(10) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `filename` char(100) NOT NULL default '',
  `type` char(50) NOT NULL default '',
  `ext` char(5) NOT NULL default '',
  `size` mediumint(8) unsigned NOT NULL default '0',
  `ip` char(15) NOT NULL default '',
  `path` char(60) NOT NULL default '',
  `thumb` tinyint(1) unsigned NOT NULL default '0',
  `remote` tinyint(1) unsigned NOT NULL default '0',
  `timestamp` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`, `uid`),
  KEY `module` (`module`,`timestamp`),
  KEY `uid` (`uid`,`timestamp`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk
/*!50100 PARTITION BY HASH (uid)
PARTITIONS 10 */;