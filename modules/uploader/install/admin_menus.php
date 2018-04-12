<?php
return array(
	array(
		'name' => '上传模块',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 94,
		'display' => S_version() == 'company' ? 0 : 1,
		'menus' => array(
			array(
				'name' => '模块配置',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'config',
				'display_order' => 99
			),
			array(
				'name' => '附件管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'list',
				'display_order' => 98
			),
			array(
				'name' => '上传权限',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'role_filter',
				'display_order' => 97
			)
			
		)
	)
);