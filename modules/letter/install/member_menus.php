<?php
return array(
	array(
		'name' => '领导信箱',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 55,
		'menus' => array(
			array(
				'name' => '我写的信件',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list'
			),
			array(
				'name' => '我要写信',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'target'=> '_blank',
				'front' => 1,
				'action' => 'post'
			),
			array(
				'name' => '信箱管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'target'=> '_blank',
				'action' => 'manager'
			)
		)
	)
);