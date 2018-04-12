<?php

require './inc/init.php';
header('Content-type: text/html; charset=gbk');
require_once PHP168_PATH .'install/install.func.php';


@set_time_limit(0);
error_reporting(E_ALL);
$core->CONFIG['debug'] = 1;


$sql = "
ALTER TABLE `p8_cms_item` ADD COLUMN `verifier`  varchar(50) NOT NULL DEFAULT '' AFTER `verified`;
ALTER TABLE `p8_cms_item` ADD COLUMN `verify_time` int(10) unsigned NOT NULL default '0' AFTER `verified`;
ALTER TABLE `p8_cservice_` MODIFY COLUMN `mobilephone`  varchar(20) NOT NULL DEFAULT '0' AFTER `username`;
ALTER TABLE `p8_letter_data` ADD INDEX `item_id` (`item_id`);
ALTER TABLE `p8_cms_item_unverified` ADD COLUMN `push_item_id`  int(11) NOT NULL AFTER `push_back_reason`;
ALTER TABLE `p8_sites_letter_data` ADD COLUMN `site`  varchar(50) NOT NULL AFTER `turntig`;
UPDATE p8_sites_letter_data AS sd LEFT JOIN p8_sites_letter_item AS si ON si.id=sd.item_id SET sd.site=si.site;
ALTER TABLE `p8_cms_category` ADD COLUMN `html_list_url_rule_mobile`  varchar(255) NOT NULL DEFAULT '' AFTER `html_list_url_rule`;
ALTER TABLE `p8_cms_category` ADD COLUMN `html_view_url_rule_mobile`  varchar(255) NOT NULL DEFAULT '' AFTER `html_view_url_rule`;
UPDATE p8_cms_category SET html_list_url_rule_mobile='{\$core_m_url}/{\$id}/#list-{\$page}.shtml#', html_view_url_rule_mobile='{\$core_m_url}/{\$cid}/{\$Y}-{\$m}-{\$d}/content-{\$id}#-{\$page}#.shtml';
ALTER TABLE `p8_label` ADD COLUMN `env`  varchar(10) NOT NULL DEFAULT '' AFTER `site`;
ALTER TABLE `p8_label` DROP INDEX `system`;
ALTER TABLE `p8_label` ADD UNIQUE INDEX `system` (`system`, `module`, `postfix`, `name`, `site`, `env`) USING BTREE ;
";

$sql = get_install_sql($DB_master, $sql, $core->TABLE_, true);
foreach($sql as $v){
	$DB_master->query($v);
}

if(isset($core->systems['sites']) && $core->systems['sites']['installed']){
	$sites  = $core->load_system('sites');
	$office_model = $sites->get_models();
	$sql = '';
	foreach($office_model as $key=>$val){
		$sql .= "ALTER TABLE p8_sites_item_{$key}_addon ADD COLUMN `site` varchar(50) NOT NULL DEFAULT '';
		UPDATE p8_sites_item_{$key}_addon AS siad LEFT JOIN p8_sites_item AS si ON si.id=siad.iid SET siad.site=si.site;
		";
	}
	$sql = get_install_sql($DB_master, $sql, $core->TABLE_, true);
	foreach($sql as $v){
		$DB_master->query($v);
	}
}

$premenu = $DB_master->fetch_one("select * from {$core->TABLE_}admin_menu where system='core' and name='模板管理'");
$pid = $DB_master->insert($core->TABLE_.'admin_menu', array('system'=>'core','parent'=>$premenu['id'],'name'=>'移动模板','display'=>1),array('return_id'=>1));
$sid = $DB_master->insert($core->TABLE_.'admin_menu', array('system'=>'core','parent'=>$pid,'name'=>'移动模板','action'=>'template_mobile','display'=>1));

$core->set_config(array('murl'=>$core->url.'/m','mobile_template' => 'mobile/default'));	


$core->set_config(array('build' => '20151001'));
echo '补丁完成，如有错误可忽略!';