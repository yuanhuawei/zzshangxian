<?php
defined('PHP168_PATH') or die();

/**
* ж��һ��ϵͳ
**/

require_once PHP168_PATH .'inc/cache.func.php';

$uploader = &$core->load_module('uploader');
include $uploader->path .'inc/disables.php';

$batch_uninstall = true;
//ж��ϵͳ�µ�ģ��
foreach($this_system->modules as $k => $v){
	$this_module = &$this_system->load_module($k);
	include PHP168_PATH .'install/uninstall_module.php';
}

//ɾ����
$pre = str_replace(array('_', '%'), array('\_', '\%'), $this_system->TABLE_);
$query = $DB_master->query("SHOW TABLES LIKE '$pre%'");
$tables = $comma = '';
while($arr = $DB_master->fetch_array($query)){
	$tables .= $comma .'`'. current($arr) .'`';
	$comma = ',';
}
$tables && $DB_master->query("DROP TABLE $tables");

$DB_master->delete($core->TABLE_ .'role',			"system = '$this_system->name'");		//ɾϵͳ��ɫ
$DB_master->delete($core->TABLE_ .'system',		"name = '$this_system->name'");			//ɾϵͳ��
$DB_master->delete($core->TABLE_ .'module',		"system = '$this_system->name'");		//ɾģ���
$DB_master->delete($core->TABLE_ .'config',		"system = '$this_system->name'");		//ɾ������
$DB_master->delete($core->TABLE_ .'acl',			"system = '$this_system->name'");		//ɾ��Ȩ��
$DB_master->delete($core->TABLE_ .'admin_menu',	"system = '$this_system->name'");		//ɾ���˵�
$DB_master->delete($core->TABLE_ .'member_menu',	"system = '$this_system->name'");		//ɾ���˵�
$DB_master->delete($core->TABLE_ .'homepage_menu',	"system = '$this_system->name'");		//ɾ���˵�
$DB_master->delete($core->TABLE_ .'credit_rule',	"system = '$this_system->name'");		//ɾ����ϵͳ�Ļ��ֹ���
$DB_master->delete($core->TABLE_ .'label',		"system = '$this_system->name'");		//ɾ����ϵͳ�ı�ǩ
$DB_master->delete($core->TABLE_ .'label',		"source_system = '$this_system->name'");//ɾ����ϵͳ�ı�ǩ
$DB_master->delete($core->TABLE_ .'homepage_block',"system = '$this_system->name'");		//ɾ��������ҳģ��

//�Զ������
if(is_file($this_system->path .'install/uninstall.php'))
	include_once $this_system->path .'install/uninstall.php';

//���ɾ���ļ���
rm($this_system->path);
rm(CACHE_PATH . $this_system->name .'/');

//��̨ģ��
rm(TEMPLATE_PATH .'admin/'. $this_system->name .'/');
//��ǩģ��
rm(TEMPLATE_PATH .'label/'. $this_system->name .'/');

//ģ��
foreach($core->CONFIG['templates'] as $k => $v){
	rm(TEMPLATE_PATH . $k .'/'. $this_system->name .'/');
}

//���԰�
foreach($core->CONFIG['language'] as $k => $v){
	rm(LANGUAGE_PATH . $k .'/'. $this_system->name .'/');
}


//���»���

