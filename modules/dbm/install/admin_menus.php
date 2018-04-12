<?php
return array(
	array(
		'name' => '数据库',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 91,
	
		
		'menus' => array(
			array(
				'name' => '数据库备份',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'manage',
				'display_order' => 99
			),
			array(
				'name' => '数据库还原',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'restore',
				'display_order' => 99
			)
		)
	)
);