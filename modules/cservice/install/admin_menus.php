<?php
return array(
	array(
		'name' => '客服中心',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 92,
		'position' => 'plugin',
		
		'menus' => array(
		array(
				'name' => '客服中心设置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '客服中心管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 88
			)
		)
	)
);