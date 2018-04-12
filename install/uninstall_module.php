<?php
defined('PHP168_PATH') or die();

/**
* ж��һ��ģ��
**/

//���ģ�鹴
if(isset($this_system->CONFIG['_hook_modules'][$this_module->name])){
	foreach($this_system->CONFIG['_hook_modules'][$this_module->name] as $system => $v){
		foreach($v as $module => $vv){
			$this_module->unhook($system, $module);
		}
	}
}

if(isset($this_system->CONFIG['hook_modules'][$this_module->name])){
	
	foreach($this_system->CONFIG['hook_modules'][$this_module->name] as $system => $v){
		foreach($v as $module => $vv){
			if($system == 'core'){
				$m = &$core->load_module($module);
			}else{
				$s = &$core->load_system($system);
				$m = &$s->load_module($module);
			}
			
			$m->unhook($this_system->name, $this_module->name);
		}
	}
}

$uploader = &$core->load_module('uploader');
include $uploader->path .'inc/disables.php';

//ɾ����
$pre = str_replace(array('_', '%'), array('\_', '\%'), $this_module->TABLE_);
$query = $DB_master->query("SHOW TABLES LIKE '$pre%'");
$tables = $comma = '';
while($arr = $DB_master->fetch_array($query)){
	$tables .= $comma .'`'. current($arr) .'`';
	$comma = ',';
}
$tables && $DB_master->query("DROP TABLE $tables");


$DB_master->delete($core->TABLE_ .'module',		"system = '$this_system->name' AND name = '$this_module->name'");	//ɾģ���
$DB_master->delete($core->TABLE_ .'config',		"system = '$this_system->name' AND module = '$this_module->name'");	//ɾ������
$DB_master->delete($core->TABLE_ .'acl',			"system = '$this_system->name' AND module = '$this_module->name'");		//ɾ��Ȩ��
$DB_master->delete($core->TABLE_ .'admin_menu',	"system = '$this_system->name' AND module = '$this_module->name'");//ɾ���˵�
$DB_master->delete($core->TABLE_ .'member_menu',	"system = '$this_system->name' AND module = '$this_module->name'");//ɾ���˵�
$DB_master->delete($core->TABLE_ .'homepage_menu', "system = '$this_system->name' AND module = '$this_module->name'");//ɾ���˵�
$DB_master->delete($core->TABLE_ .'credit_rule',	"system = '$this_system->name' AND module = '$this_module->name'");		//ɾ����ģ��Ļ��ֹ���
$DB_master->delete($core->TABLE_ .'label',		"system = '$this_system->name' AND module = '$this_module->name'");		//ɾ����ģ��ı�ǩ
$DB_master->delete($core->TABLE_ .'label',		"source_system = '$this_system->name' AND source_module = '$this_module->name'");		//ɾ����ģ��ı�ǩ
$DB_master->delete($core->TABLE_ .'homepage_block', "system = '$this_system->name' AND module = '$this_module->name'");		//��ҳģ��

//�Զ������
if(is_file($this_module->path .'install/uninstall.php'))
	include_once $this_module->path .'install/uninstall.php';


//ɾ���ļ���
rm($this_module->path);
rm(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name .'/');

//��̨ģ��
rm(TEMPLATE_PATH .'admin/'. $this_system->name .'/'. $this_module->name .'/');
//��ǩģ��
rm(TEMPLATE_PATH .'label/'. $this_system->name .'/'. $this_module->name .'/');

//ģ��
foreach($core->CONFIG['templates'] as $k => $v){
	rm(TEMPLATE_PATH . $k .'/'. $this_system->name .'/'. $this_module->name .'/');
}

//���԰�
foreach($core->CONFIG['language'] as $k => $v){
	rm(LANGUAGE_PATH . $k .'/'. $this_system->name .'/'. $this_module->name .'/');
}
