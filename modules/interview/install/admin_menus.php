<?php
return array(
	array(
		'name' => '在线访谈',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 0,
		'position' => 'plugin',
		
		'menus' => array(
			array(
				'name' => '模块设置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '访谈管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list_subject',
				'display_order' => 99
			),array(
				'name' => '添加访谈',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add_subject',
				'display_order' => 98
			)
		)
	)
);