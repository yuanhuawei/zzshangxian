-- <?php exit;?>

CREATE TABLE `p8_field` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `model` varchar(30) NOT NULL default '',
  `parent` mediumint(8) unsigned NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `alias` varchar(50) NOT NULL default '',
  `type` varchar(20) NOT NULL default '',
  `list_table` tinyint(1) NOT NULL default '0',
  `filterable` tinyint(1) NOT NULL default '0',
  `orderby` tinyint(1) NOT NULL default '0',
  `not_null` tinyint(1) unsigned NOT NULL,
  `length` varchar(10) NOT NULL default '',
  `is_unsigned` tinyint(1) unsigned NOT NULL,
  `editable` tinyint(1) unsigned NOT NULL default '1',
  `default_value` text NOT NULL,
  `data` text NOT NULL,
  `config` text NOT NULL,
  `widget` varchar(50) NOT NULL default '',
  `widget_addon_attr` varchar(255) NOT NULL default '',
  `display_order` tinyint(3) unsigned NOT NULL,
  `units` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`model`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
