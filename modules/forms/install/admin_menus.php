<?php
return array(
	array(
		'name' => '万能表单',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => 'list',
		'display_order' => 96,
		'position' => 'plugin',
		'menus' => array(
			array(
				'name' => '内容管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 99,
			),
					
			array(
				'name' => '表单管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'model',
				'display_order' => 66
			),
			
			array(
				'name' => '模块配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 55
			)
		)
	)
);