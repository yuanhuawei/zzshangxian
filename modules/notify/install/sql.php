-- <?php exit;?>

CREATE TABLE `p8_` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT '',
  `send_pm` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `send_mail` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `send_sms` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sms_back` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `data` mediumtext NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `send_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sign_in_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `expire` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

CREATE TABLE `p8_sign_in` (
  `nid` int(10) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `hash` char(16) NOT NULL DEFAULT '',
  `comment` char(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `timestamp` int(10) unsigned NOT NULL,
  `receive` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nid`,`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;