<?php

return array(
		
	'administrator_role' => array(
		'name'		=>	'����Ա',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['administrator_role_group'],
		'type'		=>	'system'
	),
	'member_role' => array(
		'name'		=>	'��ͨ���˻�Ա',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'type'		=>	'system'
	),
	'guest_role' => array(
		'name'		=>	'�ο�',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'type'		=>	'system'
	),
	
	
	'common_master' => array(
		'name'		=>	'��������',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['administrator_role_group'],
		'type'		=>	'normal'
	),
	'site_editer' => array(
		'name'		=>	'���ű༭Ա',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['administrator_role_group'],
		'type'		=>	'normal'
	),
	'normal_company_role' => array(
		'name'		=>	'��ͨ��ҵ��Ա',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['company_role_group'],
		'type'		=>	'normal'
	),
	'vip_company_role' => array(
		'name'		=>	'VIP��ҵ��Ա',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['company_role_group'],
		'buyable'	=>	1,
		'type'		=>	'normal'
	),
	
	'vip_role' => array(
		'name'		=>	'VIP���˻�Ա',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'buyable'	=>	1,
		'type'		=>	'normal'
	)
);