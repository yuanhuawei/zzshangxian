<?php

return array(
		
	'administrator_role' => array(
		'name'		=>	'管理员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['administrator_role_group'],
		'type'		=>	'system'
	),
	'member_role' => array(
		'name'		=>	'普通个人会员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'type'		=>	'system'
	),
	'guest_role' => array(
		'name'		=>	'游客',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'type'		=>	'system'
	),
	
	
	'common_master' => array(
		'name'		=>	'新闻主编',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['administrator_role_group'],
		'type'		=>	'normal'
	),
	'site_editer' => array(
		'name'		=>	'新闻编辑员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['administrator_role_group'],
		'type'		=>	'normal'
	),
	'normal_company_role' => array(
		'name'		=>	'普通企业会员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['company_role_group'],
		'type'		=>	'normal'
	),
	'vip_company_role' => array(
		'name'		=>	'VIP企业会员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['company_role_group'],
		'buyable'	=>	1,
		'type'		=>	'normal'
	),
	
	'vip_role' => array(
		'name'		=>	'VIP个人会员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'buyable'	=>	1,
		'type'		=>	'normal'
	)
);