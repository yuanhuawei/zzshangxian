-- <?php exit;?>

REPLACE INTO `p8_survey_data` VALUES ('1','1','0','','','','183.6.189.77','1444819209','0');
REPLACE INTO `p8_survey_item` VALUES ('1','234234','1483106355','1387720634','51','1','1','0','','','','<p>234234</p>');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','survey','string','dynamic_list_url_rule','{$module_controller}-list#-page-{$page}#.html');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','survey','string','dynamic_post_url_rule','{$module_controller}-post-id-{$id}.html');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','survey','string','dynamic_view_url_rule','{$module_controller}-view-id-{$id}.html');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','survey','string','template','');
REPLACE INTO `p8_config` (`system`,`module`,`type`,`k`,`v`)VALUES('core','survey','string','mobile_template','mobile/foolish');
