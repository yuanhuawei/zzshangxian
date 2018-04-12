-- <?php exit;?>
CREATE TABLE `p8_` (
  `id` int(11) NOT NULL auto_increment,
  `date` date NOT NULL default '0000-00-00',
  `date_time` tinyint(1) NOT NULL default '0',
  `level` varchar(20) NOT NULL default '0',
  `name` varchar(120) NOT NULL default '',
  `phone` varchar(50) NOT NULL,
  `event` varchar(255) NOT NULL default '',
  `list_order` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;




