-- <?php exit;?>

REPLACE INTO `p8_crontab_` VALUES ('1','清除SESSION','clear_session.php','1','1521972000','1521930054','0','0','0','12','0');
REPLACE INTO `p8_crontab_` VALUES ('2','清除过期角色','expired_buy_role.php','1','1521993600','1521915927','1','0','0','0','0');
REPLACE INTO `p8_crontab_` VALUES ('3','定时静态PC版首页','cms_index_to_html.php','1','1521953220','1521952977','0','0','0','0','5');
REPLACE INTO `p8_crontab_` VALUES ('4','问答首页定时静态','ask_index_to_html.php','0','1503752400','0','0','0','0','3','0');
REPLACE INTO `p8_crontab_` VALUES ('5','定时静态移动版首页',' cms_index_to_html_mobile.php','1','1521953340','1521952475','0','0','0','0','15');
