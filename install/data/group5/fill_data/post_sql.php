-- <?php exit;?>
REPLACE INTO `p8_credit` VALUES ('1','积分','个','','0','100','0','0','a:0:{}');
REPLACE INTO `p8_credit` VALUES ('2','金币','枚','','0','50','0','0','a:0:{}');
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
REPLACE INTO `p8_config` VALUES ('core','','string','site_name','国微集团方案----领先的集团站群系统');
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
REPLACE INTO `p8_config` VALUES ('core','member','serialize','register','a:5:{s:7:\"enabled\";s:1:\"1\";s:7:\"captcha\";s:1:\"0\";s:6:\"verify\";s:1:\"0\";s:5:\"title\";s:28:\"您好，感谢您的注册{sitename}\";s:6:\"notice\";s:220:\"尊敬的{username}:\r\n您已经注册成为{sitename}的会员，请您在发表言论时，遵守当地法律法规。\r\n如果您有什么疑问可以联系管理员，Email: {adminemail}。\r\n你的帐号是：{username}\r\n密码是：{password}\r\n请妥善保存\r\n\r\n{sitename}\r\n{time}\";}');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','safe','a:0:{}');
REPLACE INTO `p8_config` VALUES ('core','member','serialize','administrators','a:3:{s:5:\"admin\";i:1;s:7:\"test111\";i:1;s:6:\"admin2\";i:1;}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','thumb','a:4:{s:7:\"enabled\";s:1:\"1\";s:5:\"width\";s:3:\"328\";s:6:\"height\";s:3:\"247\";s:7:\"quality\";s:2:\"75\";}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','cthumb','a:2:{s:5:\"width\";s:3:\"800\";s:6:\"height\";s:3:\"700\";}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','watermark','a:4:{s:7:\"enabled\";s:1:\"0\";s:4:\"file\";s:20:\"images/watermark.gif\";s:8:\"position\";s:1:\"3\";s:7:\"quality\";s:2:\"75\";}');
REPLACE INTO `p8_config` VALUES ('core','uploader','serialize','enables','a:4:{s:4:\"core\";a:16:{s:5:\"label\";b:1;s:7:\"message\";b:1;i:46;b:1;s:8:\"cservice\";b:1;s:5:\"forms\";b:1;s:10:\"friendlink\";b:1;s:6:\"notify\";b:1;s:4:\"page\";b:1;s:6:\"spider\";b:1;s:4:\"vote\";b:1;s:0:\"\";b:1;s:7:\"special\";b:1;s:6:\"letter\";b:1;s:9:\"interview\";b:1;s:6:\"survey\";b:1;s:7:\"opinion\";b:1;}s:3:\"cms\";a:2:{s:8:\"category\";b:1;s:4:\"item\";b:1;}s:3:\"ask\";a:2:{s:4:\"item\";b:1;s:6:\"answer\";b:1;}s:5:\"sites\";a:3:{s:8:\"category\";b:1;s:4:\"item\";b:1;s:6:\"letter\";b:1;}}');
REPLACE INTO `p8_config` VALUES ('core','pay','serialize','interfaces','a:4:{s:6:\"alipay\";a:4:{s:5:\"alias\";s:9:\"支付宝\";s:4:\"logo\";s:10:\"alipay.gif\";s:7:\"enabled\";i:0;s:6:\"config\";a:0:{}}s:6:\"credit\";a:4:{s:5:\"alias\";s:26:\"余额付款(尚未支持)\";s:4:\"logo\";s:10:\"alipay.gif\";s:7:\"enabled\";i:0;s:6:\"config\";a:0:{}}s:7:\"offline\";a:4:{s:5:\"alias\";s:12:\"线下付款\";s:4:\"logo\";s:12:\"unionpay.gif\";s:7:\"enabled\";i:1;s:6:\"config\";a:1:{s:4:\"bank\";a:1:{i:0;a:4:{s:4:\"name\";s:18:\"中国工商银行\";s:7:\"account\";s:13:\"6222*********\";s:5:\"payee\";s:17:\"某先生(小姐)\";s:4:\"logo\";s:8:\"icbc.gif\";}}}}s:6:\"tenpay\";a:4:{s:5:\"alias\";s:23:\"财付通(尚未支持)\";s:4:\"logo\";s:10:\"tenpay.gif\";s:7:\"enabled\";i:0;s:6:\"config\";a:0:{}}}');
REPLACE INTO `p8_config` VALUES ('core','mail','string','send_type','smtp');
REPLACE INTO `p8_config` VALUES ('core','mail','string','CRLF','rn');
REPLACE INTO `p8_config` VALUES ('core','mail','string','server','smtp.163.com');
REPLACE INTO `p8_config` VALUES ('core','mail','string','port','25');
REPLACE INTO `p8_config` VALUES ('core','mail','string','email','xxx@163.com');
REPLACE INTO `p8_config` VALUES ('core','mail','string','password','***');
REPLACE INTO `p8_config` VALUES ('core','mail','string','logged','1');
REPLACE INTO `p8_config` VALUES ('core','cservice','serialize','cs_category','a:7:{s:17:\"0.461215112494369\";s:9:\"综合问题 \";s:18:\"0.5945602833545108\";s:8:\"学院建议\";s:18:\"0.4329127157751459\";s:8:\"学院投诉\";i:30205;s:8:\"教师评级\";i:31098;s:12:\"科研项目申请\";i:26387;s:8:\"人才推荐\";i:97497;s:14:\"其他咨询与服务\";}');
REPLACE INTO `p8_config` VALUES ('core','discuzx','serialize','db','a:7:{s:4:\"host\";s:9:\"localhost\";s:4:\"user\";s:4:\"user\";s:8:\"password\";s:0:\"\";s:4:\"port\";s:4:\"3306\";s:4:\"name\";s:7:\"discuzx\";s:7:\"charset\";s:3:\"gbk\";s:12:\"table_prefix\";s:4:\"pre_\";}');
REPLACE INTO `p8_config` VALUES ('core','discuzx','string','url','http://www.xxx.com');
REPLACE INTO `p8_config` VALUES ('core','discuzx','string','charset','gbk');
REPLACE INTO `p8_config` VALUES ('core','notify','serialize','status','a:3:{i:1;s:4:\"确定\";i:2;s:4:\"取消\";i:3;s:6:\"不确定\";}');
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
REPLACE INTO `p8_config` VALUES ('core','','serialize','credits','a:2:{i:1;a:5:{s:4:\"name\";s:6:\"积分\";s:4:\"unit\";s:3:\"个\";s:11:\"is_unsigned\";s:1:\"0\";s:9:\"float_bit\";s:1:\"0\";s:3:\"roe\";a:0:{}}i:2;a:5:{s:4:\"name\";s:6:\"金币\";s:4:\"unit\";s:3:\"枚\";s:11:\"is_unsigned\";s:1:\"0\";s:9:\"float_bit\";s:1:\"0\";s:3:\"roe\";a:0:{}}}');
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
REPLACE INTO `p8_config` VALUES ('core','guestbook','string','name','留言本');
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
REPLACE INTO `p8_config` VALUES ('core','','string','copyright','联系方式: MSN: 88888@hotmail.com 邮箱:setpoterheight QQ：888888888 电话：020-8888888 传真：020-88888888');
REPLACE INTO `p8_config` VALUES ('core','','string','copyright_domain','粤ICP备05011111号 ');
REPLACE INTO `p8_config` VALUES ('core','','string','site_close_reason','网站正在维护中...');
REPLACE INTO `p8_config` VALUES ('core','','string','site_description','国微企业级CMS为中国领先的开源CMS平台，专注提供媒学校、企业、局级政府、站群系统等中高端平台');
REPLACE INTO `p8_config` VALUES ('core','','string','site_key_word','国微CMS,政府方案,站群方案,学校方案');
REPLACE INTO `p8_config` VALUES ('core','','string','ShowMenu','1');
REPLACE INTO `p8_config` VALUES ('core','','string','logo','');
REPLACE INTO `p8_config` VALUES ('core','','serialize','language','a:1:{s:5:\"zh-cn\";s:6:\"中文\";}');
REPLACE INTO `p8_config` VALUES ('core','','serialize','templates','a:6:{s:7:\"default\";s:12:\"默认风格\";s:6:\"group1\";s:7:\"group01\";s:6:\"group2\";s:6:\"group2\";s:6:\"group3\";s:6:\"group3\";s:6:\"group4\";s:6:\"group4\";s:6:\"group5\";s:7:\"group05\";}');
REPLACE INTO `p8_config` VALUES ('core','','serialize','mobile_templates','a:4:{s:7:\"default\";s:12:\"默认风格\";s:5:\"group\";s:12:\"集团风格\";s:6:\"school\";s:12:\"school风格\";s:7:\"school2\";s:13:\"school2风格\";}');
REPLACE INTO `p8_config` VALUES ('core','','serialize','member_templates','a:1:{s:7:\"default\";s:12:\"默认风格\";}');
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
REPLACE INTO `p8_navigation_menu` VALUES ('1','core','','','0','核心','','','1','99');
REPLACE INTO `p8_navigation_menu` VALUES ('2','core','','','1','首页','index.php','','0','99');
REPLACE INTO `p8_navigation_menu` VALUES ('3','core','','','1','关于集团','index.php/cms/item-list-category-781.shtml','','1','98');
REPLACE INTO `p8_navigation_menu` VALUES ('5','core','','','1','新闻中心','index.php/cms/item-list-category-1.shtml','','1','86');
REPLACE INTO `p8_navigation_menu` VALUES ('17','core','','#81ca9d','3','集团简介','index.php/cms/item-list-category-781.shtml','','1','30');
REPLACE INTO `p8_navigation_menu` VALUES ('19','core','','','3','发展历程','index.php/cms/item-list-category-780.shtml','','1','20');
REPLACE INTO `p8_navigation_menu` VALUES ('20','core','','','3','领导介绍','index.php/cms/item-list-category-779.shtml','','1','25');
REPLACE INTO `p8_navigation_menu` VALUES ('21','core','','','3','董事长致辞','index.php/cms/item-list-category-810.shtml','','1','28');
REPLACE INTO `p8_navigation_menu` VALUES ('23','core','','','1','产品服务','index.php/cms/item-list-category-67.shtml','','1','88');
REPLACE INTO `p8_navigation_menu` VALUES ('27','core','','','5','专题活动','index.php/cms/item-list-category-44.shtml','','1','20');
REPLACE INTO `p8_navigation_menu` VALUES ('101','core','','','100','自动化解决方案','index.php/cms/item-list-category-68.html','','1','6');
REPLACE INTO `p8_navigation_menu` VALUES ('100','core','','','1','解决方案','index.php/cms/item-list-category-68.html','','1','90');
REPLACE INTO `p8_navigation_menu` VALUES ('95','core','','','1','联系我们','index.php/cms/item-list-category-819.shtml','','0','0');
REPLACE INTO `p8_navigation_menu` VALUES ('54','core','','','3','企业文化','index.php/cms/item-list-category-777.shtml','','1','14');
REPLACE INTO `p8_navigation_menu` VALUES ('55','core','','','5','媒体聚焦','index.php/cms/item-list-category-128.shtml','','1','25');
REPLACE INTO `p8_navigation_menu` VALUES ('76','core','','','23','产品展示','index.php/cms/item-list-category-94.shtml','','1','6');
REPLACE INTO `p8_navigation_menu` VALUES ('78','core','','','23','进出口业务','index.php/cms/item-list-category-93.shtml','','1','4');
REPLACE INTO `p8_navigation_menu` VALUES ('79','core','','','23','在线产品展厅','index.php/cms/item-list-category-55.shtml','','1','8');
REPLACE INTO `p8_navigation_menu` VALUES ('81','core','','','23','客户服务','index.php/cms/item-list-category-68.shtml','','1','2');
REPLACE INTO `p8_navigation_menu` VALUES ('90','core','','','5','集团新闻','index.php/cms/item-list-category-34.shtml','','1','50');
REPLACE INTO `p8_navigation_menu` VALUES ('93','core','','','6','办事指南','index.php/cms/item-list-category-183.shtml','','0','31');
REPLACE INTO `p8_navigation_menu` VALUES ('102','core','','','100','系统管理解决方案','index.php/cms/item-list-category-792.html','','1','1');
REPLACE INTO `p8_navigation_menu` VALUES ('112','core','','','95','联系方式','index.php/cms/item-list-category-820.shtml','','1','18');
REPLACE INTO `p8_navigation_menu` VALUES ('113','core','','','95','投诉建议','index.php/cms/item-list-category-74.shtml','','1','16');
REPLACE INTO `p8_navigation_menu` VALUES ('132','core','','','3','员工风采','index.php/cms/item-list-category-812.shtml','','1','0');
REPLACE INTO `p8_navigation_menu` VALUES ('133','core','','','3','荣誉展示','index.php/cms/item-list-category-778.shtml','','1','16');
REPLACE INTO `p8_navigation_menu` VALUES ('134','core','','','3','厂房设备','index.php/cms/item-list-category-815.shtml','','1','18');
REPLACE INTO `p8_navigation_menu` VALUES ('118','core','','','23','客户案例','index.php/cms/item-list-category-793.shtml','','1','0');
REPLACE INTO `p8_navigation_menu` VALUES ('119','core','','','23','服务网络','index.php/cms/item-list-category-792.shtml','','1','0');
REPLACE INTO `p8_navigation_menu` VALUES ('126','core','','','5','通知公告','index.php/cms/item-list-category-809.shtml','','1','28');
REPLACE INTO `p8_navigation_menu` VALUES ('127','core','','','1','人力资源','index.php/cms/item-list-category-796.shtml','','1','77');
REPLACE INTO `p8_navigation_menu` VALUES ('128','core','','','127','人才政策','index.php/cms/item-list-category-796.shtml','','1','8');
REPLACE INTO `p8_navigation_menu` VALUES ('129','core','','','127','招聘信息','index.php/core/forms-list-mid-78','','1','4');
REPLACE INTO `p8_navigation_menu` VALUES ('130','core','','','127','我要应聘','index.php/cms/item-list-category-798.shtml','','1','2');
REPLACE INTO `p8_navigation_menu` VALUES ('131','core','','','1','招商合作','index.php/cms/item-list-category-818.shtml','','1','84');
TRUNCATE TABLE `p8_member_menu`;
REPLACE INTO `p8_member_acl` VALUES ('cms','','1','','a:0:{}');
REPLACE INTO `p8_member_acl` VALUES ('cms','item','1','','a:1:{s:7:\"actions\";a:11:{s:6:\"search\";b:0;s:4:\"list\";b:0;s:4:\"view\";b:0;s:7:\"comment\";b:0;s:3:\"add\";b:0;s:10:\"autoverify\";b:0;s:6:\"update\";b:0;s:6:\"delete\";b:0;s:6:\"verify\";b:1;s:9:\"attribute\";b:0;s:11:\"create_time\";b:0;}}');
REPLACE INTO `p8_member_menu` VALUES ('1','core','','main','0','','会员中心','u.php/member-center','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('2','core','member','profile','1','','我的资料','','','1','0','11');
REPLACE INTO `p8_member_menu` VALUES ('3','core','member','profile','2','','修改基本信息','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('4','core','member','','1','','支付','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('5','core','member','recharge','4','','充值','','_blank','1','1','0');
REPLACE INTO `p8_member_menu` VALUES ('6','core','member','recharge_log','4','','充值记录','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('7','core','message','','1','','站内消息','','','1','0','13');
REPLACE INTO `p8_member_menu` VALUES ('8','core','message','send','7','','发消息','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('9','core','message','inbox','7','','短消息管理','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('10','core','message','outbox','7','','发件箱','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('11','cms','','','1','','内容管理','','','1','0','15');
REPLACE INTO `p8_member_menu` VALUES ('12','cms','item','add','11','','发布内容','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('14','core','cservice','','1','','投诉建议','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('15','core','cservice','list','14','','投诉管理','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('16','core','cservice','post','14','','我要投诉','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('17','core','forms','','1','','表单管理','','','0','0','4');
REPLACE INTO `p8_member_menu` VALUES ('18','core','forms','intranetforms','17','','表单管理','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('19','core','letter','','1','','领导信箱','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('20','core','letter','list','19','','我写的信件','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('21','core','letter','post','19','','我要写信','','_blank','1','1','0');
REPLACE INTO `p8_member_menu` VALUES ('22','core','letter','manager','19','','信箱管理','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('23','core','notify','profile','1','','通知通讯','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('24','core','notify','add','23','','写通知','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('25','core','notify','list','23','','通知管理','','_blank','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('26','ask','','','0','','问答系统','u.php/ask/item-my_ask','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('27','ask','item','','26','','我的问问','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('28','ask','item','ask','27','','我要提问','','_blank','1','1','0');
REPLACE INTO `p8_member_menu` VALUES ('29','ask','item','my_ask','27','','我的提问','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('30','ask','item','my_favorite','27','','我的收藏','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('31','ask','item','verify','27','','我管理的问题','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('32','ask','answer','','26','','我的回答','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('33','ask','answer','my_answered','32','','我的回答','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('34','ask','answer','verify','32','','我管理的答案','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('35','cms','','','0','','文章管理','u.php/cms/item-my_list','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('36','cms','item','','35','','内容管理','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('38','cms','item','my_list','11','','我发布的内容','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('39','cms','item','verify','11','','我签核的内容','','','1','0','0');
REPLACE INTO `p8_member_menu` VALUES ('40','cms','item','favory','11','','我的内容收藏','','','0','0','0');
REPLACE INTO `p8_member_menu` VALUES ('41','cms','item','my_order','36','','我的订单','','','1','0','0');
TRUNCATE TABLE `p8_admin_menu`;
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(1, 'core', '', 'base_config', 0, '系统设置', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(2, 'core', '', '', 1, '系统配置', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(3, 'core', '', 'base_config', 2, '核心配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(4, 'core', '', 'base_config', 3, '基本配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(5, 'core', '', 'global_config', 3, '全局配置', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(6, 'core', '', 'reg_config', 3, '注册配置', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(7, 'core', '', 'system_list', 2, '系统管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(8, 'core', '', 'module_list', 46, '模块管理', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(9, 'core', '', 'plugin_list', 46, '插件管理', '', '', 1, 0, 0, 66);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(10, 'core', '', '', 2, '服务器管理', '', '', 0, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(11, 'core', '', 'phpinfo', 10, '查看php配置', '', '', 1, 0, 0, 79);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(12, 'core', '', 'db_slave', 10, 'MYSQL 从服务器', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(13, 'core', '', 'memcache', 2, 'memcache 管理', '', '', 0, 0, 0, 44);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(14, 'core', '', 'memcache', 13, 'memcache 配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(15, 'core', '', 'memcached', 13, 'memcache 管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(16, 'core', '', 'cache', 2, '系统缓存', '', '', 1, 0, 0, 44);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(17, 'core', '', 'log', 1, '操作日志', '', '', 1, 0, 0, 33);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(18, 'core', '', 'navigation_menu_list', 47, '菜单管理', '', '', 1, 0, 0, 85);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(19, 'core', '', 'navigation_menu_list', 18, '头部导航', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(20, 'core', '', 'navigation_menu_list', 19, '头部导航管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(21, 'core', '', 'navigation_menu_add', 19, '添加头部导航', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(22, 'core', '', '', 18, '后台菜单', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(23, 'core', '', 'menu_list', 22, '后台菜单管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(24, 'core', '', 'menu_add', 22, '添加后台菜单', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(25, 'core', '', '', 18, '会员中心菜单', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(26, 'core', '', 'member_menu_list', 25, '会员中心菜单管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(27, 'core', '', 'member_menu_add', 25, '添加会员中心菜单', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(28, 'core', '', 'template_system', 47, '模板设置', '', '', 1, 0, 0, 70);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(31, 'core', '', '', 28, '会员中心模板', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(32, 'core', '', 'template_user_center', 31, '会员中心模板', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(33, 'core', '', 'template_user_index', 31, '会员主页模板', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(34, 'core', '', '', 28, '移动模板', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(35, 'core', '', 'template_mobile', 34, '系统模板', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(36, 'core', 'label', 'list', 1, '系统整合', '', '', 1, 0, 0, 45);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(37, 'core', 'member', 'integrate', 36, '系统整合', '', '', 1, 0, 0, 93);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(38, 'core', '', 'area', 1, '地区管理', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(39, 'core', '', 'area', 38, '地区管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(40, 'core', '', '', 1, '安全设置', '', '', 1, 0, 0, 75);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(41, 'core', '', 'stop_ip', 40, 'IP黑名单', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(42, 'core', '', 'allow_ip', 40, 'IP白名单', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(43, 'core', '', 'word_filter', 40, '词语过滤', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(44, 'core', '', 'connection_flood', 40, '防止CC攻击', '', '', 1, 0, 0, 94);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(45, 'core', '', 'md5_files', 40, '文件改动扫描', '', '', 1, 0, 0, 93);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(46, 'core', 'letter', 'list', 0, '模块中心', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(47, 'core', '', '', 0, '模板与菜单', 'core-navigation_menu_list', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(48, 'core', 'credit', '', 1, '币种', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(49, 'core', 'credit', 'list', 48, '币种管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(50, 'core', 'credit', 'list_rule', 48, '币种规则管理', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(51, 'core', 'credit', 'cache', 48, '更新币种缓存', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(52, 'core', 'member', 'list', 1, '会员管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(53, 'core', 'member', 'config', 52, '模块配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(54, 'core', 'member', 'add', 52, '添加会员/管理员', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(55, 'core', 'member', 'add', 54, '添加会员', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(56, 'core', 'member', 'impory', 54, '批量添加会员', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(57, 'core', 'member', 'list', 52, '会员管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(58, 'core', 'member', 'recharge', 52, '会员充值管理', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(59, 'core', 'member', 'recharge', 58, '会员充值记录', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(60, 'core', 'member', 'recharge_card', 58, '充值卡管理', '', '', 1, 0, 0, 86);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(61, 'core', 'member', 'buy_role', 58, '会员升级记录', '', '', 1, 0, 0, 85);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(62, 'core', 'role', 'list', 52, '角色/权限设置', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(63, 'core', 'role', 'list', 62, '角色列表', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(64, 'core', 'role', 'add', 62, '添加角色', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(65, 'core', 'role', 'list_group', 52, '角色组管理', '', '', 1, 0, 0, 66);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(66, 'core', 'role', 'list_group', 65, '角色组管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(67, 'core', 'role', 'add_group', 65, '添加角色组', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(68, 'core', 'uploader', '', 1, '上传设置', '', '', 1, 0, 0, 65);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(69, 'core', 'uploader', 'config', 68, '模块配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(70, 'core', 'uploader', 'list', 68, '附件管理', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(71, 'core', 'uploader', 'role_filter', 68, '上传权限', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(72, 'core', 'crontab', '', 1, '计划任务', '', '', 1, 0, 0, 60);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(73, 'core', 'crontab', 'list', 72, '计划任务列表', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(74, 'core', 'crontab', 'add', 72, '添加计划任务', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(75, 'core', 'label', 'list', 1, '标签模块', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(76, 'core', 'label', 'add', 75, '添加标签', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(77, 'core', 'label', 'list', 75, '标签列表', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(78, 'core', 'label', 'cache', 75, '更新缓存', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(79, 'core', 'message', '', 46, '站内信', '', '', 1, 0, 0, 6);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(80, 'core', 'message', 'list', 79, '模块列表', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(81, 'core', 'pay', '', 46, '支付', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(82, 'core', 'pay', 'interface', 81, '支付接口', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(83, 'core', 'pay', 'order', 81, '订单管理', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(84, 'core', 'mail', '', 46, '邮件模块', '', '', 1, 0, 0, 28);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(85, 'core', 'mail', 'config', 84, '模块设置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(86, 'core', 'mail', 'test', 84, '发邮件测试', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(87, 'core', '46', '', 46, '广告模块', 'core/46-list', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(88, 'core', '46', 'add', 87, '添加广告', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(89, 'core', '46', 'list', 87, '广告管理', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(90, 'core', '46', 'buy_list', 87, '投放管理', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(91, 'core', '46', 'cache', 87, '更新缓存', '', '', 1, 0, 0, 70);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(92, 'core', 'cservice', 'list', 46, '客服中心', '', '', 1, 0, 0, 24);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(93, 'core', 'cservice', 'config', 92, '客服中心设置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(94, 'core', 'cservice', 'list', 92, '客服中心管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(95, 'core', 'dbm', '', 1, '数据库备份', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(96, 'core', 'dbm', 'manage', 95, '数据库备份', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(97, 'core', 'dbm', 'restore', 95, '数据库还原', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(98, 'core', 'discuzx', '', 46, '论坛数据调用', '', '', 1, 0, 0, 15);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(99, 'core', 'discuzx', 'config', 98, '配置', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(100, 'core', 'forms', 'model', 181, '表单内容', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(101, 'core', 'forms', 'list', 100, '内容管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(102, 'core', 'forms', 'model', 100, '表单管理', '', '', 1, 0, 0, 66);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(103, 'core', 'forms', 'config', 100, '模块配置', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(104, 'core', 'friendlink', '', 46, '友情链接', '', '', 1, 0, 0, 16);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(105, 'core', 'friendlink', 'link', 104, '友情链接管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(106, 'core', 'friendlink', 'sort', 104, '友情链接分类管理', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(107, 'core', 'guestbook', 'list', 46, '留言本', '', '', 1, 0, 0, 20);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(108, 'core', 'guestbook', 'config', 107, '模块设置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(109, 'core', 'guestbook', 'list', 107, '留言本管理', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(110, 'core', 'guestbook', 'category', 107, '留言本分类', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(111, 'core', 'interview', 'list_subject', 46, '在线访谈', '', '', 1, 0, 0, 37);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(112, 'core', 'interview', 'config', 111, '模块设置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(113, 'core', 'interview', 'list_subject', 111, '访谈管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(114, 'core', 'interview', 'add_subject', 111, '添加访谈', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(115, 'core', 'letter', 'list', 46, '领导信箱', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(116, 'core', 'letter', 'config', 115, '领导信箱设置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(117, 'core', 'letter', 'list', 115, '领导信箱管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(118, 'core', 'letter', 'statistics', 115, '领导信箱统计', '', '', 1, 0, 0, 87);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(119, 'core', 'notify', '', 46, '通知模块', '', '', 1, 0, 0, 9);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(120, 'core', 'notify', 'add', 119, '写通知', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(121, 'core', 'notify', 'list', 119, '通知管理', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(122, 'core', 'notify', 'config', 119, '模块配置', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(123, 'core', 'opinion', 'item', 46, '意见征集', '', '', 1, 0, 0, 91);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(124, 'core', 'opinion', 'config', 123, '模块设置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(125, 'core', 'opinion', 'item', 123, '项目管理', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(126, 'core', 'opinion', 'list', 123, '内容管理', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(127, 'core', 'page', 'list', 46, '独立页', '', '', 1, 0, 0, 18);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(128, 'core', 'page', 'config', 127, '模块配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(129, 'core', 'page', 'list', 127, '独立页管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(130, 'core', 'page', 'list', 129, '管理独立页', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(131, 'core', 'page', 'add', 129, '新建独立页', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(132, 'core', 'shortcutsms', '', 46, '快捷短信管理', '', '', 1, 0, 0, 3);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(133, 'core', 'shortcutsms', 'list', 132, '快捷短信管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(134, 'core', 'shortcutsms', 'add', 132, '添加快捷短信', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(135, 'core', 'sms', '', 46, '手机短信', '', '', 1, 0, 0, 31);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(136, 'core', 'sms', 'list_interface', 135, '手机接口', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(137, 'core', 'sms', 'test', 135, '接口测试', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(138, 'core', 'special', '', 46, '专题模块', 'core/special-list', '', 1, 0, 0, 33);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(139, 'core', 'special', 'config', 138, '模块配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(140, 'core', 'special', 'add', 138, '添加专题', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(141, 'core', 'special', 'list', 138, '专题管理', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(142, 'core', 'special', 'add_category', 138, '添加分类', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(143, 'core', 'special', 'category_list', 138, '分类管理', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(144, 'core', 'spider', '', 46, '采集模块', '', '', 1, 0, 0, 14);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(145, 'core', 'spider', 'category', 144, '分类管理', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(146, 'core', 'spider', 'rule', 144, '规则管理', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(147, 'core', 'spider', 'item', 144, '采集内容管理', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(148, 'core', 'survey', 'item', 46, '问卷调查', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(149, 'core', 'survey', 'config', 148, '模块设置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(150, 'core', 'survey', 'item', 148, '项目管理', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(151, 'core', 'survey', 'list', 148, '内容管理', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(152, 'core', 'uchome', '', 47, 'Uchome数据调用', '', '', 0, 0, 0, 89);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(153, 'core', 'uchome', 'config', 152, '配置', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(154, 'core', 'vote', '', 46, '投票', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(155, 'core', 'vote', 'list', 154, '投票管理', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(156, 'core', 'vote', 'add', 154, '添加投票', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(157, 'core', 'vote', 'cache', 154, '更新缓存', '', '', 1, 0, 0, 80);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(158, 'core', 'xspace', '', 47, 'xspace数据调用', '', '', 0, 0, 0, 89);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(159, 'core', 'xspace', 'config', 158, '配置', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(160, 'ask', 'category', 'list', 0, '问答系统', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(161, 'ask', '', '', 160, '系统操作', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(162, 'ask', '', 'statistics', 161, '统计信息', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(163, 'ask', '', 'config', 161, '系统配置', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(164, 'ask', '', 'cache_all', 161, '更新缓存', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(165, 'ask', 'member', '', 160, '用户管理', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(166, 'ask', 'member', 'list', 165, '用户列表', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(167, 'ask', 'member', 'expertor', 165, '专家用户', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(168, 'ask', 'member', 'star', 165, '问答之星', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(169, 'ask', 'category', '', 160, '问答分类', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(170, 'ask', 'category', 'batch_add', 169, '分类添加', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(171, 'ask', 'category', 'list', 169, '分类列表', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(172, 'ask', 'category', 'cache', 169, '更新缓存', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(173, 'ask', 'item', '', 160, '问题管理', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(174, 'ask', 'item', 'list', 173, '问题列表', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(175, 'ask', 'item', 'poller', 173, '问题投诉', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(176, 'ask', 'item', 'config', 173, '模块配置', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(177, 'ask', 'item', 'sphinx', 173, 'sphinx配置', '', '', 1, 0, 0, 96);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(178, 'ask', 'answer', '', 160, '答案管理', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(179, 'ask', 'answer', 'list', 178, '答案列表', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(180, 'ask', 'answer', 'poller', 178, '答案投诉', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(181, 'cms', 'item', 'list', 0, '内容管理', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(182, 'cms', '', '', 181, '参数设置', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(183, 'cms', '', 'main?edit_label=1&postfix=index', 182, '首页标签', '', '', 1, 1, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(184, 'cms', '', 'config', 182, '系统配置', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(185, 'cms', 'item', 'mood', 182, '表情管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(186, 'cms', '', '', 181, '评论管理', '', '', 1, 0, 0, 85);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(187, 'cms', 'item', 'comment', 186, '评论列表', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(188, 'cms', 'item', 'comment', 187, '己审核', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(189, 'cms', 'item', 'comment?verified=0', 187, '待审核', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(190, 'cms', '', 'html', 181, '静态化', '', '', 0, 0, 0, 50);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(191, 'cms', '', 'html_all', 190, '一键静态化', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(192, 'cms', '', 'index_to_html', 190, '主页静态化', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(193, 'cms', 'item', 'list_to_html', 190, '栏目&内容静态化', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(194, 'cms', 'model', '', 181, '模型管理', '', '', 1, 0, 0, 70);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(195, 'cms', 'model', 'add', 194, '添加模型', '', '', 1, 0, 0, 90);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(196, 'cms', 'model', 'import', 194, '导入模型', '', '', 1, 0, 0, 97);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(197, 'cms', 'model', 'list', 194, '模型列表', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(198, 'cms', 'category', 'list', 181, '栏目管理', '', '', 1, 0, 0, 91);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(199, 'cms', 'category', 'add', 198, '添加栏目', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(200, 'cms', 'category', 'list', 198, '栏目管理', '', '', 1, 0, 0, 98);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(201, 'cms', 'category', 'cache', 198, '更新缓存', '', '', 1, 0, 0, 100);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(202, 'cms', 'item', '', 181, '内容发布/管理', '', '', 1, 0, 0, 95);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(203, 'cms', 'item', 'add', 202, '发布内容', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(204, 'cms', 'item', 'list', 202, '所有内容', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(205, 'cms', 'item', 'list', 204, '所有内容', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(206, 'cms', 'item', 'list?verified=0', 204, '待审核内容', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(207, 'cms', 'item', 'list?verified=-99', 204, '审核未通过内容', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(208, 'cms', 'item', 'attribute_acl', 202, '属性权限', '', '', 1, 0, 0, 65);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(209, 'cms', 'item', 'spider', 202, '采集入库', '', '', 1, 0, 0, 60);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(210, 'cms', 'item', 'tag', 202, 'Tag(标签)管理', '', '', 1, 0, 0, 59);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(211, 'cms', 'item', 'config', 202, '模块配置', '', '', 1, 0, 0, 55);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(212, 'cms', 'assist_category', '', 181, '副栏目管理', '', '', 0, 0, 0, 0);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(213, 'cms', 'assist_category', 'add', 212, '添加副栏目', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(214, 'cms', 'assist_category', 'list', 212, '副栏目管理', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(215, 'cms', 'assist_category', 'content_list', 212, '副栏目内容管理', '', '', 1, 0, 0, 77);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(216, 'cms', 'statistic', '', 181, '内容统计', '', '', 1, 0, 0, 83);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(217, 'cms', 'statistic', 'statistic_data', 216, '统计', '', '', 1, 0, 0, 99);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(218, 'cms', 'statistic', 'statistic_member', 216, '考核', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_admin_menu` (`id`, `system`, `module`, `action`, `parent`, `name`, `url`, `target`, `display`, `front`, `frequent`, `display_order`) VALUES 
(219, 'cms', 'statistic', 'statistic_cluster', 216, '推送统计', '', '', 1, 0, 0, 88);
REPLACE INTO `p8_message` VALUES ('1','system','admin','1','1','0','in','你发布的内容审核状态有改动','你发布的内容“吴秀章任集团公司党组成员、副总经理”通过 终审。理由如下:<br />','0','1467879908');
REPLACE INTO `p8_pay_interface` VALUES ('alipay','支付宝','0','alipay.gif','a:0:{}');
REPLACE INTO `p8_pay_interface` VALUES ('credit','余额付款(尚未支持)','0','alipay.gif','a:0:{}');
REPLACE INTO `p8_pay_interface` VALUES ('offline','线下付款','1','unionpay.gif','a:1:{s:4:\"bank\";a:1:{i:0;a:4:{s:4:\"name\";s:18:\"中国工商银行\";s:7:\"account\";s:13:\"6222*********\";s:5:\"payee\";s:17:\"某先生(小姐)\";s:4:\"logo\";s:8:\"icbc.gif\";}}}');
REPLACE INTO `p8_pay_interface` VALUES ('tenpay','财付通(尚未支持)','0','tenpay.gif','a:0:{}');
