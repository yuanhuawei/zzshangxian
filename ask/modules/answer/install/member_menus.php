<?php
return array(
	array(
		'name' => '我的回答',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 90,
		
		'menus' => array(
				array(
				'name' => '我的回答',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'my_answered',
				'display_order' => 96
			),
			array(
				'name' => '我管理的答案',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'verify',
				'display_order' => 90
			)
		)
	)
);