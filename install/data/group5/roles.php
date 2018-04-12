<?php

return array(
		
	'administrator_role' => array(
		'name'		=>	'管理员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['administrator_role_group'],
		'type'		=>	'system'
	),
	'member_role' => array(
		'name'		=>	'学生会员',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'type'		=>	'system'
	),
	'guest_role' => array(
		'name'		=>	'游客',
		'system'	=>	'core',
		'gid'		=>	$core->CONFIG['person_role_group'],
		'type'		=>	'system'
	)
);