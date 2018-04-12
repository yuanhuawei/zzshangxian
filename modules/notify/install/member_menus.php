<?php
return array(
	array(
		'name' => '通知通讯',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'profile',
		'display_order' => 90,
		'menus' => array(
			array(
				'name' => '写通知',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'target' => '_blank',
				'display_order' => 88
			),
			array(
				'name' => '通知管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'target' => '_blank',
				'display_order' => 77
			),
		)
	)
);