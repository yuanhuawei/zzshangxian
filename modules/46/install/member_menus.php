<?php
return array(
	array(
		'name' => '广告',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 88,
		'position' => '',
		'display' => 0,
		'menus' => array(
			array(
				'name' => '查看广告位',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99
			),
			
			array(
				'name' => '已投放广告',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'mime',
				'display_order' => 98
			)
		)
	)
);