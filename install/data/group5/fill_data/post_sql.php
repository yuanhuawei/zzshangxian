-- <?php exit;?>
REPLACE INTO `p8_credit` VALUES ('1','����','��','','0','100','0','0','a:0:{}');
REPLACE INTO `p8_credit` VALUES ('2','���','ö','','0','50','0','0','a:0:{}');
REPLACE INTO `p8_credit_member` VALUES ('1','1280','50');
REPLACE INTO `p8_credit_member` VALUES ('2','105','50');
REPLACE INTO `p8_credit_member` VALUES ('3','110','50');
REPLACE INTO `p8_credit_member` VALUES ('4','105','50');
REPLACE INTO `p8_credit_member` VALUES ('5','120','50');
REPLACE INTO `p8_credit_member` VALUES ('6','105','50');
REPLACE INTO `p8_credit_member` VALUES ('7','105','50');
REPLACE INTO `p8_credit_member` VALUES ('8','105','50');
REPLACE INTO `p8_credit_member` VALUES ('9','105','50');
REPLACE INTO `p8_credit_member` VALUES ('10','105','50');
REPLACE INTO `p8_credit_member` VALUES ('11','105','50');
REPLACE INTO `p8_credit_member` VALUES ('12','105','50');
REPLACE INTO `p8_credit_member` VALUES ('13','105','50');
REPLACE INTO `p8_credit_member` VALUES ('14','105','50');
REPLACE INTO `p8_credit_member` VALUES ('15','160','50');
REPLACE INTO `p8_credit_rule` VALUES ('1','core','member','login','0','1','5','','3','86400');
REPLACE INTO `p8_credit_rule_log_cache` VALUES ('1','1','1521953003','1');
REPLACE INTO `p8_credit_rule_log_cache` VALUES ('15','1','1521691957','1');
REPLACE INTO `p8_config` VALUES ('core','','string','lang','zh-cn');
REPLACE INTO `p8_config` VALUES ('core','','string','template','group5');
REPLACE INTO `p8_config` VALUES ('core','','string','credit','1');
REPLACE INTO `p8_config` VALUES ('core','','string','mysql_connect_type','mysql');
REPLACE INTO `p8_config` VALUES ('core','','string','mysql_charset','utf8');
REPLACE INTO `p8_config` VALUES ('core','','string','core_table_prefix','');
REPLACE INTO `p8_config` VALUES ('core','','string','encode_conv_func','iconv');
REPLACE INTO `p8_config` VALUES ('core','','string','page_charset','utf-8');
REPLACE INTO `p8_config` VALUES ('core','','string','next_crontab','1521953220');
REPLACE INTO `p8_config` VALUES ('core','','string','debug','0');
REPLACE INTO `p8_config` VALUES ('core','','string','ssi','');
REPLACE INTO `p8_config` VALUES ('core','','string','site_name','��΢���ŷ���----���ȵļ���վȺϵͳ');
REPLACE INTO `p8_config` VALUES ('core','','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','','string','member_template','member/default');
REPLACE INTO `p8_config` VALUES ('core','','string','template_dir','template/');
REPLACE INTO `p8_config` VALUES ('core','','string','admin_controller','admin.php');
REPLACE INTO `p8_config` VALUES ('core','','string','p8_key','eae383d01305296c716c4a16b54bc5ed');
REPLACE INTO `p8_config` VALUES ('core','','string','use_core_roles_only','1');
REPLACE INTO `p8_config` VALUES ('core','','string','CoreMenu','1');
REPLACE INTO `p8_config` VALUES ('core','','serialize','attachment','a:3:{s:7:\"confuse\";s:1:\"1\";s:4:\"path\";s:10:\"attachment\";s:6:\"remote\";a:1:{s:6:\"server\";a:1:{i:1;s:31:\"http://jt.php168.net/attachment\";}}}');
REPLACE INTO `p8_config` VALUES ('core','','string','index_system','cms');
REPLACE INTO `p8_config` VALUES ('core','','serialize','session_cross_domains','a:0:{}');
REPLACE INTO `p8_config` VALUES ('core','','string','homepage_template','homepage/default');
REPLACE INTO `p8_config` VALUES ('core','','string','sphinx_prefix','');
REPLACE INTO `p8_config` VALUES ('core','','serialize','memcache','a:6:{s:7:\"enabled\";i:0;s:4:\"host\";s:9:\"localhost\";s:4:\"port\";s:5:\"11211\";s:8:\"pconnect\";i:1;s:6:\"prefix\";s:5:\"Udzj_\";s:6:\"server\";a:1:{s:15:\"localhost:11211\";a:2:{s:4:\"host\";s:9:\"localhost\";s:4:\"port\";i:11211;}}}');
REPLACE INTO `p8_config` VALUES ('core','','string','cc_num','20');
REPLACE INTO `p8_config` VALUES ('core','','string','cc_time','30');
REPLACE INTO `p8_config` VALUES ('core','','string','site_open','1');
REPLACE INTO `p8_config` VALUES ('core','','string','version','school707');
REPLACE INTO `p8_config` VALUES ('core','','string','build','20170610');
REPLACE INTO `p8_config` VALUES ('core','','string','administrator_role_group','1');
REPLACE INTO `p8_config` VALUES ('core','','string','person_role_group','2');
REPLACE INTO `p8_config` VALUES ('core','','string','administrator_role','1');
REPLACE INTO `p8_config` VALUES ('core','','string','member_role','2');
REPLACE INTO `p8_config` VALUES ('core','','string','guest_role','3');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','register','a:5:{s:7:\"enabled\";s:1:\"1\";s:7:\"captcha\";s:1:\"0\";s:6:\"verify\";s:1:\"0\";s:5:\"title\";s:28:\"���ã���л����ע��{sitename}\";s:6:\"notice\";s:220:\"�𾴵�{username}:\r\n���Ѿ�ע���Ϊ{sitename}�Ļ�Ա�������ڷ�������ʱ�����ص��ط��ɷ��档\r\n�������ʲô���ʿ�����ϵ����Ա��Email: {adminemail}��\r\n����ʺ��ǣ�{username}\r\n�����ǣ�{password}\r\n�����Ʊ���\r\n\r\n{sitename}\r\n{time}\";}');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','safe','a:0:{}');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','administrators','a:3:{s:5:\"admin\";i:1;s:7:\"test111\";i:1;s:6:\"admin2\";i:1;}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','thumb','a:4:{s:7:\"enabled\";s:1:\"1\";s:5:\"width\";s:3:\"328\";s:6:\"height\";s:3:\"247\";s:7:\"quality\";s:2:\"75\";}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','cthumb','a:2:{s:5:\"width\";s:3:\"800\";s:6:\"height\";s:3:\"700\";}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','watermark','a:4:{s:7:\"enabled\";s:1:\"0\";s:4:\"file\";s:20:\"images/watermark.gif\";s:8:\"position\";s:1:\"3\";s:7:\"quality\";s:2:\"75\";}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','enables','a:4:{s:4:\"core\";a:16:{s:5:\"label\";b:1;s:7:\"message\";b:1;i:46;b:1;s:8:\"cservice\";b:1;s:5:\"forms\";b:1;s:10:\"friendlink\";b:1;s:6:\"notify\";b:1;s:4:\"page\";b:1;s:6:\"spider\";b:1;s:4:\"vote\";b:1;s:0:\"\";b:1;s:7:\"special\";b:1;s:6:\"letter\";b:1;s:9:\"interview\";b:1;s:6:\"survey\";b:1;s:7:\"opinion\";b:1;}s:3:\"cms\";a:2:{s:8:\"category\";b:1;s:4:\"item\";b:1;}s:3:\"ask\";a:2:{s:4:\"item\";b:1;s:6:\"answer\";b:1;}s:5:\"sites\";a:3:{s:8:\"category\";b:1;s:4:\"item\";b:1;s:6:\"letter\";b:1;}}');
REPLACE INTO `p8_config` VALUES ('core','pay','serialize','interfaces','a:4:{s:6:\"alipay\";a:4:{s:5:\"alias\";s:9:\"֧����\";s:4:\"logo\";s:10:\"alipay.gif\";s:7:\"enabled\";i:0;s:6:\"config\";a:0:{}}s:6:\"credit\";a:4:{s:5:\"alias\";s:26:\"����(��δ֧��)\";s:4:\"logo\";s:10:\"alipay.gif\";s:7:\"enabled\";i:0;s:6:\"config\";a:0:{}}s:7:\"offline\";a:4:{s:5:\"alias\";s:12:\"���¸���\";s:4:\"logo\";s:12:\"unionpay.gif\";s:7:\"enabled\";i:1;s:6:\"config\";a:1:{s:4:\"bank\";a:1:{i:0;a:4:{s:4:\"name\";s:18:\"�й���������\";s:7:\"account\";s:13:\"6222*********\";s:5:\"payee\";s:17:\"ĳ����(С��)\";s:4:\"logo\";s:8:\"icbc.gif\";}}}}s:6:\"tenpay\";a:4:{s:5:\"alias\";s:23:\"�Ƹ�ͨ(��δ֧��)\";s:4:\"logo\";s:10:\"tenpay.gif\";s:7:\"enabled\";i:0;s:6:\"config\";a:0:{}}}');
REPLACE INTO `p8_config` VALUES ('core','mail','string','send_type','smtp');
REPLACE INTO `p8_config` VALUES ('core','mail','string','CRLF','rn');
REPLACE INTO `p8_config` VALUES ('core','mail','string','server','smtp.163.com');
REPLACE INTO `p8_config` VALUES ('core','mail','string','port','25');
REPLACE INTO `p8_config` VALUES ('core','mail','string','email','xxx@163.com');
REPLACE INTO `p8_config` VALUES ('core','mail','string','password','***');
REPLACE INTO `p8_config` VALUES ('core','mail','string','logged','1');
REPLACE INTO `p8_config` VALUES ('core','cservice','serialize','cs_category','a:7:{s:17:\"0.461215112494369\";s:9:\"�ۺ����� \";s:18:\"0.5945602833545108\";s:8:\"ѧԺ����\";s:18:\"0.4329127157751459\";s:8:\"ѧԺͶ��\";i:30205;s:8:\"��ʦ����\";i:31098;s:12:\"������Ŀ����\";i:26387;s:8:\"�˲��Ƽ�\";i:97497;s:14:\"������ѯ�����\";}');
REPLACE INTO `p8_config` VALUES ('core','discuzx','serialize','db','a:7:{s:4:\"host\";s:9:\"localhost\";s:4:\"user\";s:4:\"user\";s:8:\"password\";s:0:\"\";s:4:\"port\";s:4:\"3306\";s:4:\"name\";s:7:\"discuzx\";s:7:\"charset\";s:3:\"gbk\";s:12:\"table_prefix\";s:4:\"pre_\";}');
REPLACE INTO `p8_config` VALUES ('core','discuzx','string','url','http://www.xxx.com');
REPLACE INTO `p8_config` VALUES ('core','discuzx','string','charset','gbk');
REPLACE INTO `p8_config` VALUES ('core','notify','serialize','status','a:3:{i:1;s:4:\"ȷ��\";i:2;s:4:\"ȡ��\";i:3;s:6:\"��ȷ��\";}');
REPLACE INTO `p8_config` VALUES ('core','opinion','string','dynamic_list_url_rule','{$module_controller}-list#-page-{$page}#.html');
REPLACE INTO `p8_config` VALUES ('core','opinion','string','dynamic_post_url_rule','{$module_controller}-post-id-{$id}#-page-{$page}#.html');
REPLACE INTO `p8_config` VALUES ('core','opinion','string','dynamic_view_url_rule','{$module_controller}-view-id-{$id}#-page-{$page}#.html');
REPLACE INTO `p8_config` VALUES ('core','opinion','string','undisplay','0');
REPLACE INTO `p8_config` VALUES ('core','opinion','string','template','group5');
REPLACE INTO `p8_config` VALUES ('core','sms','serialize','interfaces','a:0:{}');
REPLACE INTO `p8_config` VALUES ('core','special','string','htmlize','0');
REPLACE INTO `p8_config` VALUES ('core','special','string','dynamic_list_url_rule','{$module_controller}-list-category-{$id}#-page-{$page}#.html');
REPLACE INTO `p8_config` VALUES ('core','special','string','dynamic_view_url_rule','{$module_controller}-view-id-{$id}.shtml');
REPLACE INTO `p8_config` VALUES ('core','special','string','html_list_url_rule','{$system_url}/special/list_{$id}#-page-{$page}#html');
REPLACE INTO `p8_config` VALUES ('core','special','string','html_view_url_rule','{$system_url}/special/{$id}.html');
REPLACE INTO `p8_config` VALUES ('core','special','string','view_page_cache_ttl','0');
REPLACE INTO `p8_config` VALUES ('core','survey','string','dynamic_list_url_rule','{$module_controller}-list#-page-{$page}#.html');
REPLACE INTO `p8_config` VALUES ('core','survey','string','dynamic_post_url_rule','{$module_controller}-post-id-{$id}.html');
REPLACE INTO `p8_config` VALUES ('core','survey','string','dynamic_view_url_rule','{$module_controller}-view-id-{$id}.html');
REPLACE INTO `p8_config` VALUES ('core','uchome','serialize','db','a:7:{s:4:\"host\";s:9:\"localhost\";s:4:\"user\";s:4:\"user\";s:8:\"password\";s:0:\"\";s:4:\"port\";s:4:\"3306\";s:4:\"name\";s:6:\"uchome\";s:7:\"charset\";s:3:\"gbk\";s:12:\"table_prefix\";s:7:\"uchome_\";}');
REPLACE INTO `p8_config` VALUES ('core','uchome','string','url','http://www.xxx.com');
REPLACE INTO `p8_config` VALUES ('core','uchome','string','charset','gbk');
REPLACE INTO `p8_config` VALUES ('core','xspace','serialize','db','a:7:{s:4:\"host\";s:9:\"localhost\";s:4:\"user\";s:4:\"user\";s:8:\"password\";s:0:\"\";s:4:\"port\";s:4:\"3306\";s:4:\"name\";s:6:\"xspace\";s:7:\"charset\";s:3:\"gbk\";s:12:\"table_prefix\";s:5:\"supe_\";}');
REPLACE INTO `p8_config` VALUES ('core','xspace','string','url','http://www.xxx.com');
REPLACE INTO `p8_config` VALUES ('core','xspace','string','charset','gbk');
REPLACE INTO `p8_config` VALUES ('core','plugin_anv','string','id','10003');
REPLACE INTO `p8_config` VALUES ('core','plugin_anv','string','width','525');
REPLACE INTO `p8_config` VALUES ('core','plugin_anv','string','height','290');
REPLACE INTO `p8_config` VALUES ('core','plugin_qqconnect','string','appid','');
REPLACE INTO `p8_config` VALUES ('core','plugin_qqconnect','string','key','');
REPLACE INTO `p8_config` VALUES ('core','plugin_qqconnect','string','display','2');
REPLACE INTO `p8_config` VALUES ('core','','string','admin_email','');
REPLACE INTO `p8_config` VALUES ('core','','string','credit_common','1');
REPLACE INTO `p8_config` VALUES ('core','','string','credit_gold','2');
REPLACE INTO `p8_config` VALUES ('core','','serialize','credits','a:2:{i:1;a:5:{s:4:\"name\";s:6:\"����\";s:4:\"unit\";s:3:\"��\";s:11:\"is_unsigned\";s:1:\"0\";s:9:\"float_bit\";s:1:\"0\";s:3:\"roe\";a:0:{}}i:2;a:5:{s:4:\"name\";s:6:\"���\";s:4:\"unit\";s:3:\"ö\";s:11:\"is_unsigned\";s:1:\"0\";s:9:\"float_bit\";s:1:\"0\";s:3:\"roe\";a:0:{}}}');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','recharge','a:2:{s:11:\"credit_type\";s:1:\"2\";s:8:\"quantity\";a:6:{i:2;i:2;i:5;i:5;i:10;i:10;i:30;i:33;i:50;i:55;i:100;i:110;}}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','filter','a:20:{s:3:\"jpg\";i:2048000;s:3:\"gif\";i:2048000;s:3:\"png\";i:2048000;s:3:\"zip\";i:5120000;s:3:\"rar\";i:5120000;s:3:\"swf\";i:5120000;s:4:\"rmvb\";i:8388608;s:2:\"rm\";i:8388608;s:3:\"avi\";i:8388608;s:3:\"wmv\";i:8388608;s:3:\"flv\";i:8388608;s:4:\"docx\";i:5120000;s:3:\"csv\";i:8388608;s:3:\"xls\";i:8388608;s:3:\"mp3\";i:8388608;s:3:\"txt\";i:5120000;s:3:\"doc\";i:5120000;s:3:\"ppt\";i:5120000;s:4:\"xlsx\";i:5120000;s:3:\"mp4\";i:5120000;}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','role_filters','a:15:{s:0:\"\";a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:6:{s:3:\"jpg\";i:2560000;s:3:\"gif\";i:2560000;s:3:\"png\";i:2560000;s:3:\"zip\";i:2560000;s:3:\"rar\";i:2560000;s:3:\"swf\";i:2560000;}}i:1;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:17:{s:3:\"rar\";i:8192000;s:3:\"zip\";i:8192000;s:3:\"jpg\";i:8192000;s:3:\"png\";i:8192000;s:3:\"gif\";i:8192000;s:3:\"pdf\";i:8192000;s:3:\"doc\";i:8192000;s:4:\"docx\";i:8192000;s:3:\"xls\";i:8192000;s:4:\"xlsx\";i:8192000;s:3:\"ppt\";i:8192000;s:4:\"pptx\";i:8192000;s:3:\"flv\";i:8192000;s:3:\"mp4\";i:8192000;s:3:\"avi\";i:8192000;s:3:\"txt\";i:8192000;s:3:\"swf\";i:51200000;}}i:2;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:15:{s:3:\"doc\";i:5120000;s:4:\"docx\";i:5120000;s:3:\"xls\";i:5120000;s:4:\"xlsx\";i:5120000;s:3:\"ppt\";i:5120000;s:4:\"pptx\";i:5120000;s:3:\"jpg\";i:5120000;s:3:\"gif\";i:5120000;s:3:\"png\";i:5120000;s:3:\"flv\";i:5120000;s:3:\"mp4\";i:5120000;s:3:\"avi\";i:5120000;s:3:\"rar\";i:5120000;s:3:\"zip\";i:5120000;s:3:\"swf\";i:5120000;}}i:3;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:15:{s:3:\"doc\";i:5120000;s:4:\"docx\";i:5120000;s:3:\"xls\";i:5120000;s:4:\"xlsx\";i:5120000;s:3:\"ppt\";i:5120000;s:4:\"pptx\";i:5120000;s:3:\"jpg\";i:5120000;s:3:\"gif\";i:5120000;s:3:\"png\";i:5120000;s:3:\"flv\";i:5120000;s:3:\"mp4\";i:5120000;s:3:\"avi\";i:5120000;s:3:\"rar\";i:5120000;s:3:\"zip\";i:5120000;s:3:\"swf\";i:5120000;}}i:10;a:0:{}i:11;a:0:{}i:12;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:15:{s:3:\"doc\";i:5120000;s:4:\"docx\";i:5120000;s:3:\"xls\";i:5120000;s:4:\"xlsx\";i:5120000;s:3:\"ppt\";i:5120000;s:4:\"pptx\";i:5120000;s:3:\"jpg\";i:5120000;s:3:\"gif\";i:5120000;s:3:\"png\";i:5120000;s:3:\"flv\";i:5120000;s:3:\"mp4\";i:5120000;s:3:\"avi\";i:5120000;s:3:\"rar\";i:5120000;s:3:\"zip\";i:5120000;s:3:\"swf\";i:5120000;}}i:13;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:17:{s:3:\"rar\";i:8192000;s:3:\"zip\";i:8192000;s:3:\"jpg\";i:8192000;s:3:\"png\";i:8192000;s:3:\"gif\";i:8192000;s:3:\"pdf\";i:8192000;s:3:\"doc\";i:8192000;s:4:\"docx\";i:8192000;s:3:\"xls\";i:8192000;s:4:\"xlsx\";i:8192000;s:3:\"ppt\";i:8192000;s:4:\"pptx\";i:8192000;s:3:\"flv\";i:8192000;s:3:\"mp4\";i:8192000;s:3:\"avi\";i:8192000;s:3:\"txt\";i:8192000;s:3:\"csv\";i:8192000;}}i:14;a:0:{}i:26;a:0:{}i:5;a:0:{}i:6;a:0:{}i:4;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:15:{s:3:\"doc\";i:5120000;s:4:\"docx\";i:5120000;s:3:\"xls\";i:5120000;s:4:\"xlsx\";i:5120000;s:3:\"ppt\";i:5120000;s:4:\"pptx\";i:5120000;s:3:\"jpg\";i:5120000;s:3:\"gif\";i:5120000;s:3:\"png\";i:5120000;s:3:\"flv\";i:5120000;s:3:\"mp4\";i:5120000;s:3:\"avi\";i:5120000;s:3:\"rar\";i:5120000;s:3:\"zip\";i:5120000;s:3:\"swf\";i:5120000;}}i:15;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:15:{s:3:\"doc\";i:5120000;s:4:\"docx\";i:5120000;s:3:\"xls\";i:5120000;s:4:\"xlsx\";i:5120000;s:3:\"ppt\";i:5120000;s:4:\"pptx\";i:5120000;s:3:\"jpg\";i:5120000;s:3:\"gif\";i:5120000;s:3:\"png\";i:5120000;s:3:\"flv\";i:5120000;s:3:\"mp4\";i:5120000;s:3:\"avi\";i:5120000;s:3:\"rar\";i:5120000;s:3:\"zip\";i:5120000;s:3:\"swf\";i:5120000;}}i:16;a:2:{s:7:\"enabled\";b:1;s:6:\"filter\";a:15:{s:3:\"doc\";i:5120000;s:4:\"docx\";i:5120000;s:3:\"xls\";i:5120000;s:4:\"xlsx\";i:5120000;s:3:\"ppt\";i:5120000;s:4:\"pptx\";i:5120000;s:3:\"jpg\";i:5120000;s:3:\"gif\";i:5120000;s:3:\"png\";i:5120000;s:3:\"flv\";i:5120000;s:3:\"mp4\";i:5120000;s:3:\"avi\";i:5120000;s:3:\"rar\";i:5120000;s:3:\"zip\";i:5120000;s:3:\"swf\";i:5120000;}}}');
REPLACE INTO `p8_config` VALUES ('core','uploader','string','core_table_prefix','');
REPLACE INTO `p8_config` VALUES ('core','member','string','template','');
REPLACE INTO `p8_config` VALUES ('core','member','string','integration_type','');
REPLACE INTO `p8_config` VALUES ('core','member','string','integration_sync_id','1');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','uc','a:12:{s:7:\"connect\";s:5:\"mysql\";s:7:\"db_host\";s:9:\"localhost\";s:7:\"db_user\";s:0:\"\";s:11:\"db_password\";s:0:\"\";s:7:\"db_name\";s:7:\"ucenter\";s:10:\"db_charset\";s:3:\"gbk\";s:15:\"db_table_prefix\";s:11:\"ucenter.uc_\";s:3:\"key\";s:0:\"\";s:3:\"api\";s:19:\"http://127.0.0.1/uc\";s:2:\"ip\";s:0:\"\";s:7:\"charset\";s:3:\"gbk\";s:5:\"appid\";s:0:\"\";}');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','php168_config','a:4:{s:6:\"p8_key\";s:0:\"\";s:3:\"api\";s:29:\"http://www.***.com/api/p8.php\";s:2:\"ip\";s:0:\"\";s:7:\"charset\";s:0:\"\";}');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','pw','a:2:{s:3:\"api\";s:17:\"http://bbs.**.com\";s:4:\"code\";s:6:\"php168\";}');
REPLACE INTO `p8_config` VALUES ('core','member','string','reg_disallow_username','');
REPLACE INTO `p8_config` VALUES ('core','member','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','uploader','string','template','');
REPLACE INTO `p8_config` VALUES ('core','uploader','string','domain','');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','ftp_config','a:8:{s:7:\"enabled\";s:1:\"0\";s:4:\"host\";s:9:\"localhost\";s:4:\"port\";s:2:\"21\";s:4:\"user\";s:4:\"user\";s:8:\"password\";s:8:\"password\";s:3:\"dir\";s:1:\"/\";s:3:\"ssl\";s:1:\"0\";s:7:\"timeout\";s:0:\"\";}');
REPLACE INTO `p8_config` VALUES ('core','uploader','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','cservice','string','template','');
REPLACE INTO `p8_config` VALUES ('core','cservice','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','forms','string','template','group5');
REPLACE INTO `p8_config` VALUES ('core','forms','string','close','0');
REPLACE INTO `p8_config` VALUES ('core','forms','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','template','');
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','name','���Ա�');
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','ifCloseGuestBook','0');
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','captcha','1');
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','anonymous','1');
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','GuestBookList','10');
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','interview','string','template','');
REPLACE INTO `p8_config` VALUES ('core','interview','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','letter','string','template','group5');
REPLACE INTO `p8_config` VALUES ('core','letter','string','redepartment','');
REPLACE INTO `p8_config` VALUES ('core','letter','string','receive','0');
REPLACE INTO `p8_config` VALUES ('core','letter','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','opinion','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','page','string','template','group5');
REPLACE INTO `p8_config` VALUES ('core','page','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','special','string','template','');
REPLACE INTO `p8_config` VALUES ('core','special','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','survey','string','template','group5');
REPLACE INTO `p8_config` VALUES ('core','survey','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','vote','string','template','');
REPLACE INTO `p8_config` VALUES ('core','vote','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','','string','copyright','��ϵ��ʽ: MSN: 88888@hotmail.com ����:setpoterheight QQ��888888888 �绰��020-8888888 ���棺020-88888888');
REPLACE INTO `p8_config` VALUES ('core','','string','copyright_domain','��ICP��05011111�� ');
REPLACE INTO `p8_config` VALUES ('core','','string','site_close_reason','��վ����ά����...');
REPLACE INTO `p8_config` VALUES ('core','','string','site_description','��΢��ҵ��CMSΪ�й����ȵĿ�ԴCMSƽ̨��רע�ṩýѧУ����ҵ���ּ�������վȺϵͳ���и߶�ƽ̨');
REPLACE INTO `p8_config` VALUES ('core','','string','site_key_word','��΢CMS,��������,վȺ����,ѧУ����');
REPLACE INTO `p8_config` VALUES ('core','','string','ShowMenu','1');
REPLACE INTO `p8_config` VALUES ('core','','string','logo','');
REPLACE INTO `p8_config` VALUES ('core','','serialize','language','a:1:{s:5:\"zh-cn\";s:6:\"����\";}');
REPLACE INTO `p8_config` VALUES ('core','','serialize','templates','a:6:{s:7:\"default\";s:12:\"Ĭ�Ϸ��\";s:6:\"group1\";s:7:\"group01\";s:6:\"group2\";s:6:\"group2\";s:6:\"group3\";s:6:\"group3\";s:6:\"group4\";s:6:\"group4\";s:6:\"group5\";s:7:\"group05\";}');
REPLACE INTO `p8_config` VALUES ('core','','serialize','mobile_templates','a:4:{s:7:\"default\";s:12:\"Ĭ�Ϸ��\";s:5:\"group\";s:12:\"���ŷ��\";s:6:\"school\";s:12:\"school���\";s:7:\"school2\";s:13:\"school2���\";}');
REPLACE INTO `p8_config` VALUES ('core','','serialize','member_templates','a:1:{s:7:\"default\";s:12:\"Ĭ�Ϸ��\";}');
REPLACE INTO `p8_config` VALUES ('core','','string','homepage_templates','');
REPLACE INTO `p8_config` VALUES ('core','','string','last_user_acl_cache','1520503416');
REPLACE INTO `p8_config` VALUES ('core','discuzx','string','template','');
REPLACE INTO `p8_config` VALUES ('core','mail','string','template','');
REPLACE INTO `p8_config` VALUES ('core','message','string','template','');
REPLACE INTO `p8_config` VALUES ('core','notify','string','template','');
REPLACE INTO `p8_config` VALUES ('core','pay','string','template','');
REPLACE INTO `p8_config` VALUES ('core','shortcutsms','string','template','');
REPLACE INTO `p8_config` VALUES ('core','sms','string','template','');
REPLACE INTO `p8_config` VALUES ('core','spider','string','template','');
REPLACE INTO `p8_config` VALUES ('core','uchome','string','template','');
REPLACE INTO `p8_config` VALUES ('core','xspace','string','template','');
REPLACE INTO `p8_config` VALUES ('core','','string','statistics','');
REPLACE INTO `p8_config` VALUES ('core','','string','admin_login_code','');
REPLACE INTO `p8_config` VALUES ('core','','string','admin_login_with_captcha','0');
REPLACE INTO `p8_config` VALUES ('core','','string','url_rewrite_enabled','0');
REPLACE INTO `p8_config` VALUES ('core','','string','gzip','0');
REPLACE INTO `p8_config` VALUES ('core','','string','resource_url','');
REPLACE INTO `p8_config` VALUES ('core','','string','templatecache','0');
REPLACE INTO `p8_config` VALUES ('core','','string','robot_log','0');
REPLACE INTO `p8_config` VALUES ('core','','string','hash_name','');
REPLACE INTO `p8_config` VALUES ('core','','string','expire','0');
REPLACE INTO `p8_config` VALUES ('core','discuzx','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','mail','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','message','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','notify','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','pay','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','shortcutsms','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','sms','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','spider','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','uchome','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','xspace','string','mobile_template','mobile/group');
REPLACE INTO `p8_config` VALUES ('core','','string','last_last_label_cache','1521618599');
REPLACE INTO `p8_config` VALUES ('core','','string','enable_mobile','1');
REPLACE INTO `p8_config` VALUES ('core','','string','mobile_auto_jump','1');
REPLACE INTO `p8_config` VALUES ('core','','string','mobile_logo','');
REPLACE INTO `p8_config` VALUES ('core','','string','2dimensional','');
TRUNCATE TABLE `p8_navigation_menu`;
REPLACE INTO `p8_navigation_menu` VALUES ('1','core','','','0','����','','','1','99');
REPLACE INTO `p8_navigation_menu` VALUES ('2','core','','','1','��ҳ','index.php','','0','99');
REPLACE INTO `p8_navigation_menu` VALUES ('3','core','','','1','���ڼ���','index.php/cms/item-list-category-781.shtml','','1','98');
REPLACE INTO `p8_navigation_menu` VALUES ('5','core','','','1','��������','index.php/cms/item-list-category-1.shtml','','1','86');
REPLACE INTO `p8_navigation_menu` VALUES ('17','core','','#81ca9d','3','���ż��','index.php/cms/item-list-category-781.shtml','','1','30');
REPLACE INTO `p8_navigation_menu` VALUES ('19','core','','','3','��չ����','index.php/cms/item-list-category-780.shtml','','1','20');
REPLACE INTO `p8_navigation_menu` VALUES ('20','core','','','3','�쵼����','index.php/cms/item-list-category-779.shtml','','1','25');
REPLACE INTO `p8_navigation_menu` VALUES ('21','core','','','3','���³��´�','index.php/cms/item-list-category-810.shtml','','1','28');
REPLACE INTO `p8_navigation_menu` VALUES ('23','core','','','1','��Ʒ����','index.php/cms/item-list-category-67.shtml','','1','88');
REPLACE INTO `p8_navigation_menu` VALUES ('27','core','','','5','ר��','index.php/cms/item-list-category-44.shtml','','1','20');
REPLACE INTO `p8_navigation_menu` VALUES ('101','core','','','100','�Զ����������','index.php/cms/item-list-category-68.html','','1','6');
REPLACE INTO `p8_navigation_menu` VALUES ('100','core','','','1','�������','index.php/cms/item-list-category-68.html','','1','90');
REPLACE INTO `p8_navigation_menu` VALUES ('95','core','','','1','��ϵ����','index.php/cms/item-list-category-819.shtml','','0','0');
REPLACE INTO `p8_navigation_menu` VALUES ('54','core','','','3','��ҵ�Ļ�','index.php/cms/item-list-category-777.shtml','','1','14');
REPLACE INTO `p8_navigation_menu` VALUES ('55','core','','','5','ý��۽�','index.php/cms/item-list-category-128.shtml','','1','25');
REPLACE INTO `p8_navigation_menu` VALUES ('76','core','','','23','��Ʒչʾ','index.php/cms/item-list-category-94.shtml','','1','6');
REPLACE INTO `p8_navigation_menu` VALUES ('78','core','','','23','������ҵ��','index.php/cms/item-list-category-93.shtml','','1','4');
REPLACE INTO `p8_navigation_menu` VALUES ('79','core','','','23','���߲�Ʒչ��','index.php/cms/item-list-category-55.shtml','','1','8');
REPLACE INTO `p8_navigation_menu` VALUES ('81','core','','','23','�ͻ�����','index.php/cms/item-list-category-68.shtml','','1','2');
REPLACE INTO `p8_navigation_menu` VALUES ('90','core','','','5','��������','index.php/cms/item-list-category-34.shtml','','1','50');
REPLACE INTO `p8_navigation_menu` VALUES ('93','core','','','6','����ָ��','index.php/cms/item-list-category-183.shtml','','0','31');
REPLACE INTO `p8_navigation_menu` VALUES ('102','core','','','100','ϵͳ����������','index.php/cms/item-list-category-792.html','','1','1');
REPLACE INTO `p8_navigation_menu` VALUES ('112','core','','','95','��ϵ��ʽ','index.php/cms/item-list-category-820.shtml','','1','18');
REPLACE INTO `p8_navigation_menu` VALUES ('113','core','','','95','Ͷ�߽���','index.php/cms/item-list-category-74.shtml','','1','16');
REPLACE INTO `p8_navigation_menu` VALUES ('132','core','','','3','Ա�����','index.php/cms/item-list-category-812.shtml','','1','0');
REPLACE INTO `p8_navigation_menu` VALUES ('133','core','','','3','����չʾ','index.php/cms/item-list-category-778.shtml','','1','16');
REPLACE INTO `p8_navigation_menu` VALUES ('134','core','','','3','�����豸','index.php/cms/item-list-category-815.shtml','','1','18');
REPLACE INTO `p8_navigation_menu` VALUES ('118','core','','','23','�ͻ�����','index.php/cms/item-list-category-793.shtml','','1','0');
REPLACE INTO `p8_navigation_menu` VALUES ('119','core','','','23','��������','index.php/cms/item-list-category-792.shtml','','1','0');
REPLACE INTO `p8_navigation_menu` VALUES ('126','core','','','5','֪ͨ����','index.php/cms/item-list-category-809.shtml','','1','28');
REPLACE INTO `p8_navigation_menu` VALUES ('127','core','','','1','������Դ','index.php/cms/item-list-category-796.shtml','','1','77');
REPLACE INTO `p8_navigation_menu` VALUES ('128','core','','','127','�˲�����','index.php/cms/item-list-category-796.shtml','','1','8');
REPLACE INTO `p8_navigation_menu` VALUES ('129','core','','','127','��Ƹ��Ϣ','index.php/core/forms-list-mid-78','','1','4');
REPLACE INTO `p8_navigation_menu` VALUES ('130','core','','','127','��ҪӦƸ','index.php/cms/item-list-category-798.shtml','','1','2');
REPLACE INTO `p8_navigation_menu` VALUES ('131','core','','','1','���̺���','index.php/cms/item-list-category-818.shtml','','1','84');
TRUNCATE TABLE `p8_member_menu`;
REPLACE INTO `p8_member_acl` VALUES ('cms','','1','','a:0:{}');
REPLACE INTO `p8_member_acl` VALUES ('cms','item','1','','a:1:{s:7:\"actions\";a:11:{s:6:\"search\";b:0;s:4:\"list\";b:0;s:4:\"view\";b:0;s:7:\"comment\";b:0;s:3:\"add\";b:0;s:10:\"autoverify\";b:0;s:6:\"update\";b:0;s:6:\"delete\";b:0;s:6:\"verify\";b:1;s:9:\"attribute\";b:0;s:11:\"create_time\";b:0;}}');
REPLACE INTO `p8_member_menu` VALUES ('1','core','','main','0','','��Ա����','u.php/member-center','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('2','core','member','profile','1','','�ҵ�����','','','1','0','11');
REPLACE INTO `p8_member_menu` VALUES ('3','core','member','profile','2','','�޸Ļ�����Ϣ','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('4','core','member','','1','','֧��','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('5','core','member','recharge','4','','��ֵ','','_blank','1','1','0');
REPLACE INTO `p8_member_menu` VALUES ('6','core','member','recharge_log','4','','��ֵ��¼','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('7','core','message','','1','','վ����Ϣ','','','1','0','13');
REPLACE INTO `p8_member_menu` VALUES ('8','core','message','send','7','','����Ϣ','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('9','core','message','inbox','7','','����Ϣ����','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('10','core','message','outbox','7','','������','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('11','cms','','','1','','���ݹ���','','','1','0','15');
REPLACE INTO `p8_member_menu` VALUES ('12','cms','item','add','11','','��������','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('14','core','cservice','','1','','Ͷ�߽���','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('15','core','cservice','list','14','','Ͷ�߹���','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('16','core','cservice','post','14','','��ҪͶ��','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('17','core','forms','','1','','������','','','0','0','4');
REPLACE INTO `p8_member_menu` VALUES ('18','core','forms','intranetforms','17','','������','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('19','core','letter','','1','','�쵼����','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('20','core','letter','list','19','','��д���ż�','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('21','core','letter','post','19','','��Ҫд��','','_blank','1','1','0');
REPLACE INTO `p8_member_menu` VALUES ('22','core','letter','manager','19','','�������','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('23','core','notify','profile','1','','֪ͨͨѶ','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('24','core','notify','add','23','','д֪ͨ','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('25','core','notify','list','23','','֪ͨ����','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('26','ask','','','0','','�ʴ�ϵͳ','u.php/ask/item-my_ask','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('27','ask','item','','26','','�ҵ�����','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('28','ask','item','ask','27','','��Ҫ����','','_blank','1','1','0');
REPLACE INTO `p8_member_menu` VALUES ('29','ask','item','my_ask','27','','�ҵ�����','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('30','ask','item','my_favorite','27','','�ҵ��ղ�','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('31','ask','item','verify','27','','�ҹ��������','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('32','ask','answer','','26','','�ҵĻش�','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('33','ask','answer','my_answered','32','','�ҵĻش�','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('34','ask','answer','verify','32','','�ҹ���Ĵ�','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('35','cms','','','0','','���¹���','u.php/cms/item-my_list','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('36','cms','item','','35','','���ݹ���','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('38','cms','item','my_list','11','','�ҷ���������','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('39','cms','item','verify','11','','��ǩ�˵�����','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('40','cms','item','favory','11','','�ҵ������ղ�','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('41','cms','item','my_order','36','','�ҵĶ���','','','1','0','0');
TRUNCATE TABLE `p8_admin_menu`;
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(1, 'core', '', 'base_config', 0, 'ϵͳ����', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(2, 'core', '', '', 1, 'ϵͳ����', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(3, 'core', '', 'base_config', 2, '��������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(4, 'core', '', 'base_config', 3, '��������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(5, 'core', '', 'global_config', 3, 'ȫ������', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(6, 'core', '', 'reg_config', 3, 'ע������', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(7, 'core', '', 'system_list', 2, 'ϵͳ����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(8, 'core', '', 'module_list', 46, 'ģ�����', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(9, 'core', '', 'plugin_list', 46, '�������', '', '', 1, 0, 0, 66);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(10, 'core', '', '', 2, '����������', '', '', 0, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(11, 'core', '', 'phpinfo', 10, '�鿴php����', '', '', 1, 0, 0, 79);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(12, 'core', '', 'db_slave', 10, 'MYSQL �ӷ�����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(13, 'core', '', 'memcache', 2, 'memcache ����', '', '', 0, 0, 0, 44);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(14, 'core', '', 'memcache', 13, 'memcache ����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(15, 'core', '', 'memcached', 13, 'memcache ����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(16, 'core', '', 'cache', 2, 'ϵͳ����', '', '', 1, 0, 0, 44);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(17, 'core', '', 'log', 1, '������־', '', '', 1, 0, 0, 33);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(18, 'core', '', 'navigation_menu_list', 47, '�˵�����', '', '', 1, 0, 0, 85);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(19, 'core', '', 'navigation_menu_list', 18, 'ͷ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(20, 'core', '', 'navigation_menu_list', 19, 'ͷ����������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(21, 'core', '', 'navigation_menu_add', 19, '���ͷ������', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(22, 'core', '', '', 18, '��̨�˵�', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(23, 'core', '', 'menu_list', 22, '��̨�˵�����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(24, 'core', '', 'menu_add', 22, '��Ӻ�̨�˵�', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(25, 'core', '', '', 18, '��Ա���Ĳ˵�', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(26, 'core', '', 'member_menu_list', 25, '��Ա���Ĳ˵�����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(27, 'core', '', 'member_menu_add', 25, '��ӻ�Ա���Ĳ˵�', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(28, 'core', '', 'template_system', 47, 'ģ������', '', '', 1, 0, 0, 70);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(31, 'core', '', '', 28, '��Ա����ģ��', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(32, 'core', '', 'template_user_center', 31, '��Ա����ģ��', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(33, 'core', '', 'template_user_index', 31, '��Ա��ҳģ��', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(34, 'core', '', '', 28, '�ƶ�ģ��', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(35, 'core', '', 'template_mobile', 34, 'ϵͳģ��', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(36, 'core', 'label', 'list', 1, 'ϵͳ����', '', '', 1, 0, 0, 45);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(37, 'core', 'member', 'integrate', 36, 'ϵͳ����', '', '', 1, 0, 0, 93);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(38, 'core', '', 'area', 1, '��������', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(39, 'core', '', 'area', 38, '��������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(40, 'core', '', '', 1, '��ȫ����', '', '', 1, 0, 0, 75);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(41, 'core', '', 'stop_ip', 40, 'IP������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(42, 'core', '', 'allow_ip', 40, 'IP������', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(43, 'core', '', 'word_filter', 40, '�������', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(44, 'core', '', 'connection_flood', 40, '��ֹCC����', '', '', 1, 0, 0, 94);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(45, 'core', '', 'md5_files', 40, '�ļ��Ķ�ɨ��', '', '', 1, 0, 0, 93);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(46, 'core', 'letter', 'list', 0, 'ģ������', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(47, 'core', '', '', 0, 'ģ����˵�', 'core-navigation_menu_list', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(48, 'core', 'credit', '', 1, '����', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(49, 'core', 'credit', 'list', 48, '���ֹ���', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(50, 'core', 'credit', 'list_rule', 48, '���ֹ������', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(51, 'core', 'credit', 'cache', 48, '���±��ֻ���', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(52, 'core', 'member', 'list', 1, '��Ա����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(53, 'core', 'member', 'config', 52, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(54, 'core', 'member', 'add', 52, '��ӻ�Ա/����Ա', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(55, 'core', 'member', 'add', 54, '��ӻ�Ա', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(56, 'core', 'member', 'impory', 54, '������ӻ�Ա', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(57, 'core', 'member', 'list', 52, '��Ա����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(58, 'core', 'member', 'recharge', 52, '��Ա��ֵ����', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(59, 'core', 'member', 'recharge', 58, '��Ա��ֵ��¼', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(60, 'core', 'member', 'recharge_card', 58, '��ֵ������', '', '', 1, 0, 0, 86);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(61, 'core', 'member', 'buy_role', 58, '��Ա������¼', '', '', 1, 0, 0, 85);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(62, 'core', 'role', 'list', 52, '��ɫ/Ȩ������', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(63, 'core', 'role', 'list', 62, '��ɫ�б�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(64, 'core', 'role', 'add', 62, '��ӽ�ɫ', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(65, 'core', 'role', 'list_group', 52, '��ɫ�����', '', '', 1, 0, 0, 66);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(66, 'core', 'role', 'list_group', 65, '��ɫ�����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(67, 'core', 'role', 'add_group', 65, '��ӽ�ɫ��', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(68, 'core', 'uploader', '', 1, '�ϴ�����', '', '', 1, 0, 0, 65);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(69, 'core', 'uploader', 'config', 68, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(70, 'core', 'uploader', 'list', 68, '��������', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(71, 'core', 'uploader', 'role_filter', 68, '�ϴ�Ȩ��', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(72, 'core', 'crontab', '', 1, '�ƻ�����', '', '', 1, 0, 0, 60);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(73, 'core', 'crontab', 'list', 72, '�ƻ������б�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(74, 'core', 'crontab', 'add', 72, '��Ӽƻ�����', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(75, 'core', 'label', 'list', 1, '��ǩģ��', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(76, 'core', 'label', 'add', 75, '��ӱ�ǩ', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(77, 'core', 'label', 'list', 75, '��ǩ�б�', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(78, 'core', 'label', 'cache', 75, '���»���', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(79, 'core', 'message', '', 46, 'վ����', '', '', 1, 0, 0, 6);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(80, 'core', 'message', 'list', 79, 'ģ���б�', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(81, 'core', 'pay', '', 46, '֧��', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(82, 'core', 'pay', 'interface', 81, '֧���ӿ�', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(83, 'core', 'pay', 'order', 81, '��������', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(84, 'core', 'mail', '', 46, '�ʼ�ģ��', '', '', 1, 0, 0, 28);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(85, 'core', 'mail', 'config', 84, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(86, 'core', 'mail', 'test', 84, '���ʼ�����', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(87, 'core', '46', '', 46, '���ģ��', 'core/46-list', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(88, 'core', '46', 'add', 87, '��ӹ��', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(89, 'core', '46', 'list', 87, '������', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(90, 'core', '46', 'buy_list', 87, 'Ͷ�Ź���', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(91, 'core', '46', 'cache', 87, '���»���', '', '', 1, 0, 0, 70);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(92, 'core', 'cservice', 'list', 46, '�ͷ�����', '', '', 1, 0, 0, 24);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(93, 'core', 'cservice', 'config', 92, '�ͷ���������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(94, 'core', 'cservice', 'list', 92, '�ͷ����Ĺ���', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(95, 'core', 'dbm', '', 1, '���ݿⱸ��', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(96, 'core', 'dbm', 'manage', 95, '���ݿⱸ��', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(97, 'core', 'dbm', 'restore', 95, '���ݿ⻹ԭ', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(98, 'core', 'discuzx', '', 46, '��̳���ݵ���', '', '', 1, 0, 0, 15);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(99, 'core', 'discuzx', 'config', 98, '����', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(100, 'core', 'forms', 'model', 181, '������', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(101, 'core', 'forms', 'list', 100, '���ݹ���', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(102, 'core', 'forms', 'model', 100, '������', '', '', 1, 0, 0, 66);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(103, 'core', 'forms', 'config', 100, 'ģ������', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(104, 'core', 'friendlink', '', 46, '��������', '', '', 1, 0, 0, 16);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(105, 'core', 'friendlink', 'link', 104, '�������ӹ���', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(106, 'core', 'friendlink', 'sort', 104, '�������ӷ������', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(107, 'core', 'guestbook', 'list', 46, '���Ա�', '', '', 1, 0, 0, 20);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(108, 'core', 'guestbook', 'config', 107, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(109, 'core', 'guestbook', 'list', 107, '���Ա�����', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(110, 'core', 'guestbook', 'category', 107, '���Ա�����', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(111, 'core', 'interview', 'list_subject', 46, '���߷�̸', '', '', 1, 0, 0, 37);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(112, 'core', 'interview', 'config', 111, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(113, 'core', 'interview', 'list_subject', 111, '��̸����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(114, 'core', 'interview', 'add_subject', 111, '��ӷ�̸', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(115, 'core', 'letter', 'list', 46, '�쵼����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(116, 'core', 'letter', 'config', 115, '�쵼��������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(117, 'core', 'letter', 'list', 115, '�쵼�������', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(118, 'core', 'letter', 'statistics', 115, '�쵼����ͳ��', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(119, 'core', 'notify', '', 46, '֪ͨģ��', '', '', 1, 0, 0, 9);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(120, 'core', 'notify', 'add', 119, 'д֪ͨ', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(121, 'core', 'notify', 'list', 119, '֪ͨ����', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(122, 'core', 'notify', 'config', 119, 'ģ������', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(123, 'core', 'opinion', 'item', 46, '�������', '', '', 1, 0, 0, 91);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(124, 'core', 'opinion', 'config', 123, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(125, 'core', 'opinion', 'item', 123, '��Ŀ����', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(126, 'core', 'opinion', 'list', 123, '���ݹ���', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(127, 'core', 'page', 'list', 46, '����ҳ', '', '', 1, 0, 0, 18);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(128, 'core', 'page', 'config', 127, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(129, 'core', 'page', 'list', 127, '����ҳ����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(130, 'core', 'page', 'list', 129, '�������ҳ', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(131, 'core', 'page', 'add', 129, '�½�����ҳ', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(132, 'core', 'shortcutsms', '', 46, '��ݶ��Ź���', '', '', 1, 0, 0, 3);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(133, 'core', 'shortcutsms', 'list', 132, '��ݶ��Ź���', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(134, 'core', 'shortcutsms', 'add', 132, '��ӿ�ݶ���', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(135, 'core', 'sms', '', 46, '�ֻ�����', '', '', 1, 0, 0, 31);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(136, 'core', 'sms', 'list_interface', 135, '�ֻ��ӿ�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(137, 'core', 'sms', 'test', 135, '�ӿڲ���', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(138, 'core', 'special', '', 46, 'ר��ģ��', 'core/special-list', '', 1, 0, 0, 33);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(139, 'core', 'special', 'config', 138, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(140, 'core', 'special', 'add', 138, '���ר��', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(141, 'core', 'special', 'list', 138, 'ר�����', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(142, 'core', 'special', 'add_category', 138, '��ӷ���', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(143, 'core', 'special', 'category_list', 138, '�������', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(144, 'core', 'spider', '', 46, '�ɼ�ģ��', '', '', 1, 0, 0, 14);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(145, 'core', 'spider', 'category', 144, '�������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(146, 'core', 'spider', 'rule', 144, '�������', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(147, 'core', 'spider', 'item', 144, '�ɼ����ݹ���', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(148, 'core', 'survey', 'item', 46, '�ʾ����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(149, 'core', 'survey', 'config', 148, 'ģ������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(150, 'core', 'survey', 'item', 148, '��Ŀ����', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(151, 'core', 'survey', 'list', 148, '���ݹ���', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(152, 'core', 'uchome', '', 47, 'Uchome���ݵ���', '', '', 0, 0, 0, 89);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(153, 'core', 'uchome', 'config', 152, '����', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(154, 'core', 'vote', '', 46, 'ͶƱ', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(155, 'core', 'vote', 'list', 154, 'ͶƱ����', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(156, 'core', 'vote', 'add', 154, '���ͶƱ', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(157, 'core', 'vote', 'cache', 154, '���»���', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(158, 'core', 'xspace', '', 47, 'xspace���ݵ���', '', '', 0, 0, 0, 89);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(159, 'core', 'xspace', 'config', 158, '����', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(160, 'ask', 'category', 'list', 0, '�ʴ�ϵͳ', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(161, 'ask', '', '', 160, 'ϵͳ����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(162, 'ask', '', 'statistics', 161, 'ͳ����Ϣ', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(163, 'ask', '', 'config', 161, 'ϵͳ����', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(164, 'ask', '', 'cache_all', 161, '���»���', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(165, 'ask', 'member', '', 160, '�û�����', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(166, 'ask', 'member', 'list', 165, '�û��б�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(167, 'ask', 'member', 'expertor', 165, 'ר���û�', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(168, 'ask', 'member', 'star', 165, '�ʴ�֮��', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(169, 'ask', 'category', '', 160, '�ʴ����', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(170, 'ask', 'category', 'batch_add', 169, '�������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(171, 'ask', 'category', 'list', 169, '�����б�', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(172, 'ask', 'category', 'cache', 169, '���»���', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(173, 'ask', 'item', '', 160, '�������', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(174, 'ask', 'item', 'list', 173, '�����б�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(175, 'ask', 'item', 'poller', 173, '����Ͷ��', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(176, 'ask', 'item', 'config', 173, 'ģ������', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(177, 'ask', 'item', 'sphinx', 173, 'sphinx����', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(178, 'ask', 'answer', '', 160, '�𰸹���', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(179, 'ask', 'answer', 'list', 178, '���б�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(180, 'ask', 'answer', 'poller', 178, '��Ͷ��', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(181, 'cms', 'item', 'list', 0, '���ݹ���', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(182, 'cms', '', '', 181, '��������', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(183, 'cms', '', 'main?edit_label=1&postfix=index', 182, '��ҳ��ǩ', '', '', 1, 1, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(184, 'cms', '', 'config', 182, 'ϵͳ����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(185, 'cms', 'item', 'mood', 182, '�������', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(186, 'cms', '', '', 181, '���۹���', '', '', 1, 0, 0, 85);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(187, 'cms', 'item', 'comment', 186, '�����б�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(188, 'cms', 'item', 'comment', 187, '�����', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(189, 'cms', 'item', 'comment?verified=0', 187, '�����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(190, 'cms', '', 'html', 181, '��̬��', '', '', 0, 0, 0, 50);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(191, 'cms', '', 'html_all', 190, 'һ����̬��', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(192, 'cms', '', 'index_to_html', 190, '��ҳ��̬��', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(193, 'cms', 'item', 'list_to_html', 190, '��Ŀ&���ݾ�̬��', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(194, 'cms', 'model', '', 181, 'ģ�͹���', '', '', 1, 0, 0, 70);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(195, 'cms', 'model', 'add', 194, '���ģ��', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(196, 'cms', 'model', 'import', 194, '����ģ��', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(197, 'cms', 'model', 'list', 194, 'ģ���б�', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(198, 'cms', 'category', 'list', 181, '��Ŀ����', '', '', 1, 0, 0, 91);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(199, 'cms', 'category', 'add', 198, '�����Ŀ', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(200, 'cms', 'category', 'list', 198, '��Ŀ����', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(201, 'cms', 'category', 'cache', 198, '���»���', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(202, 'cms', 'item', '', 181, '���ݷ���/����', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(203, 'cms', 'item', 'add', 202, '��������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(204, 'cms', 'item', 'list', 202, '��������', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(205, 'cms', 'item', 'list', 204, '��������', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(206, 'cms', 'item', 'list?verified=0', 204, '���������', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(207, 'cms', 'item', 'list?verified=-99', 204, '���δͨ������', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(208, 'cms', 'item', 'attribute_acl', 202, '����Ȩ��', '', '', 1, 0, 0, 65);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(209, 'cms', 'item', 'spider', 202, '�ɼ����', '', '', 1, 0, 0, 60);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(210, 'cms', 'item', 'tag', 202, 'Tag(��ǩ)����', '', '', 1, 0, 0, 59);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(211, 'cms', 'item', 'config', 202, 'ģ������', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(212, 'cms', 'assist_category', '', 181, '����Ŀ����', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(213, 'cms', 'assist_category', 'add', 212, '��Ӹ���Ŀ', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(214, 'cms', 'assist_category', 'list', 212, '����Ŀ����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(215, 'cms', 'assist_category', 'content_list', 212, '����Ŀ���ݹ���', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(216, 'cms', 'statistic', '', 181, '����ͳ��', '', '', 1, 0, 0, 83);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(217, 'cms', 'statistic', 'statistic_data', 216, 'ͳ��', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(218, 'cms', 'statistic', 'statistic_member', 216, '����', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(219, 'cms', 'statistic', 'statistic_cluster', 216, '����ͳ��', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_message` VALUES ('1','system','admin','1','1','0','in','�㷢�����������״̬�иĶ�','�㷢�������ݡ��������μ��Ź�˾�����Ա�����ܾ���ͨ�� ������������:<br />','0','1467879908');
REPLACE INTO `p8_pay_interface` VALUES ('alipay','֧����','0','alipay.gif','a:0:{}');
REPLACE INTO `p8_pay_interface` VALUES ('credit','����(��δ֧��)','0','alipay.gif','a:0:{}');
REPLACE INTO `p8_pay_interface` VALUES ('offline','���¸���','1','unionpay.gif','a:1:{s:4:\"bank\";a:1:{i:0;a:4:{s:4:\"name\";s:18:\"�й���������\";s:7:\"account\";s:13:\"6222*********\";s:5:\"payee\";s:17:\"ĳ����(С��)\";s:4:\"logo\";s:8:\"icbc.gif\";}}}');
REPLACE INTO `p8_pay_interface` VALUES ('tenpay','�Ƹ�ͨ(��δ֧��)','0','tenpay.gif','a:0:{}');
