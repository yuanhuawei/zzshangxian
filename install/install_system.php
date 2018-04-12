<?php
defined('PHP168_PATH') or die();

/**
* 安装一个系统
**/

require_once PHP168_PATH .'admin/inc/menu.class.php';
require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';
require_once PHP168_PATH .'modules/member/inc/menu.class.php';
require_once PHP168_PATH .'install/install.func.php';
require_once PHP168_PATH .'inc/homepage_menu.class.php';

//$system = basename(dirname(__FILE__));

$system_info = get_system($this_system->name);

$system_name = $this_system->name;


//删除配置
$DB_master->delete($core->TABLE_ .'config', "system = '$this_system->name'");
//删除本系统的积分规则
$DB_master->delete($core->TABLE_ .'credit_rule', "system = '$this_system->name'");
//先删除本系统的角色以免重复
$DB_master->delete($core->TABLE_ .'role', "system = '$this_system->name'");
//删除作用域标签
$DB_master->delete($core->TABLE_ .'label', "system = '$this_system->name'");
//删除调用标签
$DB_master->delete($core->TABLE_ .'label', "source_system = '$this_system->name'");












//删除旧的
rm(CACHE_PATH . $this_system->name);

//在核心安装系统
md(CACHE_PATH . $this_system->name, true);					//系统缓存目录
md(CACHE_PATH . $this_system->name .'/modules', true);		//模块缓存目录
md(CACHE_PATH . $this_system->name .'/acl', true);			//ACL目录
md(CACHE_PATH . $this_system->name .'/uninstall', true);	//ACL目录

$DB_master->update(
	$core->TABLE_ .'system',
	array(
		'installed' => 1,
		'enabled' => 1
	),
	"name = '$this_system->name'"
);

//安装SQL
$sql = get_install_sql(
	$DB_master,
	@file_get_contents($this_system->path .'install/sql.php'),
	$this_system->TABLE_,
	true
);
//安装SQL

foreach($sql as $v){
	$DB_master->query($v);
}

//系统角色
if($roles = to_installed_charset(@include $this_system->path .'install/roles.php')){
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	$_config = array();
	foreach($roles as $name => $v){
		$v['system'] = empty($core->CONFIG['use_core_roles_only']) ? $this_system->name : 'core';
		$_config[$name] = $controller->add($v);
	}
	
	$this_system->set_config($_config);
}
//系统角色


//添加积分
if($credits = to_installed_charset(@include $this_system->path .'install/credits.php')){
	$credit = &$core->load_module('credit');
	$controller = &$core->controller($credit);
	$_config = array();
	foreach($credits as $name => $v){
		$_config[$name] = $controller->add($v);
	}
	
	$core->set_config($_config);
}


//自定义安装预操作
if(is_file($this_system->path .'install/pre_install.php'))
	include $this_system->path .'install/pre_install.php';


$core->systems[$this_system->name]['installed'] = true;











//如果当前系统安装过,删掉菜单
if(
	$_menu = $admin_menu->get(
		array(
			'system' => $this_system->name,
			'module' => '',
			'action' => '',
			'parent' => 0
		)
	)
){
	$admin_menu->get_cache();
	$admin_menu->delete($_menu['id']);
}


//菜单
if($admin_menus = @include $this_system->path .'install/admin_menus.php'){
	//转换编码
	$admin_menus = to_installed_charset($admin_menus);
	//添加菜单
	insert_admin_menu($admin_menus);
}



//如果当前系统安装过,删掉菜单
if(
	$_menu = $navigation_menu->get(
		array(
			'system' => $this_system->name,
			'module' => '',
			'action' => '',
			'parent' => 0
		)
	)
){
	$navigation_menu->get_cache();
	$navigation_menu->delete($_menu['id']);
}

//导航菜单
if($navigation_menus = @include $this_system->path .'install/navigation_menus.php'){
	//转换编码
	$navigation_menus = to_installed_charset($navigation_menus);
	//添加菜单
	insert_navigation_menu($navigation_menus);
}






















//如果当前系统安装过,删掉菜单
if(
	$_menu = $member_menu->get(
		array(
			'system' => $this_system->name,
			'module' => '',
			'action' => '',
			'parent' => 0
		)
	)
){
	$member_menu->get_cache();
	$member_menu->delete($_menu['id']);
}

//菜单
if($member_menus = @include $this_system->path .'install/member_menus.php'){
	//转换编码
	$member_menus = to_installed_charset($member_menus);

	//添加菜单
	insert_member_menu($member_menus);
}





//如果当前系统安装过,删掉菜单
if(
	$_menu = $homepage_menu->get(
		array(
			'system' => $this_system->name,
			'module' => '',
			'action' => '',
			'parent' => 0
		)
	)
){
	$homepage_menu->get_cache();
	$homepage_menu->delete($_menu['id']);
}


//菜单
if($homepage_menus = @include $this_system->path .'install/homepage_menus.php'){
	//转换编码
	$homepage_menus = to_installed_charset($homepage_menus);
	//添加菜单
	insert_homepage_menu($homepage_menus);
}









if(!isset($batch_install)){
	//调用安装顺序
	$install_order = include $this_system->path .'modules/install_order.php';

	//安装系统下的模块
	foreach($install_order as $v){
		$this_module = &$this_system->load_module($v);
		include PHP168_PATH .'install/install_module.php';
	}
}
$admin_menu->cache();
$member_menu->cache();
//安装系统下模块



//添加标签
/*  if($labels = to_installed_charset(@include $this_system->path .'install/labels.php')){
	$label = &$core->load_module('label');
	$controller = &$core->controller($label);
	
	foreach($labels as $v){
		$controller->add($v);
	}
} */ 
//填充数据
if(is_file($this_system->path .'install/label_sql.php')){
	$sql = get_install_sql(
		$DB_master,
		@file_get_contents($this_system->path .'install/label_sql.php'),
		$core->TABLE_,
		false
	);

	foreach($sql as $v){
		$DB_master->query($v);
	}
}

//默认模板
$this_system->set_config(array(
	'template' => 'default'
));


//权限
if($acls = @include $this_system->path .'install/acls.php'){
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	
	foreach($acls as $role_id => $acl){
		$controller->set_acl($this_system, $role_id, $acl);
	}
}

if($homepage_blocks = @include $this_system->path .'install/homepage_block.php'){
	foreach($homepage_blocks as $name => $v){
		$v['name'] = $name;
		$DB_master->insert($core->TABLE_ .'homepage_block', $v);
	}
}


//自定义安装完成操作
if(is_file($this_system->path .'install/post_install.php'))
	include $this_system->path .'install/post_install.php';
