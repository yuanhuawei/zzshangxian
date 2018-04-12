-- <?php exit;?>
CREATE TABLE `p8_` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(5) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL default '',
  `openid` char(32) NOT NULL DEFAULT '0',
  `access_token` varchar(30) NOT NULL DEFAULT '',
  `expires_in` int(11) NOT NULL DEFAULT '0',
  `nickname` varchar(30) NOT NULL DEFAULT '',
  `gender` char(2) NOT NULL DEFAULT '0',
  `vip` tinyint(1) NOT NULL DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `figureurl` varchar(255) NOT NULL DEFAULT '',
  `timestamp` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`),
  KEY openid (`openid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
