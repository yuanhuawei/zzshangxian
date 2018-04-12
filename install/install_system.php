<?php
defined('PHP168_PATH') or die();

/**
* ��װһ��ϵͳ
**/

require_once PHP168_PATH .'admin/inc/menu.class.php';
require_once PHP168_PATH .'admin/inc/navigation_menu.class.php';
require_once PHP168_PATH .'modules/member/inc/menu.class.php';
require_once PHP168_PATH .'install/install.func.php';
require_once PHP168_PATH .'inc/homepage_menu.class.php';

//$system = basename(dirname(__FILE__));

$system_info = get_system($this_system->name);

$system_name = $this_system->name;


//ɾ������
$DB_master->delete($core->TABLE_ .'config', "system = '$this_system->name'");
//ɾ����ϵͳ�Ļ��ֹ���
$DB_master->delete($core->TABLE_ .'credit_rule', "system = '$this_system->name'");
//��ɾ����ϵͳ�Ľ�ɫ�����ظ�
$DB_master->delete($core->TABLE_ .'role', "system = '$this_system->name'");
//ɾ���������ǩ
$DB_master->delete($core->TABLE_ .'label', "system = '$this_system->name'");
//ɾ�����ñ�ǩ
$DB_master->delete($core->TABLE_ .'label', "source_system = '$this_system->name'");












//ɾ���ɵ�
rm(CACHE_PATH . $this_system->name);

//�ں��İ�װϵͳ
md(CACHE_PATH . $this_system->name, true);					//ϵͳ����Ŀ¼
md(CACHE_PATH . $this_system->name .'/modules', true);		//ģ�黺��Ŀ¼
md(CACHE_PATH . $this_system->name .'/acl', true);			//ACLĿ¼
md(CACHE_PATH . $this_system->name .'/uninstall', true);	//ACLĿ¼

$DB_master->update(
	$core->TABLE_ .'system',
	array(
		'installed' => 1,
		'enabled' => 1
	),
	"name = '$this_system->name'"
);

//��װSQL
$sql = get_install_sql(
	$DB_master,
	@file_get_contents($this_system->path .'install/sql.php'),
	$this_system->TABLE_,
	true
);
//��װSQL

foreach($sql as $v){
	$DB_master->query($v);
}

//ϵͳ��ɫ
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
//ϵͳ��ɫ


//��ӻ���
if($credits = to_installed_charset(@include $this_system->path .'install/credits.php')){
	$credit = &$core->load_module('credit');
	$controller = &$core->controller($credit);
	$_config = array();
	foreach($credits as $name => $v){
		$_config[$name] = $controller->add($v);
	}
	
	$core->set_config($_config);
}


//�Զ��尲װԤ����
if(is_file($this_system->path .'install/pre_install.php'))
	include $this_system->path .'install/pre_install.php';


$core->systems[$this_system->name]['installed'] = true;











//�����ǰϵͳ��װ��,ɾ���˵�
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


//�˵�
if($admin_menus = @include $this_system->path .'install/admin_menus.php'){
	//ת������
	$admin_menus = to_installed_charset($admin_menus);
	//��Ӳ˵�
	insert_admin_menu($admin_menus);
}



//�����ǰϵͳ��װ��,ɾ���˵�
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

//�����˵�
if($navigation_menus = @include $this_system->path .'install/navigation_menus.php'){
	//ת������
	$navigation_menus = to_installed_charset($navigation_menus);
	//��Ӳ˵�
	insert_navigation_menu($navigation_menus);
}






















//�����ǰϵͳ��װ��,ɾ���˵�
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

//�˵�
if($member_menus = @include $this_system->path .'install/member_menus.php'){
	//ת������
	$member_menus = to_installed_charset($member_menus);

	//��Ӳ˵�
	insert_member_menu($member_menus);
}





//�����ǰϵͳ��װ��,ɾ���˵�
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


//�˵�
if($homepage_menus = @include $this_system->path .'install/homepage_menus.php'){
	//ת������
	$homepage_menus = to_installed_charset($homepage_menus);
	//��Ӳ˵�
	insert_homepage_menu($homepage_menus);
}









if(!isset($batch_install)){
	//���ð�װ˳��
	$install_order = include $this_system->path .'modules/install_order.php';

	//��װϵͳ�µ�ģ��
	foreach($install_order as $v){
		$this_module = &$this_system->load_module($v);
		include PHP168_PATH .'install/install_module.php';
	}
}
$admin_menu->cache();
$member_menu->cache();
//��װϵͳ��ģ��



//��ӱ�ǩ
/*  if($labels = to_installed_charset(@include $this_system->path .'install/labels.php')){
	$label = &$core->load_module('label');
	$controller = &$core->controller($label);
	
	foreach($labels as $v){
		$controller->add($v);
	}
} */ 
//�������
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

//Ĭ��ģ��
$this_system->set_config(array(
	'template' => 'default'
));


//Ȩ��
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


//�Զ��尲װ��ɲ���
if(is_file($this_system->path .'install/post_install.php'))
	include $this_system->path .'install/post_install.php';
