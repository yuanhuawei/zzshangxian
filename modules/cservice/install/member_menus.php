<?php
return array(
	array(
		'name' => '总裁投诉',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 55,
		'menus' => array(
			array(
				'name' => '投诉管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list'
			),
			array(
				'name' => '我要投诉',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'post'
			)
		)
	)
);