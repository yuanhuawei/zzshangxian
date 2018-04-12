<?php
return array(
	array(
		'name' => '友情链接',
		'system' => $this_system->name,
		'module' => $this_module->name,
		'action' => '',
		'display_order' => 78,
		'position' => 'plugin',
		
		'menus' => array(
			array(
				'name' => '友情链接管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'link',
				'display_order' => 99
			),
			array(
				'name' => '友情链接分类管理',
				'system' => $this_system->name,
				'module' => $this_module->name,
				'action' => 'sort',
				'display_order' => 98
			)
		)
	)
);