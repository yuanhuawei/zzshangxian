-- <?php exit;?>
CREATE TABLE `p8_` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent` smallint(5) unsigned NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `item_count` smallint(5) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `display_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_list` (
  `iid` mediumint(8) unsigned NOT NULL,
  `sid` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`sid`,`iid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;