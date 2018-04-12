<?php
defined('PHP168_PATH') or die();

$role = &$core->load_module('role');

//系统角色{
//$guest_role      = $role->add(to_installed_charset('游客'),         $this_system->name, 'system');
//$member_role     = $role->add(to_installed_charset('普通会员'),     $this_system->name, 'system');
//$vip_role		= $role->add(to_installed_charset('VIP会员'),		$this_system->name, 'system');
//专家
//$expertor_role   = $role->add(to_installed_charset('问答专家'),     $this_system->name, 'normal');
//管理员
//$category_role   = $role->add(to_installed_charset('栏目管理员'),   $this_system->name, 'normal');


/*$this_system->set_config(
	array(
		'guest_role' => $guest_role,
		'member_role' => $member_role,
		'vip_role' => $vip_role,
		'expertor_role' => $expertor_role,
		'category_role' => $category_role		
	)
);*/
//系统角色}

//创建附件表
include PHP168_PATH .'modules/uploader/inc/init_system.php';

//系统配置
include $this_system->path . 'install/config.php';