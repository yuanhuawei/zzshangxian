-- <?php exit;?>

REPLACE INTO `p8_opinion_data` VALUES ('1','1','0','234324','','23432','113.119.163.215','0','','0','0','1380445007','0','432423','2342332423423423432','');
REPLACE INTO `p8_opinion_data` VALUES ('2','1','1','454545','','','183.48.65.148','1','34535','0','0','1399123957','1','','4545454456456456454564','');
REPLACE INTO `p8_opinion_data` VALUES ('3','1','1','23423423','','234234','121.8.204.243','0','','0','0','1378739124','0','23423','过去一周，中国各地大学迎来新生报到潮。前日是武汉华中师范大学新生入学首日，学校在该校体育馆内为新生家长们提供免费住宿。当晚有400多名学生家长在体育馆打地铺过夜。这是该校连续第8年在新生开学报到时为家长提供免费住宿。中国大学新生大部分都和家长一起到学校报到的。至于原因有多方面，但主要是家长不放心孩子第一次出门。为了安置这些家长，不少大学必须预订学校周围宾馆，并免费为他们准备帐篷或在校内打地铺。','');
REPLACE INTO `p8_opinion_data` VALUES ('4','1','1','42342','','234234','175.13.248.49','0','','0','0','1456762777','1','','2342323WERWERWEWEEWR','234234');
REPLACE INTO `p8_opinion_data` VALUES ('5','1','1','weew','','','175.13.250.244','0','','0','0','1458313000','1','','ssdfsdsdfsdfdsfsdfsdfssdfd','');
REPLACE INTO `p8_opinion_data` VALUES ('6','1','0','32424','','3432','175.13.250.244','0','','0','0','1458374905','1','','23423432似的犯得上反对的都是','2342');
REPLACE INTO `p8_opinion_item` VALUES ('1','测试意见征集模块2','1475139305','1380444892','231','5','0','0','','','<p>23423234</p>');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','opinion','string','dynamic_list_url_rule','{$module_controller}-list#-page-{$page}#.html');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','opinion','string','dynamic_post_url_rule','{$module_controller}-post-id-{$id}#-page-{$page}#.html');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','opinion','string','dynamic_view_url_rule','{$module_controller}-view-id-{$id}#-page-{$page}#.html');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','opinion','string','undisplay','0');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','opinion','string','template','');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','opinion','string','mobile_template','mobile/default');