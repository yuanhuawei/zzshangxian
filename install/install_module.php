<?php
defined('PHP168_PATH') or die();

/**
* 安装一个模块
**/

load_language($core, 'config');
load_language($this_module, 'global');
if($this_system->name != 'core' && !$core->systems[$this_system->name]['installed'])
	message('module_of_current_system_not_installed');

require_once PHP168_PATH .'admin/inc/menu.class.php';
require_once PHP168_PATH .'modules/member/inc/menu.class.php';
require_once PHP168_PATH .'install/install.func.php';
require_once PHP168_PATH .'inc/homepage_menu.class.php';

$module_info = get_module($this_system->name, $this_module->name);

//解除模块勾
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



//删除本模块的积分规则
$DB_master->delete(
	$core->TABLE_ .'credit_rule',
	"system = '$this_system->name' AND module = '$this_module->name'"
);

//删除配置
$DB_master->delete($core->TABLE_ .'config', "system = '$this_system->name' AND module = '$this_module->name'");
//删除作用域标签
$DB_master->delete($core->TABLE_ .'label', "system = '$this_system->name' AND module = '$this_module->name'");
//删除调用标签
$DB_master->delete($core->TABLE_ .'label', "source_system = '$this_system->name' AND source_module = '$this_module->name'");

//删除旧的数据
rm(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name);

//在系统安装模块
rm(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name);
md(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name, true);			//模块缓存目录
md(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name .'/acl', true);	//ACL目录
md(CACHE_PATH . $this_system->name .'/modules/'. $this_module->name .'/uninstall', true);	//ACL目录

$DB_master->update(
	$core->TABLE_ .'module',
	array(
		'installed' => 1,
		'enabled' => 1
	),
	"system = '$this_system->name' AND name = '$this_module->name'"
);
if($this_system->name == 'core'){
	$core->modules[$this_module->name]['installed'] = true;
}else{
	$this_system->modules[$this_module->name]['installed'] = true;
}



//数据表
$sql = get_install_sql(
	$DB_master,
	@file_get_contents($this_module->path .'install/sql.php'),
	$this_module->TABLE_,
	true
);

foreach($sql as $v){
	$DB_master->query($v);
}
//数据表


//自定义预安装操作
if(is_file($this_module->path .'install/pre_install.php'))
	include $this_module->path .'install/pre_install.php';


	









//添加菜单
if($admin_menus = @include $this_module->path .'install/admin_menus.php'){
	//转换编码
	$admin_menus = to_installed_charset($admin_menus);
	if($this_system->name == 'core'){
		$first = current($admin_menus);
		//获得核心菜单
		$menu = $admin_menu->get(
			array(
				'system' => $this_system->name,
				'module' => '',
				//检查安装到核心还是插件
				'action' => !empty($first['position']) ? $first['position'] : 'main',
				'parent' => 0
			)
		);
	}else{
		//获得系统菜单
		$menu = $admin_menu->get(
			array(
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'parent' => 0
			)
		);
	}

	//如果当前模块安装过菜单,删掉
	if(
		$menu &&
		$_menu = $admin_menu->get(
			array(
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => '',
				'parent' => $menu['id']
			)
		)
	){
		unset($admin_menu);
		$admin_menu = new P8_Admin_Menu();
		$admin_menu->get_cache();
		$admin_menu->delete($_menu['id']);
	}

	insert_admin_menu($admin_menus, $menu['id']);
	//$admin_menu->cache();
	//添加菜单
}





























//添加菜单
if($member_menus = @include $this_module->path .'install/member_menus.php'){
	//转换编码
	$member_menus = to_installed_charset($member_menus);
	if($this_system->name == 'core'){
		//获得核心菜单
		$menu = $member_menu->get(array(
			'system' => $this_system->name,
			'module' => '',
			'action' => 'main',
			'parent' => 0
		));
	}else{
		//获得系统菜单
		$menu = $member_menu->get(array(
			'system' => $this_system->name,
			'module' => '',
			'action' => '',
			'parent' => 0
		));
	}

	//如果当前模块安装过菜单,删掉
	if(
		$menu &&
		$_menu = $member_menu->get(array(
			'system' => $this_system->name,
			'module' => $this_module->name,
			'action' => '',
			'parent' => $menu['id']
		))
	){
		unset($member_menu);
		$member_menu = new P8_Member_Menu();
		$member_menu->get_cache();
		$member_menu->delete($_menu['id']);
	}

	insert_member_menu($member_menus, $menu['id']);
	//$member_menu->cache();
	//添加菜单
}











//添加菜单
if($homepage_menus = @include $this_module->path .'install/homepage_menus.php'){
	//转换编码
	$homepage_menus = to_installed_charset($homepage_menus);
	if($this_system->name == 'core'){
		//获得核心菜单
		$menu = $homepage_menu->get(
			array(
				'system' => $this_system->name,
				'module' => '',
				'action' => 'main',
				'parent' => 0
			)
		);
	}else{
		//获得系统菜单
		$menu = $homepage_menu->get(
			array(
				'system' => $this_system->name,
				'module' => '',
				'action' => '',
				'parent' => 0
			)
		);
	}

	//如果当前模块安装过菜单,删掉
	if(
		$menu &&
		$_menu = $homepage_menu->get(
			array(
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => '',
				'parent' => $menu['id']
			)
		)
	){
		unset($member_menu);
		$homepage_menu = new P8_Homepage_Menu();
		$homepage_menu->get_cache();
		$homepage_menu->delete($_menu['id']);
	}

	insert_homepage_menu($homepage_menus, $menu['id']);
	$homepage_menu->cache();
	//添加菜单
}





//默认模板
if($this_system->name!= 'core'){
	$this_module->set_config(array(
		'template' => 'default'
	));
}

//权限
if($acls = @include $this_module->path .'install/acls.php'){
	$role = &$core->load_module('role');
	$controller = &$core->controller($role);
	
	foreach($acls as $role_id => $acl){
		$controller->set_acl($this_module, $role_id, $acl);
	}
}

//主页显示块
if($homepage_blocks = @include $this_module->path .'install/homepage_block.php'){
	$homepage_blocks = to_installed_charset($homepage_blocks);
	foreach($homepage_blocks as $name => $v){
		$v['name'] = $name;
		$DB_master->insert($core->TABLE_ .'homepage_block', $v);
	}
}


//自定义完成安装操作
if(is_file($this_module->path .'install/post_install.php'))
	include $this_module->path .'install/post_install.php';






//添加标签
/* if($labels = to_installed_charset(@include $this_module->path .'install/labels.php')){
	$label = &$core->load_module('label');
	$controller = &$core->controller($label);
	
	foreach($labels as $v){
		$controller->add($v);
	}
} */
if(is_file($this_module->path .'install/label_sql.php')){
	$sql = get_install_sql(
		$DB_master,
		@file_get_contents($this_module->path .'install/label_sql.php'),
		$core->TABLE_,
		false
	);

	foreach($sql as $v){
		$DB_master->query($v);
	}
}