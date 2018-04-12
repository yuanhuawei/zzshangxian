<?php
return array(
	array(
		'name' => '模型管理',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'manage',
		'display_order' => 70,
		
		'menus' => array(
			array(
				'name' => '添加模型',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'add',
				'display_order' => 99
			),
			array(
				'name' => '导入模型',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'import',
				'display_order' => 97
			),
			array(
				'name' => '模型列表',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 96
			)
		)
	)
);