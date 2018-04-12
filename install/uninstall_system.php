<?php
defined('PHP168_PATH') or die();

/**
* 卸载一个系统
**/

require_once PHP168_PATH .'inc/cache.func.php';

$uploader = &$core->load_module('uploader');
include $uploader->path .'inc/disables.php';

$batch_uninstall = true;
//卸载系统下的模块
foreach($this_system->modules as $k => $v){
	$this_module = &$this_system->load_module($k);
	include PHP168_PATH .'install/uninstall_module.php';
}

//删除表
$pre = str_replace(array('_', '%'), array('\_', '\%'), $this_system->TABLE_);
$query = $DB_master->query("SHOW TABLES LIKE '$pre%'");
$tables = $comma = '';
while($arr = $DB_master->fetch_array($query)){
	$tables .= $comma .'`'. current($arr) .'`';
	$comma = ',';
}
$tables && $DB_master->query("DROP TABLE $tables");

$DB_master->delete($core->TABLE_ .'role',			"system = '$this_system->name'");		//删系统角色
$DB_master->delete($core->TABLE_ .'system',		"name = '$this_system->name'");			//删系统表
$DB_master->delete($core->TABLE_ .'module',		"system = '$this_system->name'");		//删模块表
$DB_master->delete($core->TABLE_ .'config',		"system = '$this_system->name'");		//删除配置
$DB_master->delete($core->TABLE_ .'acl',			"system = '$this_system->name'");		//删除权限
$DB_master->delete($core->TABLE_ .'admin_menu',	"system = '$this_system->name'");		//删除菜单
$DB_master->delete($core->TABLE_ .'member_menu',	"system = '$this_system->name'");		//删除菜单
$DB_master->delete($core->TABLE_ .'homepage_menu',	"system = '$this_system->name'");		//删除菜单
$DB_master->delete($core->TABLE_ .'credit_rule',	"system = '$this_system->name'");		//删除本系统的积分规则
$DB_master->delete($core->TABLE_ .'label',		"system = '$this_system->name'");		//删除本系统的标签
$DB_master->delete($core->TABLE_ .'label',		"source_system = '$this_system->name'");//删除本系统的标签
$DB_master->delete($core->TABLE_ .'homepage_block',"system = '$this_system->name'");		//删除个人主页模块

//自定义操作
if(is_file($this_system->path .'install/uninstall.php'))
	include_once $this_system->path .'install/uninstall.php';

//最后删除文件夹
rm($this_system->path);
rm(CACHE_PATH . $this_system->name .'/');

//后台模板
rm(TEMPLATE_PATH .'admin/'. $this_system->name .'/');
//标签模板
rm(TEMPLATE_PATH .'label/'. $this_system->name .'/');

//模板
foreach($core->CONFIG['templates'] as $k => $v){
	rm(TEMPLATE_PATH . $k .'/'. $this_system->name .'/');
}

//语言包
foreach($core->CONFIG['language'] as $k => $v){
	rm(LANGUAGE_PATH . $k .'/'. $this_system->name .'/');
}


//更新缓存

